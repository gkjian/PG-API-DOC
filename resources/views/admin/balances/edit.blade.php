@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.balance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.balances.update", [$balance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="merchant_id">{{ trans('cruds.balance.fields.merchant') }}</label>
                <select class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}" name="merchant_id" id="merchant_id">
                    @foreach($merchants as $id => $merchant)
                        <option value="{{ $id }}" {{ (old('merchant_id') ? old('merchant_id') : $balance->merchant->id ?? '') == $id ? 'selected' : '' }}>{{ $merchant }}</option>
                    @endforeach
                </select>
                @if($errors->has('merchant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('merchant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.merchant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="debit">{{ trans('cruds.balance.fields.debit') }}</label>
                <input class="form-control {{ $errors->has('debit') ? 'is-invalid' : '' }}" type="text" name="debit" id="debit" value="{{ old('debit', $balance->debit) }}">
                @if($errors->has('debit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('debit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.debit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="credit">{{ trans('cruds.balance.fields.credit') }}</label>
                <input class="form-control {{ $errors->has('credit') ? 'is-invalid' : '' }}" type="text" name="credit" id="credit" value="{{ old('credit', $balance->credit) }}">
                @if($errors->has('credit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.credit_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.balance.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Balance::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $balance->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.balance.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Balance::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $balance->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="document_no">{{ trans('cruds.balance.fields.transaction') }}</label>
                <input class="form-control {{ $errors->has('document_no') ? 'is-invalid' : '' }}" type="text" name="document_no" id="document_no" value="{{ old('document_no', $balance->document_no) }}">
                @if($errors->has('document_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.transaction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.balance.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $balance->remark) }}">
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.balance.fields.settlement_status') }}</label>
                <select class="form-control {{ $errors->has('settlement_status') ? 'is-invalid' : '' }}" name="settlement_status" id="settlement_status">
                    <option value disabled {{ old('settlement_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Balance::SETTLEMENT_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('settlement_status', $balance->settlement_status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('settlement_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('settlement_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.settlement_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.balance.fields.gate') }}</label>
                <select class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="gate_id" id="gate_id">
                    @foreach($gates as $id => $gate)
                        <option value="{{ $id }}" {{ (old('gate_id') ? old('gate_id') : $balance->gate->id ?? '') == $id ? 'selected' : '' }}>{{ $gate }}</option>
                    @endforeach
                </select>
                @if($errors->has('gate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.gate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="saving_account_id">{{ trans('cruds.balance.fields.saving_account') }}</label>
                <select class="form-control select2 {{ $errors->has('saving_account') ? 'is-invalid' : '' }}" name="saving_account_id" id="saving_account_id">
                    @foreach($saving_accounts as $id => $saving_account)
                        <option value="{{ $id }}" {{ (old('saving_account_id') ? old('saving_account_id') : $balance->saving_account->id ?? '') == $id ? 'selected' : '' }}>{{ $saving_account }}</option>
                    @endforeach
                </select>
                @if($errors->has('saving_account'))
                    <div class="invalid-feedback">
                        {{ $errors->first('saving_account') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.saving_account_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="settlement_bank_id">{{ trans('cruds.balance.fields.settlement_bank') }}</label>
                <select class="form-control select2 {{ $errors->has('bank') ? 'is-invalid' : '' }}" name="settlement_bank_id" id="settlement_bank_id">
                    @foreach($settlement_banks as $id => $bank)
                        <option value="{{ $id }}" {{ (old('settlement_bank_id') ? old('settlement_bank_id') : $balance->settlement_bank->id ?? '') == $id ? 'selected' : '' }}>{{ $bank }}</option>
                    @endforeach
                </select>
                @if($errors->has('bank'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.balance.fields.settlement_bank_helper') }}</span>
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
