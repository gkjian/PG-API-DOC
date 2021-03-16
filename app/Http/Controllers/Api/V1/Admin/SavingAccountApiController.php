<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSavingAccountRequest;
use App\Http\Requests\UpdateSavingAccountRequest;
use App\Http\Resources\Admin\SavingAccountResource;
use App\Models\SavingAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SavingAccountApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('saving_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SavingAccountResource(SavingAccount::with(['currency'])->get());
    }

    public function store(StoreSavingAccountRequest $request)
    {
        $savingAccount = SavingAccount::create($request->all());

        return (new SavingAccountResource($savingAccount))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SavingAccount $savingAccount)
    {
        abort_if(Gate::denies('saving_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SavingAccountResource($savingAccount->load(['currency']));
    }

    public function update(UpdateSavingAccountRequest $request, SavingAccount $savingAccount)
    {
        $savingAccount->update($request->all());

        return (new SavingAccountResource($savingAccount))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SavingAccount $savingAccount)
    {
        abort_if(Gate::denies('saving_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $savingAccount->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
