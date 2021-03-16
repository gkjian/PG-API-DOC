@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.topUp.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.top-ups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.id') }}
                        </th>
                        <td>
                            {{ $topUp->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.merchant') }}
                        </th>
                        <td>
                            {{ $topUp->merchant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.gate') }}
                        </th>
                        <td>
                            {{ $topUp->gate->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.amount') }}
                        </th>
                        <td>
                            {{ number_format($topUp->amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.processing_fee') }}
                        </th>
                        <td>
                            {{ number_format($topUp->processing_fee, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.transaction') }}
                        </th>
                        <td>
                            {{ $topUp->document_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.client_transaction') }}
                        </th>
                        <td>
                            {{ $topUp->client_transaction }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\TopUp::STATUS_SELECT[$topUp->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.remark') }}
                        </th>
                        <td>
                            {{ $topUp->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.payment_slip') }}
                        </th>
                        <td>
                            @if($topUp->payment_slip)
                                <a href="{{ $topUp->payment_slip->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.freeze') }}
                        </th>
                        <td>
                            {{ $topUp->freeze }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.topUp.fields.signature') }}
                        </th>
                        <td>
                            {{ $topUp->signature }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.top-ups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
