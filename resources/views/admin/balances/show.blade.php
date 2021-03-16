@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.balance.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.balances.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.id') }}
                            </th>
                            <td>
                                {{ $balance->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.merchant') }}
                            </th>
                            <td>
                                {{ $balance->merchant->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.debit') }}
                            </th>
                            <td>
                                {{ number_format($balance->debit, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.credit') }}
                            </th>
                            <td>
                                {{ number_format($balance->credit, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.type') }}
                            </th>
                            <td>
                                {{ App\Models\Balance::TYPE_SELECT[$balance->type] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.status') }}
                            </th>
                            <td>
                                @php
                                    $status_name = App\Models\Balance::STATUS_SELECT[$balance->status] ?? '';
                                @endphp
                                @switch((int)$balance->status)
                                    @case(0)
                                    <span class="badge badge-success">{{ $status_name }}</span>
                                    @break
                                    @case(1)
                                    <span class="badge badge-danger">{{ $status_name }}</span>
                                    @break
                                    @case(2)
                                    <span class="badge badge-danger">{{ $status_name }}</span>
                                    @break
                                    @default
                                    <span class="badge badge-secondary">{{ $status_name }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.transaction') }}
                            </th>
                            <td>
                                {{ $balance->document_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.remark') }}
                            </th>
                            <td>
                                {{ $balance->remark }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.settlement_status') }}
                            </th>
                            <td>
                                @php
                                    $status_name = App\Models\Balance::SETTLEMENT_STATUS_SELECT[$balance->settlement_status] ?? '';
                                @endphp
                                @switch((int)$balance->settlement_status)
                                    @case(0)
                                    <span class="badge badge-secondary">{{ $status_name }}</span>
                                    @break
                                    @case(1)
                                    <span class="badge badge-success">{{ $status_name }}</span>
                                    @break
                                    @default
                                    <span class="badge badge-secondary">{{ $status_name }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.processing_fee') }}
                            </th>
                            <td>
                                {{ number_format($balance->processing_fee, 2) }} 
                                <br>
                                ({{ number_format($balance->processing_rate, 2) }} % + {{ number_format($balance->processing_fix, 2) }})
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.gate') }}
                            </th>
                            <td>
                                {{ $balance->gate->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.saving_account') }}
                            </th>
                            <td>
                                {{ $balance->saving_account->bank_id ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.settlement_bank') }}
                            </th>
                            <td>
                                {{ $balance->settlement_bank->bank_code ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.balance.fields.ref_id') }}
                            </th>
                            <td>
                                {!! $ref ?? '' !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.balances.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
