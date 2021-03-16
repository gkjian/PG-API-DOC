<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Role::with(['permissions'])->select(sprintf('*', (new Role)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'role_show';
                $editGate      = 'role_edit';
                // $deleteGate    = 'role_delete';
                $crudRoutePart = 'roles';

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
                return $row->name ? $row->name."(".$row->guard_name.")" : "";
            });
            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by_id ? $row->created_by->name : "";
            });
            $table->addColumn('modified_by_name', function ($row) {
                return $row->modified_by_id ? $row->modified_by->name : "";
            });
            $table->editColumn('permissions', function ($row) {
                $labels = [];
                $labels[] = "<div class='row'>";
                foreach ($row->permissions as $permission) {
                    // if($permission->guard_name == "admin"){
                    //     $labels[] = sprintf('<span class="label label-info label-many col-3 text-danger">%s (admin)</span>', $permission->name);
                    // }else{

                    // }

                    $labels[] = sprintf('<span class="label label-info label-many col-3">%s ('.$permission->guard_name.')</span>', $permission->name);

                }
                $labels[] = "</div>";
                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'created_by', 'modified_by', 'permissions']);

            return $table->make(true);
        }

        return view('admin.roles.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->guard == "" || ($request->guard != "admin" && $request->guard != "merchant" && $request->guard != "partner")){
            return redirect()->route('admin.roles.index');
        }

        $permissions = Permission::where('guard_name', $request->guard)->get();
        $guard_name = $request->guard;

        $unique = Permission::all()->unique('type');

        return view('admin.roles.create', compact('permissions', 'guard_name', 'unique'));
    }

    public function store(StoreRoleRequest $request)
    {
        $request['created_by_id'] = Auth::id();
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::where('guard_name', $role->guard_name)->get();/*->pluck('title', 'id')*/;

        $role->load('permissions');

        $unique = Permission::all()->unique('type');

        return view('admin.roles.edit', compact('permissions', 'role', 'unique'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $request['modified_by_id'] = Auth::id();
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        return back();
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        Role::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
