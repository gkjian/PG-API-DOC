@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.permission.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.permissions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.id') }}
                        </th>
                        <td>
                            {{ $permission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                        <td>
                            {{ $permission->name }} ({{ $permission->guard_name}})
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.created_at') }}
                        </th>
                        <td>
                            {{ $permission->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.created_by') }}
                        </th>
                        <td>
                            {{ $permission->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.modified_by') }}
                        </th>
                        <td>
                            {{ $permission->modified_by->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.permissions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
