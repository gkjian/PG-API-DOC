@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.payoutBank.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payout-banks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBank.fields.id') }}
                        </th>
                        <td>
                            {{ $payoutBank->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBank.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $payoutBank->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBank.fields.bank_account_name') }}
                        </th>
                        <td>
                            {{ $payoutBank->bank_account_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBank.fields.bank_account_number') }}
                        </th>
                        <td>
                            {{ $payoutBank->bank_account_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBank.fields.bank_currency') }}
                        </th>
                        <td>
                            {{ $payoutBank->bank_currency }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBank.fields.payout') }}
                        </th>
                        <td>
                            {{ $payoutBank->payout->document_no ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payout-banks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
