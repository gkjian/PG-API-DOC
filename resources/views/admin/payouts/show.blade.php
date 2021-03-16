@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.payout.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.payouts.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.transaction_id') }}
                            </th>
                            <td>
                                {{ $payout->document_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.client_transaction') }}
                            </th>
                            <td>
                                {{ $payout->client_transaction }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.merchant') }}
                            </th>
                            <td>
                                {{ $payout->merchant->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.gate') }}
                            </th>
                            <td>
                                {{ $payout->gate->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.bank_name') }} (User)
                            </th>
                            <td>
                                {{ $payout->bank_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.bank_account_name') }} (User)
                            </th>
                            <td>
                                {{ $payout->bank_account_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.bank_account_number') }} (User)
                            </th>
                            <td>
                                {{ $payout->bank_account_number }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.bank_name') }} (PG)
                            </th>
                            <td>
                                {{ $payout->saving_account->bank_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.bank_account_name') }} (PG)
                            </th>
                            <td>
                                {{ $payout->saving_account->bank_account_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.bank_account_number') }} (PG)
                            </th>
                            <td>
                                {{ $payout->saving_account->bank_account_number }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.amount') }}
                            </th>
                            <td>
                                {{ $payout->gate->currency->short_code . ' ' . number_format($payout->amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.processing_fee') }}
                            </th>
                            <td>
                                {{ $payout->gate->currency->short_code . ' ' . number_format($payout->processing_fee, 2) }}
                                <br>
                                ({{ number_format($payout->processing_rate, 2) }} % +
                                {{ number_format($payout->processing_fix, 2) }})
                            </td>
                        </tr>
                        @if ($payout->remark)
                            <tr>
                                <th>
                                    {{ trans('cruds.payout.fields.remark') }}
                                </th>
                                <td>
                                    {{ $payout->remark }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.status') }}
                            </th>
                            <td>
                                @php
                                    $status_name = App\Models\Payout::STATUS_SELECT[$payout->status] ?? '';
                                @endphp
                                @switch((int)$payout->status)
                                    @case(0)
                                    <span class="badge badge-secondary">{{ $status_name }}</span>
                                    @break
                                    @case(1)
                                    <span class="badge badge-success">{{ $status_name }}</span>
                                    @break
                                    @case(2)
                                    <span class="badge badge-danger">{{ $status_name }}</span>
                                    @case(3)
                                    <span class="badge badge-danger">{{ $status_name }}</span>
                                    @break
                                    @default
                                    <span class="badge badge-secondary">{{ $status_name }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.created_at') }}
                            </th>
                            <td>
                                {{ $payout->created_at }}
                            </td>
                        </tr>
                        @if ($payout->statement_date)
                            <tr>
                                <th>
                                    {{ trans('cruds.payout.fields.statement_date') }}
                                </th>
                                <td>
                                    {{ $payout->statement_date }}
                                </td>
                            </tr>
                        @endif
                        {{-- @if ($payout->bulk->name)
                        <tr>
                            <th>
                                {{ trans('cruds.payout.fields.bulk') }}
                            </th>
                            <td>
                                {{ $payout->bulk->name ?? '' }}
                            </td>
                        </tr>
                        @endif --}}
                        @if ($payout->payment_slip)
                            <tr>
                                <th>
                                    {{ trans('cruds.payout.fields.payment_slip') }}
                                </th>
                                <td>
                                    <a href="{{ $payout->payment_slip->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                </td>
                            </tr>
                        @endif
                        @if ($payout->admin_remark)
                            <tr>
                                <th>
                                    {{ trans('cruds.payout.fields.remark') }} (Admin)
                                </th>
                                <td>
                                    {{ $payout->admin_remark }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.payouts.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
