<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Encryption\Paydecrypt;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\API_UserApplyTopUpRequest;
use App\Http\Requests\API_UserUpdateTopUpRequest;
use App\Http\Requests\StoreTopUpRequest;
use App\Http\Requests\UpdateTopUpRequest;
use App\Http\Resources\Admin\TopUpResource;
use App\Models\Currency;
use App\Models\GateSavingAccount;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\SavingAccount;
use App\Models\TopUp;
use Doctrine\DBAL\Abstraction\Result;
use Exception;
use Gate;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Empty_;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Encryption\Payencrypt;
use App\Models\Payout;
use App\Models\Settlement;
use App\Models\WhitelistIpAddress;
use Carbon\Carbon;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TopUpApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        // abort_if(Gate::denies('deposit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TopUpResource(TopUp::with(['merchant', 'gate'])->get());
    }

    public function store(StoreTopUpRequest $request)
    {
        $topUp = TopUp::create($request->all());

        if ($request->input('payment_slip', false)) {
            $topUp->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
        }

        return (new TopUpResource($topUp))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TopUp $topUp)
    {
        abort_if(Gate::denies('deposit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TopUpResource($topUp->load(['merchant', 'gate']));
    }

    public function update(UpdateTopUpRequest $request, TopUp $topUp)
    {
        $topUp->update($request->all());

        if ($request->input('payment_slip', false)) {
            if (!$topUp->payment_slip || $request->input('payment_slip') !== $topUp->payment_slip->file_name) {
                if ($topUp->payment_slip) {
                    $topUp->payment_slip->delete();
                }

                $topUp->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
            }
        } elseif ($topUp->payment_slip) {
            $topUp->payment_slip->delete();
        }

        return (new TopUpResource($topUp))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TopUp $topUp)
    {
        abort_if(Gate::denies('deposit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topUp->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function top_up_user(API_UserApplyTopUpRequest $request)
    {

        $gate_id = $request->input('gate_id');
        $client_transaction = $request->input('client_transaction');

        $secret_key = $request->input('secret_key');
        $product_key = $request->input('product_key');

        //使用gate 找出merchant id
        $Product_db = Product::find($gate_id);

        if (empty($Product_db)) {
            //无效gate
            Log::info("[" . $request->path() . "]" . '无效gate');

            return  $this->res_format(10000, $this->api_ret_msg('api.gate'));
        };

        $verify_res = $Product_db->verify_key($secret_key, $product_key);

        if (!$verify_res) {

            Log::info("[" . $request->path() . "]" . '验证 secret_key && product_key 失败');

            return  $this->res_format(10001, $this->api_ret_msg('api.error'));
        }

        try {
            $currency_db = $Product_db->currency;
        } catch (Exception $e) {
            Log::info("[" . $request->path() . "]" . '这个project找不到货币');
            return  $this->res_format(10002, $this->api_ret_msg('api.error'));
        }

        $insert_data = $request->validated();

        $insert_data['status'] = 0; // 状态是0 申请状态
        $insert_data['merchant_id'] = $Product_db->merchant_id; // merchant id
        $insert_data['expire_time'] = now()->addMinute(env('TOP_UP_EXRIRE_TIME'));

        do {
            $pass = false;

            $insert_data['document_no'] = Str::random(16);

            $res_sign = TopUp::where('document_no', '=', $insert_data['document_no'])->count();

            if ($res_sign <= 0) {
                $pass = true;
            }
        } while (!$pass);

        $find_bank = find_bank($gate_id, $insert_data['amount']);

        if ($find_bank['status'] != true) {

            Log::info("[" . $request->path() . "]" . 'Saving Account Not Found', $find_bank['reason']);
            return  $this->res_format(10003, $this->api_ret_msg('api.error'));
        }

        $product_saving_account = $find_bank['bank'];

        $redirect_url = "";

        if (!empty($request['redirect_url']) || ($request['redirect_url'] != null)) {
            $redirect_url = $insert_data['redirect_url'];
        } else {
            $redirect_url = $Product_db->redirect_url;
        }

        $processing_fee = $Product_db->processing_fee($insert_data['amount'], "top_up");

        $insert_data['processing_fee'] = $processing_fee['fee'];
        $insert_data['processing_rate'] = $processing_fee['config_rate'];
        $insert_data['processing_fix'] = $processing_fee['config_fix'];

        $insert_data['ip_user'] = $request->ip();

        $insert_data['saving_account_id'] = $product_saving_account['id'];

        $insert_data['currency_id'] = $Product_db->currency_id;

        $signature = [
            'bank_name' => $product_saving_account['bank_name'],
            'bank_account_name' => $product_saving_account['bank_account_name'],
            'bank_account_number' => $product_saving_account['bank_account_number'],
            'transaction_limit' => $product_saving_account['transaction_limit'],
            'currency_id' => $product_saving_account['currency_id'],
            'currency' => $currency_db->name,
            'amount' => $insert_data['amount'],
            'document_no' => $insert_data['document_no'],
            'client_transaction' => $client_transaction,
            'redirect_url' => $redirect_url,
            'reply_time' => now()->timestamp,
            'expire_time' => now()->addMinute(env('TOP_UP_EXRIRE_TIME'))->timestamp,
        ];

        $insert_data['signature'] = Payencrypt::payencrypt2($signature, $Product_db->secret_key, $Product_db->product_key); //data, payment secret key, payment product key.

        try {
            $topUp = TopUp::create($insert_data);
        } catch (Exception $e) {

            Log::info("[" . $request->path() . "]" . 'update failed', $e);
            return $this->res_format(10004, $this->api_ret_msg('api.failed'));
        }

        $res_data = array(
            'call_back_url' => env('API_HOST') . "/#topup/?signature=" . urlencode($topUp['signature']) . "&secret_key=" . $Product_db->secret_key . "&product_key=" . $Product_db->product_key,
        );

        $res = $this->res_format(0, $this->api_ret_msg('api.success'), $res_data);

        return (new TopUpResource($res))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update_top_up_user(API_UserUpdateTopUpRequest $request, TopUp $topUp)
    {
        $topUp_model = $topUp::where("document_no", $request->document_no)->first();

        if (empty($topUp_model) || $topUp_model->document_no != $request->document_no) {
            return $this->res_format(10009, $this->api_ret_msg('api.invalid_top_up'));
        }

        if ((strtotime($topUp_model->expire_time)) < now()->timestamp || $topUp_model->status == 9) {
            return $this->res_format(10010, $this->api_ret_msg('api.expired'));
        }

        if ($topUp_model->status != 0) {
            //不是initial的全部reject
            return $this->res_format(10012, $this->api_ret_msg('api.failed'));
        }

        if ($request->hasFile('payment_slip')) {
            $topUp_model->addMedia($request->file('payment_slip'))->usingName("TPUP" . time())->toMediaCollection('topUp', 's3');
        }

        $update_data = $request->only('remark', 'user_name');

        $update_data['status'] = 5; // pending
        $update_data['ip_user'] = $request->ip();
        $update_data['user_update_time'] = now();

        $update = $topUp_model->update($update_data); // 要改的

        if (!$update) {
            return $this->res_format(10011, $this->api_ret_msg('api.update_failed'));
        }

        $res_data = [
            'redirect_url' => $topUp_model->redirect_url,
        ];

        return $this->res_format(0, $this->api_ret_msg('api.update_success'), $res_data);
    }

    public function test(Request $request)
    {

        $encryption = Payencrypt::payencrypt($request->all(), '1111111111111111', '1111111111111111');

        return $encryption;
    }
}
