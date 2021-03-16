<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettlementBankRequest;
use App\Http\Requests\UpdateSettlementBankRequest;
use App\Http\Resources\Admin\SettlementBankResource;
use App\Models\SettlementBank;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SettlementBankApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('settlement_bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SettlementBankResource(SettlementBank::with(['merchant'])->get());
    }

    public function store(StoreSettlementBankRequest $request)
    {
        $settlementBank = SettlementBank::create($request->all());

        return (new SettlementBankResource($settlementBank))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SettlementBank $settlementBank)
    {
        abort_if(Gate::denies('settlement_bank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SettlementBankResource($settlementBank->load(['merchant']));
    }

    public function update(UpdateSettlementBankRequest $request, SettlementBank $settlementBank)
    {
        $settlementBank->update($request->all());

        return (new SettlementBankResource($settlementBank))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SettlementBank $settlementBank)
    {
        abort_if(Gate::denies('settlement_bank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settlementBank->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
