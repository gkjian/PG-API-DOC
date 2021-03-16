<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApiKeyRequest;
use App\Http\Requests\UpdateApiKeyRequest;
use App\Http\Resources\Admin\ApiKeyResource;
use App\Models\ApiKey;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('api_key_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ApiKeyResource(ApiKey::with(['gate'])->get());
    }

    public function store(StoreApiKeyRequest $request)
    {
        $apiKey = ApiKey::create($request->all());

        return (new ApiKeyResource($apiKey))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ApiKey $apiKey)
    {
        abort_if(Gate::denies('api_key_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ApiKeyResource($apiKey->load(['gate']));
    }

    public function update(UpdateApiKeyRequest $request, ApiKey $apiKey)
    {
        $apiKey->update($request->all());

        return (new ApiKeyResource($apiKey))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ApiKey $apiKey)
    {
        abort_if(Gate::denies('api_key_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $apiKey->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
