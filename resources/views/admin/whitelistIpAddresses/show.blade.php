@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.whitelistIpAddress.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whitelist-ip-addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.whitelistIpAddress.fields.id') }}
                        </th>
                        <td>
                            {{ $whitelistIpAddress->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whitelistIpAddress.fields.gate') }}
                        </th>
                        <td>
                            {{ $whitelistIpAddress->gate->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whitelistIpAddress.fields.ip_address') }}
                        </th>
                        <td>
                            {{ $whitelistIpAddress->ip_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whitelistIpAddress.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\WhitelistIpAddress::STATUS_SELECT[$whitelistIpAddress->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whitelist-ip-addresses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection