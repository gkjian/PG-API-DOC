@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.merchant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.merchants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.id') }}
                        </th>
                        <td>
                            {{ $merchant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.name') }}
                        </th>
                        <td>
                            {{ $merchant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.email') }}
                        </th>
                        <td>
                            {{ $merchant->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $merchant->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.person_incharge_name') }}
                        </th>
                        <td>
                            {{ $merchant->person_incharge_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.contact') }}
                        </th>
                        <td>
                            {{ $merchant->contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.roles') }}
                        </th>
                        <td>
                            @foreach($merchant->roles as $key => $roles)
                            <span class="label label-info">{{ $roles->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.merchant.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Merchant::STATUS_SELECT[$merchant->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.merchants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
