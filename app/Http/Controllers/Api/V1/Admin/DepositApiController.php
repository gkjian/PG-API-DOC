<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositRequest;
use App\Http\Requests\UpdateDepositRequest;
use App\Http\Resources\Admin\DepositResource;
use App\Models\Deposit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepositApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('top_up_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DepositResource(Deposit::with(['merchant'])->get());
    }

    public function store(StoreDepositRequest $request)
    {
        $deposit = Deposit::create($request->all());

        return (new DepositResource($deposit))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Deposit $deposit)
    {
        abort_if(Gate::denies('top_up_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DepositResource($deposit->load(['merchant']));
    }

    public function update(UpdateDepositRequest $request, Deposit $deposit)
    {
        $deposit->update($request->all());

        return (new DepositResource($deposit))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Deposit $deposit)
    {
        abort_if(Gate::denies('top_up_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deposit->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
