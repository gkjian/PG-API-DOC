<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Encryption\Paydecrypt;
use App\Encryption\Payencrypt;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\API_UserApplyPayoutRequest;
use App\Http\Requests\StorePayoutRequest;
use App\Http\Requests\UpdatePayoutRequest;
use App\Http\Resources\Admin\PayoutResource;
use App\Models\Payout;
use App\Models\PayoutBank;
use App\Models\Product;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class PayoutApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('payout_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PayoutResource(Payout::with(['merchant', 'bulk', 'gate'])->get());
    }

    public function store(StorePayoutRequest $request)
    {
        $payout = Payout::create($request->all());

        if ($request->input('payment_slip', false)) {
            $payout->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
        }

        return (new PayoutResource($payout))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Payout $payout)
    {
        abort_if(Gate::denies('payout_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PayoutResource($payout->load(['merchant', 'bulk', 'gate']));
    }

    public function update(UpdatePayoutRequest $request, Payout $payout)
    {
        $payout->update($request->all());

        if ($request->input('payment_slip', false)) {
            if (!$payout->payment_slip || $request->input('payment_slip') !== $payout->payment_slip->file_name) {
                if ($payout->payment_slip) {
                    $payout->payment_slip->delete();
                }

                $payout->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
            }
        } elseif ($payout->payment_slip) {
            $payout->payment_slip->delete();
        }

        return (new PayoutResource($payout))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Payout $payout)
    {
        abort_if(Gate::denies('payout_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payout->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function payout_user(API_UserApplyPayoutRequest $request)
    {

        $insert_data = $request->validated();

        $insert_data['status'] = 0;

        $secret_key = $request->input('secret_key');
        $product_key = $request->input('product_key');

        $gate = Product::find($insert_data['gate_id']);

        //使用gate 找出merchant id

        if (empty($gate)) {
            //无效gate
            Log::info("[" . $request->path() . "]" . '无效gate');

            return  $this->res_format(10052, $this->api_ret_msg('api.invalid_gate'));
        };


        $verify_res = $gate->verify_key($secret_key, $product_key);

        if (!$verify_res) {

            Log::info("[" . $request->path() . "]" . '验证 secret_key && product_key 失败');

            return  $this->res_format(10050, $this->api_ret_msg('api.error'));
        }

        do {
            $pass = false;

            $insert_data['document_no'] = Payout::generate_document_no();

            $res_sign = Payout::where('document_no', '=', $insert_data['document_no'])->count();

            if ($res_sign <= 0) {
                $pass = true;
            }
        } while (!$pass);

        $insert_data['currency_id'] = $gate->currency_id;

        DB::beginTransaction();

        try {
            //拿出gate里面的currency id
            // $gate = Product::find($insert_data['gate_id']);

            $processing_fee = $gate->processing_fee($insert_data['amount'], "top_up");

            $insert_data['processing_fee'] = $processing_fee['fee'];
            $insert_data['processing_rate'] = $processing_fee['config_rate'];
            $insert_data['processing_fix'] = $processing_fee['config_fix'];
            $insert_data['merchant_id'] = $gate['merchant_id'];

            $res_payout = Payout::create($insert_data);

            $insert_data = [
                'bank_name' => $res_payout['bank_name'],
                'bank_account_name' => $res_payout['bank_account_name'],
                'bank_account_number' => $res_payout['bank_account_number'],
                'bank_currency' => $gate['currency_id'],
                'created_at' => $res_payout['created_at'],
                'updated_at' => $res_payout['updated_at'],
                'deleted_at' => $res_payout['deleted_at'],
                'payout_id' => $res_payout['id'],
                'bank_code' => $res_payout['bank_code'],
            ];

            $res_payout = PayoutBank::create($insert_data);

            DB::commit();

            return $this->res_format(0, $this->api_ret_msg('api.success'));
        } catch (Exception $e) {

            DB::rollBack();

            return $this->res_format(10051, $this->api_ret_msg('api.failed'));
        }
    }
}
