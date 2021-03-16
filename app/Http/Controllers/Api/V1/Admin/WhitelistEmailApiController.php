<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhitelistEmailRequest;
use App\Http\Requests\UpdateWhitelistEmailRequest;
use App\Http\Resources\Admin\WhitelistEmailResource;
use App\Models\WhitelistEmail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhitelistEmailApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('whitelist_email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhitelistEmailResource(WhitelistEmail::with(['gate'])->get());
    }

    public function store(StoreWhitelistEmailRequest $request)
    {
        $whitelistEmail = WhitelistEmail::create($request->all());

        return (new WhitelistEmailResource($whitelistEmail))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WhitelistEmail $whitelistEmail)
    {
        abort_if(Gate::denies('whitelist_email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhitelistEmailResource($whitelistEmail->load(['gate']));
    }

    public function update(UpdateWhitelistEmailRequest $request, WhitelistEmail $whitelistEmail)
    {
        $whitelistEmail->update($request->all());

        return (new WhitelistEmailResource($whitelistEmail))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WhitelistEmail $whitelistEmail)
    {
        abort_if(Gate::denies('whitelist_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whitelistEmail->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
