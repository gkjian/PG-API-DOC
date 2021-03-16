@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.role.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <td>
                            {{ $role->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.title') }}
                        </th>
                        <td>
                            {{ $role->name }} ({{ $role->guard_name }})
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.created_at') }}
                        </th>
                        <td>
                            {{ $role->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.created_by') }}
                        </th>
                        <td>
                            {{ $role->created_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.modified_by') }}
                        </th>
                        <td>
                            {{ $role->modified_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.permissions') }}
                        </th>
                        <td>
                            <div class='row'>
                                @foreach($role->permissions as $key => $permissions)
                                    <span class="label label-info label-many col-3">{{ $permissions->name }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
