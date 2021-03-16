<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Http\Resources\Admin\PartnerResource;
use App\Models\Partner;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PartnerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('partner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PartnerResource(Partner::with(['roles'])->get());
    }

    public function store(StorePartnerRequest $request)
    {
        $partner = Partner::create($request->all());
        $partner->roles()->sync($request->input('roles', []));

        return (new PartnerResource($partner))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Partner $partner)
    {
        abort_if(Gate::denies('partner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PartnerResource($partner->load(['roles']));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner->update($request->all());
        $partner->roles()->sync($request->input('roles', []));

        return (new PartnerResource($partner))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Partner $partner)
    {
        abort_if(Gate::denies('partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $partner->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
