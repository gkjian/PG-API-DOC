@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.savingAccount.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.saving-accounts.update", [$savingAccount->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="bank_id">{{ trans('cruds.savingAccount.fields.bank_id') }}</label>
                <input class="form-control {{ $errors->has('bank_id') ? 'is-invalid' : '' }}" type="text" name="bank_id" id="bank_id" value="{{ old('bank_id', $savingAccount->bank_id) }}">
                @if($errors->has('bank_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_name">{{ trans('cruds.savingAccount.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $savingAccount->bank_name) }}">
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_name">{{ trans('cruds.savingAccount.fields.bank_account_name') }}</label>
                <input class="form-control {{ $errors->has('bank_account_name') ? 'is-invalid' : '' }}" type="text" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name', $savingAccount->bank_account_name) }}">
                @if($errors->has('bank_account_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.bank_account_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_number">{{ trans('cruds.savingAccount.fields.bank_account_number') }}</label>
                <input class="form-control {{ $errors->has('bank_account_number') ? 'is-invalid' : '' }}" type="text" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', $savingAccount->bank_account_number) }}" step="1">
                @if($errors->has('bank_account_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.bank_account_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="currency_id">{{ trans('cruds.savingAccount.fields.currency') }}</label>
                <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency_id" id="currency_id">
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach($currencies as $id => $currency)
                        <option value="{{ $currency['id'] }}" {{ old('currency_id ', $savingAccount->currency_id ) == $currency['id'] ? 'selected' : '' }}>{{ $currency['name'] }}&nbsp;-&nbsp;{{ $currency['short_code'] }}</option>
                    @endforeach
                </select>
                @if($errors->has('currency'))
                    <div class="invalid-feedback">
                        {{ $errors->first('currency') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.currency_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="daily_limit">{{ trans('cruds.savingAccount.fields.daily_limit') }}</label>
                <input class="form-control {{ $errors->has('daily_limit') ? 'is-invalid' : '' }}" type="number" name="daily_limit" id="daily_limit" value="{{ old('daily_limit', $savingAccount->daily_limit) }}" step="0.01">
                @if($errors->has('daily_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('daily_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.daily_limit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="transaction_limit">{{ trans('cruds.savingAccount.fields.transaction_limit') }}</label>
                <input class="form-control {{ $errors->has('transaction_limit') ? 'is-invalid' : '' }}" type="number" name="transaction_limit" id="transaction_limit" value="{{ old('transaction_limit', $savingAccount->transaction_limit) }}" step="0.01">
                @if($errors->has('transaction_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transaction_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.transaction_limit_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.savingAccount.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SavingAccount::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $savingAccount->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.savingAccount.fields.status_helper') }}</span>
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