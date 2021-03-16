<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPartnerRequest;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Models\Partner;
use App\Models\Merchant;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('partner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Partner::with(['roles'])->select(sprintf('%s.*', (new Partner)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'partner_show';
                $editGate      = 'partner_edit';
                // $deleteGate    = 'partner_delete';
                $crudRoutePart = 'partners';

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
                return Partner::STATUS_SELECT[$row->status] ? Partner::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'roles']);

            return $table->make(true);
        }

        return view('admin.partners.index');
    }

    public function create()
    {
        abort_if(Gate::denies('partner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::where('guard_name', 'partner')->pluck('name', 'id');

        return view('admin.partners.create', compact('roles'));
    }

    public function store(StorePartnerRequest $request)
    {
        $partner = Partner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status
        ]);
        // $partner->roles()->sync($request->input('roles', []));
        $partner->syncRoles($request->input('roles', []));

        return redirect()->route('admin.partners.index');
    }

    public function edit(Partner $partner)
    {
        abort_if(Gate::denies('partner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::where('guard_name', 'partner')->pluck('name', 'id');

        $partner->load('roles');

        return view('admin.partners.edit', compact('roles', 'partner'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $array = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status
        ];

        if ($request->status == 1) {
            Merchant::where('partner_id', $partner->id)->update([
                'status' => 1
            ]);
        }

        if ($request->password != null && $request->password != '') {
            $array['password'] = Hash::make($request->password);
        }

        $partner->update($array);
        $partner->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.partners.index');
    }

    public function show(Partner $partner)
    {
        abort_if(Gate::denies('partner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $partner->load('roles');

        return view('admin.partners.show', compact('partner'));
    }

    public function destroy(Partner $partner)
    {
        abort_if(Gate::denies('partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $partner->delete();

        return back();
    }

    public function massDestroy(MassDestroyPartnerRequest $request)
    {
        Partner::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
