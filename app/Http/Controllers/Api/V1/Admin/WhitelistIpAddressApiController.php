<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhitelistIpAddressRequest;
use App\Http\Requests\UpdateWhitelistIpAddressRequest;
use App\Http\Resources\Admin\WhitelistIpAddressResource;
use App\Models\WhitelistIpAddress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhitelistIpAddressApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('whitelist_ip_address_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhitelistIpAddressResource(WhitelistIpAddress::with(['gate'])->get());
    }

    public function store(StoreWhitelistIpAddressRequest $request)
    {
        $whitelistIpAddress = WhitelistIpAddress::create($request->all());

        return (new WhitelistIpAddressResource($whitelistIpAddress))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WhitelistIpAddress $whitelistIpAddress)
    {
        abort_if(Gate::denies('whitelist_ip_address_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhitelistIpAddressResource($whitelistIpAddress->load(['gate']));
    }

    public function update(UpdateWhitelistIpAddressRequest $request, WhitelistIpAddress $whitelistIpAddress)
    {
        $whitelistIpAddress->update($request->all());

        return (new WhitelistIpAddressResource($whitelistIpAddress))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WhitelistIpAddress $whitelistIpAddress)
    {
        abort_if(Gate::denies('whitelist_ip_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whitelistIpAddress->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
