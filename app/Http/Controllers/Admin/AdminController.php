<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAdminRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Admin::with(['roles'])->select(sprintf('%s.*', (new Admin)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'admin_show';
                $editGate      = 'admin_edit';
                // $deleteGate    = 'admin_delete';
                $crudRoutePart = 'admins';

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

            $table->rawColumns(['actions', 'placeholder', 'roles']);

            return $table->make(true);
        }

        return view('admin.admins.index');
    }

    public function create()
    {
        abort_if(Gate::denies('admin_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::where('guard_name', 'admin')->pluck('name', 'id');

        return view('admin.admins.create', compact('roles'));
    }

    public function store(StoreAdminRequest $request)
    {

        $checkMerchant = Merchant::where('name', $request->name)->get();

        if ($checkMerchant->count() == 0) {
            $checkAdmin = Admin::where('name', $request->name)->get();
            if ($checkAdmin->count() == 0) {
                $admin = Admin::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $admin->syncRoles($request->input('roles', []));
            } else {
                return redirect()->route('admin.admins.create')->withInput($request->input())->withErrors(['error' => ['Name has been taken !']]);
            }
        } else {
            return redirect()->route('admin.admins.create')->withInput($request->input())->withErrors(['error' => ['Name has been taken !']]);
        }
        
        return redirect()->route('admin.admins.index');
    }

    public function edit(Admin $admin)
    {
        abort_if(Gate::denies('admin_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::where('guard_name', 'admin')->pluck('name', 'id');
        
        $admin->load('roles');

        return view('admin.admins.edit', compact('roles', 'admin'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $array = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password != null && $request->password != '') {
            $array['password'] = Hash::make($request->password);
        }

        $admin->update($array);
        $admin->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.admins.index');
    }

    public function show(Admin $admin)
    {
        abort_if(Gate::denies('admin_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->load('roles');

        return view('admin.admins.show', compact('admin'));
    }

    public function destroy(Admin $admin)
    {
        abort_if(Gate::denies('admin_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdminRequest $request)
    {
        Admin::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
