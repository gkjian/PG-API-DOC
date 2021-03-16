<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ApiKey;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\Settlement;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {

            $user = Auth::user();

            if (Auth::guard('merchant')->check()) {

                if ($user->parent_id) {
                    $query = Product::with(['merchant', 'currency'])->select(sprintf('%s.*', (new Product)->table))->where('merchant_id', $user->parent_id);
                } else {
                    $query = Product::with(['merchant', 'currency'])->select(sprintf('%s.*', (new Product)->table))->where('merchant_id', $user->id);
                }
            } else if (Auth::guard('partner')->check()) {
            } else if (Auth::guard('admin')->check()) {
                $query = Product::with(['merchant', 'currency'])->select(sprintf('%s.*', (new Product)->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'product_show';
                $editGate      = 'product_edit';
                // $deleteGate    = 'product_delete';
                $crudRoutePart = 'products';

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
            $table->addColumn('merchant_name', function ($row) {
                return $row->merchant ? $row->merchant->name : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('secret_key', function ($row) {
                return $row->secret_key ? $row->secret_key : "";
            });
            $table->editColumn('product_key', function ($row) {
                return $row->product_key ? $row->product_key : "";
            });
            $table->editColumn('status', function ($row) {
                return ($row->status != null) ? Product::STATUS_SELECT[$row->status] : '';
            });
            // $table->editColumn('description', function ($row) {
            //     return $row->description ? $row->description : "";
            // });
            $table->addColumn('currency_name', function ($row) {
                return $row->currency ? $row->currency->name . '(' . $row->currency->short_code . ')' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'merchant', 'currency']);

            return $table->make(true);
        }

        return view('admin.products.index');
    }

    public function create()
    {

        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);
            $merchant_id = null;
        } else {
            $merchants = null;

            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;
        }

        $currencies = Currency::all();

        return view('admin.products.create', compact('merchants', 'merchant_id', 'currencies'));
    }

    public function store(StoreProductRequest $request)
    {
        $insert_data = $request->all();

        $insert_data['processing_fee'] = json_encode($request['processing_fee']);

        $insert_data['gate_id'] = uniqid('GAT');

        $product = Product::create($insert_data);

        $secret_key = ApiKey::generateApiKey(32, $product->id);
        $product_key = ApiKey::generateApiKey(16, $product->id);

        $product->secret_key = $secret_key;
        $product->product_key = $product_key;
        $product->save();

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();

        if (Auth::guard('admin')->check()) {
            $merchants = Merchant::all()->where('parent_id', null);
            $merchant_id = null;
        } else {
            $merchants = null;

            $merchant_id = $user->parent_id ? $user->parent_id : $user->id;
        }

        $currencies = Currency::all();

        $product['processing_fee'] = json_decode($product['processing_fee']);

        $product->load('merchant', 'currency');

        return view('admin.products.edit', compact('merchants', 'merchant_id', 'currencies', 'product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $update_data = $request->all();

        $update_data['processing_data'] = json_encode($request['processing_data']);

        $product->update($request->all());

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('merchant', 'currency');

        $product['processing_fee'] = json_decode($product['processing_fee']);

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function get_gate_list(Request $request)
    {

        $merchant_id = $request->has('merchant_id') ? $request->query('merchant_id') : null;

        if($merchant_id == null){
            $gates = Product::with(['currency'])->get();
        } else {
            $gates = Product::with(['currency'])->where('merchant_id', $merchant_id)->get();
        }

        return $gates;

    }
}
