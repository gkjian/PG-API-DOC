@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.gateSavingAccount.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gate-saving-accounts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.gateSavingAccount.fields.id') }}
                        </th>
                        <td>
                            {{ $gateSavingAccount->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateSavingAccount.fields.gate') }}
                        </th>
                        <td>
                            {{ $gateSavingAccount->gate->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateSavingAccount.fields.saving_account') }}
                        </th>
                        <td>
                            {{ $gateSavingAccount->saving_account->bank_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gateSavingAccount.fields.daily_limit') }}
                        </th>
                        <td>
                            {{ number_format($gateSavingAccount->daily_limit, 2) ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.gate-saving-accounts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection