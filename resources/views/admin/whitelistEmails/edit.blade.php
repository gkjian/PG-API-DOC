@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.whitelistEmail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.whitelist-emails.update", [$whitelistEmail->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.whitelistEmail.fields.gate') }}</label>
                <select class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="gate_id" id="gate_id">
                    @foreach($gates as $id => $gate)
                        <option value="{{ $id }}" {{ (old('gate_id') ? old('gate_id') : $whitelistEmail->gate->id ?? '') == $id ? 'selected' : '' }}>{{ $gate }}</option>
                    @endforeach
                </select>
                @if($errors->has('gate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whitelistEmail.fields.gate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="emaill">{{ trans('cruds.whitelistEmail.fields.emaill') }}</label>
                <input class="form-control {{ $errors->has('emaill') ? 'is-invalid' : '' }}" type="email" name="emaill" id="emaill" value="{{ old('emaill', $whitelistEmail->emaill) }}">
                @if($errors->has('emaill'))
                    <div class="invalid-feedback">
                        {{ $errors->first('emaill') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whitelistEmail.fields.emaill_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.whitelistEmail.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\WhitelistEmail::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $whitelistEmail->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whitelistEmail.fields.status_helper') }}</span>
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