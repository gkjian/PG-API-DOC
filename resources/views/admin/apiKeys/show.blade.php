@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.apiKey.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.api-keys.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.apiKey.fields.id') }}
                        </th>
                        <td>
                            {{ $apiKey->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.apiKey.fields.api_key') }}
                        </th>
                        <td>
                            {{ $apiKey->api_key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.apiKey.fields.gate') }}
                        </th>
                        <td>
                            {{ $apiKey->gate->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.api-keys.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection