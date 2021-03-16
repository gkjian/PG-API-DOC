<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyApiKeyRequest;
use App\Http\Requests\StoreApiKeyRequest;
use App\Http\Requests\UpdateApiKeyRequest;
use App\Models\ApiKey;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ApiKeyController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('api_key_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ApiKey::with(['gate'])->select(sprintf('%s.*', (new ApiKey)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'api_key_show';
                $editGate      = 'api_key_edit';
                // $deleteGate    = 'api_key_delete';
                $crudRoutePart = 'api-keys';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    // 'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('api_key', function ($row) {
                return $row->api_key ? $row->api_key : "";
            });
            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'gate']);

            return $table->make(true);
        }

        return view('admin.apiKeys.index');
    }

    public function create()
    {
        abort_if(Gate::denies('api_key_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.apiKeys.create', compact('gates'));
    }

    public function store(StoreApiKeyRequest $request)
    {
        $apiKey = ApiKey::create($request->all());

        return redirect()->route('admin.api-keys.index');
    }

    public function edit(ApiKey $apiKey)
    {
        abort_if(Gate::denies('api_key_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $apiKey->load('gate');

        return view('admin.apiKeys.edit', compact('gates', 'apiKey'));
    }

    public function update(UpdateApiKeyRequest $request, ApiKey $apiKey)
    {
        $apiKey->update($request->all());

        return redirect()->route('admin.api-keys.index');
    }

    public function show(ApiKey $apiKey)
    {
        abort_if(Gate::denies('api_key_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $apiKey->load('gate');

        return view('admin.apiKeys.show', compact('apiKey'));
    }

    public function destroy(ApiKey $apiKey)
    {
        abort_if(Gate::denies('api_key_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $apiKey->delete();

        return back();
    }

    public function massDestroy(MassDestroyApiKeyRequest $request)
    {
        ApiKey::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
