@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.apiKey.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.api-keys.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="api_key">{{ trans('cruds.apiKey.fields.api_key') }}</label>
                <input class="form-control {{ $errors->has('api_key') ? 'is-invalid' : '' }}" type="text" name="api_key" id="api_key" value="{{ old('api_key', '') }}">
                @if($errors->has('api_key'))
                    <div class="invalid-feedback">
                        {{ $errors->first('api_key') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.apiKey.fields.api_key_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.apiKey.fields.gate') }}</label>
                <select class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="gate_id" id="gate_id">
                    @foreach($gates as $id => $gate)
                        <option value="{{ $id }}" {{ old('gate_id') == $id ? 'selected' : '' }}>{{ $gate }}</option>
                    @endforeach
                </select>
                @if($errors->has('gate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.apiKey.fields.gate_helper') }}</span>
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