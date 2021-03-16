@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.permissions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.permission.fields.guard_name') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="guard_name" id="guard_name">
                    <option value disabled {{ old('guard_name', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    <option value="admin" {{ old('guard_name', '') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="merchant" {{ old('guard_name', '') === 'merchant' ? 'selected' : '' }}>Merchant</option>
                    <option value="partner" {{ old('guard_name', '') === 'partner' ? 'selected' : '' }}>Partner</option>
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
