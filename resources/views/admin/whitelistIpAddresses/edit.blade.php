@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.whitelistIpAddress.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.whitelist-ip-addresses.update", [$whitelistIpAddress->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.whitelistIpAddress.fields.gate') }}</label>
                <select class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="gate_id" id="gate_id">
                    @foreach($gates as $id => $gate)
                        <option value="{{ $id }}" {{ (old('gate_id') ? old('gate_id') : $whitelistIpAddress->gate->id ?? '') == $id ? 'selected' : '' }}>{{ $gate }}</option>
                    @endforeach
                </select>
                @if($errors->has('gate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whitelistIpAddress.fields.gate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ip_address">{{ trans('cruds.whitelistIpAddress.fields.ip_address') }}</label>
                <input class="form-control {{ $errors->has('ip_address') ? 'is-invalid' : '' }}" type="text" name="ip_address" id="ip_address" value="{{ old('ip_address', $whitelistIpAddress->ip_address) }}">
                @if($errors->has('ip_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ip_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whitelistIpAddress.fields.ip_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.whitelistIpAddress.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\WhitelistIpAddress::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $whitelistIpAddress->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whitelistIpAddress.fields.status_helper') }}</span>
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