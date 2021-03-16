@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.payoutBank.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payout-banks.update", [$payoutBank->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="bank_name">{{ trans('cruds.payoutBank.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $payoutBank->bank_name) }}">
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payoutBank.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_name">{{ trans('cruds.payoutBank.fields.bank_account_name') }}</label>
                <input class="form-control {{ $errors->has('bank_account_name') ? 'is-invalid' : '' }}" type="text" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name', $payoutBank->bank_account_name) }}">
                @if($errors->has('bank_account_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payoutBank.fields.bank_account_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_number">{{ trans('cruds.payoutBank.fields.bank_account_number') }}</label>
                <input class="form-control {{ $errors->has('bank_account_number') ? 'is-invalid' : '' }}" type="text" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', $payoutBank->bank_account_number) }}" step="1">
                @if($errors->has('bank_account_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payoutBank.fields.bank_account_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_currency">{{ trans('cruds.payoutBank.fields.bank_currency') }}</label>
                <input class="form-control {{ $errors->has('bank_currency') ? 'is-invalid' : '' }}" type="text" name="bank_currency" id="bank_currency" value="{{ old('bank_currency', $payoutBank->bank_currency) }}">
                @if($errors->has('bank_currency'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_currency') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payoutBank.fields.bank_currency_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payout_id">{{ trans('cruds.payoutBank.fields.payout') }}</label>
                <select class="form-control select2 {{ $errors->has('payout') ? 'is-invalid' : '' }}" name="payout_id" id="payout_id">
                    @foreach($payouts as $id => $payout)
                        <option value="{{ $id }}" {{ (old('payout_id') ? old('payout_id') : $payoutBank->payout->id ?? '') == $id ? 'selected' : '' }}>{{ $payout }}</option>
                    @endforeach
                </select>
                @if($errors->has('payout'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payout') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payoutBank.fields.payout_helper') }}</span>
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