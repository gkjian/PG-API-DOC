@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.savingAccount.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.saving-accounts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.id') }}
                        </th>
                        <td>
                            {{ $savingAccount->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.bank_id') }}
                        </th>
                        <td>
                            {{ $savingAccount->bank_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $savingAccount->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.bank_account_name') }}
                        </th>
                        <td>
                            {{ $savingAccount->bank_account_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.bank_account_number') }}
                        </th>
                        <td>
                            {{ $savingAccount->bank_account_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.currency') }}
                        </th>
                        <td>
                            {{ $savingAccount->currency->name ?? '' }} ({{ $savingAccount->currency->short_code ?? '' }})
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.daily_limit') }}
                        </th>
                        <td>
                            {{ number_format($savingAccount->daily_limit, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.transaction_limit') }}
                        </th>
                        <td>
                            {{ number_format($savingAccount->transaction_limit, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.savingAccount.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\SavingAccount::STATUS_SELECT[$savingAccount->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.saving-accounts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection