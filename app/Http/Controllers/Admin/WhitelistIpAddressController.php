<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWhitelistIpAddressRequest;
use App\Http\Requests\StoreWhitelistIpAddressRequest;
use App\Http\Requests\UpdateWhitelistIpAddressRequest;
use App\Models\Product;
use App\Models\WhitelistIpAddress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

class WhitelistIpAddressController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('whitelist_ip_address_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            if (Auth::guard('merchant')->check()) {
                $query = WhitelistIpAddress::whereHas('gate', function ($query) {
                    $user = Auth::user();
                    return $query->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id);
                })->select(sprintf('%s.*', (new WhitelistIpAddress)->table));
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('admin')->check()) {
                $query = WhitelistIpAddress::with(['gate'])->select(sprintf('%s.*', (new WhitelistIpAddress)->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'whitelist_ip_address_show';
                $editGate      = 'whitelist_ip_address_edit';
                // $deleteGate    = 'whitelist_ip_address_delete';
                $crudRoutePart = 'whitelist-ip-addresses';

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
            $table->addColumn('gate_name', function ($row) {
                return $row->gate ? $row->gate->name : '';
            });

            $table->editColumn('ip_address', function ($row) {
                return $row->ip_address ? $row->ip_address : "";
            });
            $table->editColumn('status', function ($row) {
                return ($row->status != null) ? WhitelistIpAddress::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'gate']);

            return $table->make(true);
        }

        return view('admin.whitelistIpAddresses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('whitelist_ip_address_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        if (Auth::guard('merchant')->check()) {
            $gates = Product::where('merchant_id', $user->parent_id ? $user->parent_id : $user->id)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else if (Auth::guard('partner')->check()) {
        } else if (Auth::guard('admin')->check()) {
            $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        return view('admin.whitelistIpAddresses.create', compact('gates'));
    }

    public function store(StoreWhitelistIpAddressRequest $request)
    {
        $whitelistIpAddress = WhitelistIpAddress::create($request->all());

        return redirect()->route('admin.whitelist-ip-addresses.index');
    }

    public function edit(WhitelistIpAddress $whitelistIpAddress)
    {
        abort_if(Gate::denies('whitelist_ip_address_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        if (Auth::guard('merchant')->check()) {
            $gates = Product::where('merchant_id', $user->parent_id ? $user->parent_id : $user->id)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else if (Auth::guard('partner')->check()) {
        } else if (Auth::guard('admin')->check()) {
            $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $whitelistIpAddress->load('gate');

        return view('admin.whitelistIpAddresses.edit', compact('gates', 'whitelistIpAddress'));
    }

    public function update(UpdateWhitelistIpAddressRequest $request, WhitelistIpAddress $whitelistIpAddress)
    {
        $whitelistIpAddress->update($request->all());

        return redirect()->route('admin.whitelist-ip-addresses.index');
    }

    public function show(WhitelistIpAddress $whitelistIpAddress)
    {
        abort_if(Gate::denies('whitelist_ip_address_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whitelistIpAddress->load('gate');

        return view('admin.whitelistIpAddresses.show', compact('whitelistIpAddress'));
    }

    public function destroy(WhitelistIpAddress $whitelistIpAddress)
    {
        abort_if(Gate::denies('whitelist_ip_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whitelistIpAddress->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhitelistIpAddressRequest $request)
    {
        WhitelistIpAddress::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
