<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayoutBankRequest;
use App\Http\Requests\UpdatePayoutBankRequest;
use App\Http\Resources\Admin\PayoutBankResource;
use App\Models\PayoutBank;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PayoutBankApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('payout_bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PayoutBankResource(PayoutBank::with(['payout'])->get());
    }

    public function store(StorePayoutBankRequest $request)
    {
        $payoutBank = PayoutBank::create($request->all());

        return (new PayoutBankResource($payoutBank))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PayoutBank $payoutBank)
    {
        abort_if(Gate::denies('payout_bank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PayoutBankResource($payoutBank->load(['payout']));
    }

    public function update(UpdatePayoutBankRequest $request, PayoutBank $payoutBank)
    {
        $payoutBank->update($request->all());

        return (new PayoutBankResource($payoutBank))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PayoutBank $payoutBank)
    {
        abort_if(Gate::denies('payout_bank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutBank->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
