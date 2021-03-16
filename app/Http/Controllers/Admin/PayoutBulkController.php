<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPayoutBulkRequest;
use App\Http\Requests\StorePayoutBulkRequest;
use App\Http\Requests\UpdatePayoutBulkRequest;
use App\Models\Merchant;
use App\Models\PayoutBulk;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;
class PayoutBulkController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('payout_bulk_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            if (Auth::guard('merchant')->check()) {
                $user = Auth::user();
                $query = PayoutBulk::with(['merchant'])->select(sprintf('%s.*', (new PayoutBulk)->table))->where('merchant_id', $user->parent_id ? $user->parent_id : $user->id);
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('admin')->check()) {
                $query = PayoutBulk::with(['merchant'])->select(sprintf('%s.*', (new PayoutBulk)->table));
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'payout_bulk_show';
                // $editGate      = 'payout_bulk_edit';
                // $deleteGate    = 'payout_bulk_delete';
                $crudRoutePart = 'payout-bulks';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    // 'editGate',
                    // 'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? $row->merchant->name : '';
            });

            $table->editColumn('file_path', function ($row) {
                return $row->file_path ? '<a href="' . $row->file_path->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'file_path']);

            return $table->make(true);
        }

        return view('admin.payoutBulks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('payout_bulk_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);
            $merchant_id = null;
        } else {
            $merchants = null;

            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;
        }

        return view('admin.payoutBulks.create', compact('merchants', 'merchant_id'));
    }

    public function store(StorePayoutBulkRequest $request)
    {
        $payoutBulk = PayoutBulk::create($request->all());

        if ($request->input('file_path', false)) {
            $payoutBulk->addMedia(storage_path('tmp/uploads/' . $request->input('file_path')))->toMediaCollection('file_path');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $payoutBulk->id]);
        }

        return redirect()->route('admin.payout-bulks.index');
    }

    public function edit(PayoutBulk $payoutBulk)
    {
        abort_if(Gate::denies('payout_bulk_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $merchants = Merchant::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payoutBulk->load('merchant');

        return view('admin.payoutBulks.edit', compact('merchants', 'payoutBulk'));
    }

    public function update(UpdatePayoutBulkRequest $request, PayoutBulk $payoutBulk)
    {
        $payoutBulk->update($request->all());

        if ($request->input('file_path', false)) {
            if (!$payoutBulk->file_path || $request->input('file_path') !== $payoutBulk->file_path->file_name) {
                if ($payoutBulk->file_path) {
                    $payoutBulk->file_path->delete();
                }

                $payoutBulk->addMedia(storage_path('tmp/uploads/' . $request->input('file_path')))->toMediaCollection('file_path');
            }
        } elseif ($payoutBulk->file_path) {
            $payoutBulk->file_path->delete();
        }

        return redirect()->route('admin.payout-bulks.index');
    }

    public function show(PayoutBulk $payoutBulk)
    {
        abort_if(Gate::denies('payout_bulk_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutBulk->load('merchant');

        return view('admin.payoutBulks.show', compact('payoutBulk'));
    }

    public function destroy(PayoutBulk $payoutBulk)
    {
        abort_if(Gate::denies('payout_bulk_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payoutBulk->delete();

        return back();
    }

    public function massDestroy(MassDestroyPayoutBulkRequest $request)
    {
        PayoutBulk::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('payout_bulk_create') && Gate::denies('payout_bulk_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new PayoutBulk();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
