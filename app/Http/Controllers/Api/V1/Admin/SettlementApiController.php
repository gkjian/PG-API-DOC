<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSettlementRequest;
use App\Http\Requests\UpdateSettlementRequest;
use App\Http\Resources\Admin\SettlementResource;
use App\Models\Settlement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SettlementApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('settlement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SettlementResource(Settlement::with(['merchant', 'bank'])->get());
    }

    public function store(StoreSettlementRequest $request)
    {
        $settlement = Settlement::create($request->all());

        if ($request->input('payment_slip', false)) {
            $settlement->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
        }

        return (new SettlementResource($settlement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Settlement $settlement)
    {
        abort_if(Gate::denies('settlement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SettlementResource($settlement->load(['merchant', 'bank']));
    }

    public function update(UpdateSettlementRequest $request, Settlement $settlement)
    {
        $settlement->update($request->all());

        if ($request->input('payment_slip', false)) {
            if (!$settlement->payment_slip || $request->input('payment_slip') !== $settlement->payment_slip->file_name) {
                if ($settlement->payment_slip) {
                    $settlement->payment_slip->delete();
                }

                $settlement->addMedia(storage_path('tmp/uploads/' . $request->input('payment_slip')))->toMediaCollection('payment_slip');
            }
        } elseif ($settlement->payment_slip) {
            $settlement->payment_slip->delete();
        }

        return (new SettlementResource($settlement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Settlement $settlement)
    {
        abort_if(Gate::denies('settlement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settlement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
