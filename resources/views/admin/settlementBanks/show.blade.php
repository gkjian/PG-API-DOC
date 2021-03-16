@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.settlementBank.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.settlement-banks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.settlementBank.fields.id') }}
                        </th>
                        <td>
                            {{ $settlementBank->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.settlementBank.fields.merchant') }}
                        </th>
                        <td>
                            {{ $settlementBank->merchant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.settlementBank.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $settlementBank->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.settlementBank.fields.bank_account_name') }}
                        </th>
                        <td>
                            {{ $settlementBank->bank_account_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.settlementBank.fields.bank_account_number') }}
                        </th>
                        <td>
                            {{ $settlementBank->bank_account_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.settlementBank.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\SettlementBank::STATUS_SELECT[$settlementBank->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection