<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePayoutBulkRequest;
use App\Http\Requests\UpdatePayoutBulkRequest;
use App\Http\Resources\Admin\PayoutBulkResource;
use App\Models\PayoutBulk;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PayoutBulkApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('payout_bulk_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PayoutBulkResource(PayoutBulk::with(['merchant'])->get());
    }

    public function store(StorePayoutBulkRequest $request)
    {
        $payoutBulk = PayoutBulk::create($request->all());

        if ($request->input('file_path', false)) {
            $payoutBulk->addMedia(storage_path('tmp/uploads/' . $request->input('file_path')))->toMediaCollection('file_path');
        }

        return (new PayoutBulkResource($payoutBulk))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PayoutBulk $payoutBulk)
    {
        abort_if(Gate::denies('payout_bulk_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PayoutBulkResource($payoutBulk->load(['merchant']));
    }

    public function update(UpdatePayoutBulkRequest $request, PayoutBulk $payoutBulk)
    {
        $payoutBulk->update($request->all());

        if ($request->input('file_path', false)) {
            if (!$payoutBulk->file_path || $request->input('file_path') !== $payoutBulk->file_path->file_name) {
                if ($payoutBulk->file_path) {
                    $payoutBulk->file_path->delete();
                }

                $payoutBulk->addMedia(storage_path('tmp/uploads/' . $request->input('file_path')))->toMediaCollection('file_path');
            }
        } elseif ($payoutBulk->file_path) {
            $payoutBulk->file_path->delete();
        }

        return (new PayoutBulkResource($payoutBulk))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PayoutBulk $payoutBulk)
    {
        abort_if(Gate::denies('payout_bulk_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutBulk->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
