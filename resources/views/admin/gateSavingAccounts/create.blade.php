@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.gateSavingAccount.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.gate-saving-accounts.store") }}" enctype="multipart/form-data">
            @csrf
          
            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.gateSavingAccount.fields.gate') }}</label>
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
                <span class="help-block">{{ trans('cruds.gateSavingAccount.fields.gate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="saving_account_id">{{ trans('cruds.gateSavingAccount.fields.saving_account') }}</label>
                <select class="form-control select2 {{ $errors->has('saving_account') ? 'is-invalid' : '' }}" name="saving_account_id" id="saving_account_id">
                    @foreach($saving_accounts as $id => $saving_account)
                        <option value="{{ $id }}" {{ old('saving_account_id') == $id ? 'selected' : '' }}>{{ $saving_account }}</option>
                    @endforeach
                </select>
                @if($errors->has('saving_account'))
                    <div class="invalid-feedback">
                        {{ $errors->first('saving_account') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateSavingAccount.fields.saving_account_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="daily_limit">{{ trans('cruds.gateSavingAccount.fields.daily_limit') }}</label>
                <input class="form-control {{ $errors->has('daily_limit') ? 'is-invalid' : '' }}" type="number" name="daily_limit" id="daily_limit" value="{{ old('daily_limit') }}">
                @if($errors->has('daily_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('daily_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateSavingAccount.fields.gate_helper') }}</span>
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