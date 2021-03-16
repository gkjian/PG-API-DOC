@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.deposit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deposits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.id') }}
                        </th>
                        <td>
                            {{ $deposit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.document_no') }}
                        </th>
                        <td>
                            {{ $deposit->document_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.merchant') }}
                        </th>
                        <td>
                            {{ $deposit->merchant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.project') }}
                        </th>
                        <td>
                            {{ $deposit->gate->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.amount') }}
                        </th>
                        <td>
                            {{ number_format($deposit->amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.processing_fee') }}
                        </th>
                        <td>
                            {{ number_format($deposit->processing_fee, 2) }}
                            <br>
                            ( {{ number_format($deposit->processing_rate, 2) }}% + {{ number_format($deposit->processing_fix, 2) }} )
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.currency') }}
                        </th>
                        <td>
                            {{ $deposit->currency->name ?? '' }} ({{ $deposit->currency->short_code ?? '' }})
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.description') }}
                        </th>
                        <td>
                            {{ $deposit->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Deposit::STATUS_SELECT[$deposit->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.remark') }}
                        </th>
                        <td>
                            {{ $deposit->remark }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.ip_address') }}
                        </th>
                        <td>
                            {{ $deposit->ip_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.processed_at') }}
                        </th>
                        <td>
                            {{ $deposit->processed_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.processed_by') }}
                        </th>
                        <td>
                            {{ $deposit->processed_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.saving_account') }}
                        </th>
                        <td>
                            {{ $deposit->saving_account->bank_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deposit.fields.payment_slip') }}
                        </th>
                        <td>
                            @if($deposit->payment_slip)
                                <a href="{{ $deposit->payment_slip->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deposits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
