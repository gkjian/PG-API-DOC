@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.settlement.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.settlements.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.id') }}
                            </th>
                            <td>
                                {{ $settlement->id }}
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.transaction') }}
                            </th>
                            <td>
                                {{ $settlement->document_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.merchant') }}
                            </th>
                            <td>
                                {{ $settlement->merchant->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.project') }}
                            </th>
                            <td>
                                {{ $settlement->gate->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.bank_name') }}
                            </th>
                            <td>
                                {{ $settlement->bank->bank_name ?? '' }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.bank_name') }}
                            </th>
                            <td>
                                {{ $settlement->bank_name }}
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.bank_account_name') }}
                            </th>
                            <td>
                                {{ $settlement->bank_account_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.bank_account_number') }}
                            </th>
                            <td>
                                {{ $settlement->bank_account_number }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.currency') }}
                            </th>
                            <td>
                                {{ $settlement->currency->short_code }}
                            </td>
                        </tr> --}}
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.amount') }}
                            </th>
                            <td>
                                {{ $settlement->currency->short_code . ' ' . number_format($settlement->amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.processing_fee') }}
                            </th>
                            <td>
                                {{ $settlement->currency->short_code . ' ' . number_format($settlement->processing_fee, 2) }}
                                <br>
                                ({{ number_format($settlement->processing_rate, 2) }} % +
                                {{ number_format($settlement->processing_fix, 2) }})
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.status') }}
                            </th>
                            <td>
                                @php
                                    $status_name = App\Models\Settlement::STATUS_SELECT[$settlement->status] ?? '';
                                @endphp
                                @switch((int)$settlement->status)
                                    @case(0)
                                    <span class="badge badge-secondary">{{ $status_name }}</span>
                                    @break
                                    @case(1)
                                    <span class="badge badge-success">{{ $status_name }}</span>
                                    @break
                                    @case(2)
                                    <span class="badge badge-danger">{{ $status_name }}</span>
                                    @break
                                    @case(3)
                                    <span class="badge badge-danger">{{ $status_name }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.created_at') }}
                            </th>
                            <td>
                                {{ $settlement->created_at }}
                            </td>
                        </tr>
                        @if ($settlement->statement_date)
                            <tr>
                                <th>
                                    {{ trans('cruds.settlement.fields.statement_date') }}
                                </th>
                                <td>
                                    {{ $settlement->statement_date }}
                                </td>
                            </tr>
                        @endif
                        @if ($settlement->payment_slip)
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.payment_slip') }}
                            </th>
                            <td>
                                <a href="{{ $settlement->payment_slip->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        @if ($settlement->remark)
                        <tr>
                            <th>
                                {{ trans('cruds.settlement.fields.remark') }}
                            </th>
                            <td>
                                {{ $settlement->remark }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
