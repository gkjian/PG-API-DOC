@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.project.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.id') }}
                            </th>
                            <td>
                                {{ $product->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.gate_id') }}
                            </th>
                            <td>
                                {{ $product->gate_id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.merchant') }}
                            </th>
                            <td>
                                {{ $product->merchant->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.name') }}
                            </th>
                            <td>
                                {{ $product->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.secret_key') }}
                            </th>
                            <td>
                                {{ $product->secret_key }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.product_key') }}
                            </th>
                            <td>
                                {{ $product->product_key }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.status') }}
                            </th>
                            <td>
                                {{ App\Models\Product::STATUS_SELECT[$product->status] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.description') }}
                            </th>
                            <td>
                                {{ $product->description }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.project.fields.currency') }}
                            </th>
                            <td>
                                {{ $product->currency->name ?? '' }} ({{ $product->currency->short_code ?? '' }})
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.callback_url') }}
                            </th>
                            <td>
                                {{ $product->callback_url ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.redirect_url') }}
                            </th>
                            <td>
                                {{ $product->redirect_url ?? '' }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.project.fields.fee_calculation_type') }}
                            </th>
                            <td>
                                {{ App\Models\Product::FEE_CALCULATION_TYPE[$product->processing_fee_calc_type] ?? '' }}
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.processing_fee') }}
                            </th>
                            <td>
                                @foreach ($product->processing_fee as $index => $item)
                                    {{ $index }} :
                                    @foreach ($item as $index2 => $item2)
                                        Rate : {{ $item2->rate }}%
                                        Fix : {{ $item2->fix }}
                                    @endforeach
                                    <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.current_credit') }}
                            </th>
                            <td>
                                {{ $product->currency->short_code ?? '' }} {{ $product->current_credit ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.project.fields.freeze_credit') }}
                            </th>
                            <td>
                                {{ $product->currency->short_code ?? '' }} {{ $product->freeze_credit ?? '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
