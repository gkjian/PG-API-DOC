<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWhitelistEmailRequest;
use App\Http\Requests\StoreWhitelistEmailRequest;
use App\Http\Requests\UpdateWhitelistEmailRequest;
use App\Models\Product;
use App\Models\WhitelistEmail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WhitelistEmailController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('whitelist_email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WhitelistEmail::with(['gate'])->select(sprintf('%s.*', (new WhitelistEmail)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'whitelist_email_show';
                $editGate      = 'whitelist_email_edit';
                // $deleteGate    = 'whitelist_email_delete';
                $crudRoutePart = 'whitelist-emails';

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

            $table->editColumn('emaill', function ($row) {
                return $row->emaill ? $row->emaill : "";
            });
            $table->editColumn('status', function ($row) {
                return ($row->status != null) ? WhitelistEmail::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'gate']);

            return $table->make(true);
        }

        return view('admin.whitelistEmails.index');
    }

    public function create()
    {
        abort_if(Gate::denies('whitelist_email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.whitelistEmails.create', compact('gates'));
    }

    public function store(StoreWhitelistEmailRequest $request)
    {
        $whitelistEmail = WhitelistEmail::create($request->all());

        return redirect()->route('admin.whitelist-emails.index');
    }

    public function edit(WhitelistEmail $whitelistEmail)
    {
        abort_if(Gate::denies('whitelist_email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gates = Product::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $whitelistEmail->load('gate');

        return view('admin.whitelistEmails.edit', compact('gates', 'whitelistEmail'));
    }

    public function update(UpdateWhitelistEmailRequest $request, WhitelistEmail $whitelistEmail)
    {
        $whitelistEmail->update($request->all());

        return redirect()->route('admin.whitelist-emails.index');
    }

    public function show(WhitelistEmail $whitelistEmail)
    {
        abort_if(Gate::denies('whitelist_email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whitelistEmail->load('gate');

        return view('admin.whitelistEmails.show', compact('whitelistEmail'));
    }

    public function destroy(WhitelistEmail $whitelistEmail)
    {
        abort_if(Gate::denies('whitelist_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whitelistEmail->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhitelistEmailRequest $request)
    {
        WhitelistEmail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
