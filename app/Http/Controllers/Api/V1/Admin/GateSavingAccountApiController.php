<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGateSavingAccountRequest;
use App\Http\Requests\UpdateGateSavingAccountRequest;
use App\Http\Resources\Admin\GateSavingAccountResource;
use App\Models\GateSavingAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GateSavingAccountApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('project_saving_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GateSavingAccountResource(GateSavingAccount::with(['gate', 'saving_account'])->get());
    }

    public function store(StoreGateSavingAccountRequest $request)
    {
        $gateSavingAccount = GateSavingAccount::create($request->all());

        return (new GateSavingAccountResource($gateSavingAccount))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(GateSavingAccount $gateSavingAccount)
    {
        abort_if(Gate::denies('project_saving_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new GateSavingAccountResource($gateSavingAccount->load(['gate', 'saving_account']));
    }

    public function update(UpdateGateSavingAccountRequest $request, GateSavingAccount $gateSavingAccount)
    {
        $gateSavingAccount->update($request->all());

        return (new GateSavingAccountResource($gateSavingAccount))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(GateSavingAccount $gateSavingAccount)
    {
        abort_if(Gate::denies('project_saving_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateSavingAccount->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
