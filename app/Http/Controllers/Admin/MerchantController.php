<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyMerchantRequest;
use App\Http\Requests\StoreMerchantRequest;
use App\Http\Requests\UpdateMerchantRequest;
use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('merchant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            $user = Auth::user();

            if (Auth::guard('merchant')->check()) {
                $query = Merchant::with(['roles'])->select(sprintf('%s.*', (new Merchant)->table))->where('parent_id', $user->id);
            } else if (Auth::guard('partner')->check()) {
                $query = Merchant::with(['roles'])->select(sprintf('%s.*', (new Merchant)->table))->where('partner_id', $user->id);
            } else if (Auth::guard('admin')->check()) {
                $query = Merchant::with(['roles'])->select(sprintf('%s.*', (new Merchant)->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'merchant_show';
                $editGate      = 'merchant_edit';
                // $deleteGate    = 'merchant_delete';
                $crudRoutePart = 'merchants';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->editColumn('roles', function ($row) {
                $labels = [];

                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->name);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('status', function ($row) {
                return Merchant::STATUS_SELECT[$row->status] ? Merchant::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'roles']);

            return $table->make(true);
        }

        return view('admin.merchants.index');
    }

    public function create()
    {
        abort_if(Gate::denies('merchant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::where('guard_name', 'merchant')->pluck('name', 'id');

        return view('admin.merchants.create', compact('roles'));
    }

    public function store(StoreMerchantRequest $request)
    {

        $array = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'person_incharge_name' => $request->person_incharge_name,
            'contact' => $request->contact,
            'status' => $request->status,
        ];

        $user = Auth::user();

        if (Auth::guard('merchant')->check()) {
            $array['parent_id'] = $user->id;
            $array['partner_id'] = $user->partner_id;
        } else if (Auth::guard('partner')->check()) {
            $array['parent_id'] = null;
            $array['partner_id'] = $user->id;
        }

        $checkMerchant = Merchant::where('name', $request->name)->get();

        if ($checkMerchant->count() == 0) {
            $checkAdmin = Admin::where('name', $request->name)->get();
            if ($checkAdmin->count() == 0) {
                $merchant = Merchant::create($array);
                $merchant->syncRoles($request->input('roles', []));
            } else {
                return redirect()->route('admin.merchants.create')->withInput($request->input())->withErrors(['error' => ['Name has been taken !']]);
            }
        } else {
            return redirect()->route('admin.merchants.create')->withInput($request->input())->withErrors(['error' => ['Name has been taken !']]);
        }

        return redirect()->route('admin.merchants.index');
    }

    public function edit(Merchant $merchant)
    {
        abort_if(Gate::denies('merchant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::where('guard_name', 'merchant')->pluck('name', 'id');

        $merchant->load('roles');

        return view('admin.merchants.edit', compact('roles', 'merchant'));
    }

    public function update(UpdateMerchantRequest $request, Merchant $merchant)
    {

        $array = [
            'name' => $request->name,
            'email' => $request->email,
            'person_incharge_name' => $request->person_incharge_name,
            'contact' => $request->contact,
            'status' => $request->status,
        ];

        if ($request->password != null && $request->password != '') {
            $array['password'] = Hash::make($request->password);
        }

        $merchant->update($array);
        $merchant->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.merchants.index');
    }

    public function show(Merchant $merchant)
    {
        abort_if(Gate::denies('merchant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchant->load('roles');

        return view('admin.merchants.show', compact('merchant'));
    }

    public function destroy(Merchant $merchant)
    {
        abort_if(Gate::denies('merchant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchant->delete();

        return back();
    }

    public function massDestroy(MassDestroyMerchantRequest $request)
    {
        Merchant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
