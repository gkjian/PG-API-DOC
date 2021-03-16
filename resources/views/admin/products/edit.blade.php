@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.project.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.update', [$product->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="gate_id">{{ trans('cruds.project.fields.gate_id') }}</label>
                    <input class="form-control {{ $errors->has('gate_id') ? 'is-invalid' : '' }}" type="text"
                        name="gate_id" id="gate_id" value="{{ old('gate_id', $product->gate_id) }}" readonly>
                    @if ($errors->has('gate_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('gate_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.gate_id_helper') }}</span>
                </div>

                @if (!$merchants)
                    <input type="hidden" name='merchant_id' value="{{ $merchant_id }}">
                @endif

                @if ($merchants)
                    <div class="form-group">
                        <label for="merchant_id">{{ trans('cruds.project.fields.merchant') }}</label>
                        <select class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}"
                            name="merchant_id" id="merchant_id">
                            @foreach ($merchants as $id => $merchant)
                                <option value="{{ $merchant['id'] }}"
                                    {{ (old('merchant_id') ? old('merchant_id') : $product->merchant->id ?? '') == $merchant['id'] ? 'selected' : '' }}>
                                    {{ $merchant['name'] }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('merchant'))
                            <div class="invalid-feedback">
                                {{ $errors->first('merchant') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.project.fields.merchant_helper') }}</span>
                    </div>
                @endif

                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.project.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $product->name) }}" required>
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.name_helper') }}</span>
                </div>
                {{-- <div class="form-group">
                    <label for="secret_key">{{ trans('cruds.product.fields.secret_key') }}</label>
                    <input class="form-control {{ $errors->has('secret_key') ? 'is-invalid' : '' }}" type="text"
                        name="secret_key" id="secret_key" value="{{ old('secret_key', $product->secret_key) }}">
                    @if ($errors->has('secret_key'))
                        <div class="invalid-feedback">
                            {{ $errors->first('secret_key') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.secret_key_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="product_key">{{ trans('cruds.product.fields.product_key') }}</label>
                    <input class="form-control {{ $errors->has('product_key') ? 'is-invalid' : '' }}" type="text"
                        name="product_key" id="product_key" value="{{ old('product_key', $product->product_key) }}">
                    @if ($errors->has('product_key'))
                        <div class="invalid-feedback">
                            {{ $errors->first('product_key') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.product_key_helper') }}</span>
                </div> --}}
                <div class="form-group">
                    <label for="callback_url">{{ trans('cruds.project.fields.callback_url') }}</label>
                    <input class="form-control {{ $errors->has('callback_url') ? 'is-invalid' : '' }}" type="text"
                        name="callback_url" id="callback_url" value="{{ old('callback_url', $product->callback_url) }}">
                    @if ($errors->has('callback_url'))
                        <div class="invalid-feedback">
                            {{ $errors->first('callback_url') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.callback_url_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="redirect_url">{{ trans('cruds.project.fields.redirect_url') }}</label>
                    <input class="form-control {{ $errors->has('redirect_url') ? 'is-invalid' : '' }}" type="text"
                        name="redirect_url" id="redirect_url" value="{{ old('redirect_url', $product->redirect_url) }}">
                    @if ($errors->has('redirect_url'))
                        <div class="invalid-feedback">
                            {{ $errors->first('redirect_url') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.redirect_url_helper') }}</span>
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.project.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status"
                        id="status">
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Product::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status', $product->status) === (string) $key ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.project.fields.description') }}</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                        name="description" id="description" value="{{ old('description', $product->description) }}">
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="currency_id">{{ trans('cruds.project.fields.currency') }}</label>
                    <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}"
                        name="currency_id" id="currency_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($currencies as $id => $currency)
                            <option value="{{ $currency['id'] }}"
                                {{ old('currency_id ', $product->currency_id) == $currency['id'] ? 'selected' : '' }}>
                                {{ $currency['name'] }}&nbsp;-&nbsp;{{ $currency['short_code'] }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('currency'))
                        <div class="invalid-feedback">
                            {{ $errors->first('currency') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.currency_helper') }}</span>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.fee_calculation_type') }}
                                <span
                                    style="color:rgb(233, 41, 41)">({{ trans('cruds.project.fields.fee_calculation_type_desc') }})</span></label>
                            <br>
                            @foreach (App\Models\Product::FEE_CALCULATION_TYPE as $key => $label)
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" id="inline-radio1" readonly value="{{ $key }}"
                                        name="processing_fee_calc_type" type="radio"
                                        {{ old('processing_fee_calc', $product->processing_fee_calc_type) == $key ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="inline-radio1">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> --}}

                <h5>Processing Fee</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.deposit') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" step="0.01" min="0" name="processing_fee[deposit][0][rate]" id=""
                                value="{{ old('', $product->processing_fee->deposit[0]->rate) }}" required min="0"
                                max="100">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.deposit') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" min="0" step="0.01" name="processing_fee[deposit][0][fix]" id=""
                                value="{{ old('', $product->processing_fee->deposit[0]->fix) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.settlement') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" step="0.01" name="processing_fee[settlement][0][rate]" id=""
                                value="{{ old('', $product->processing_fee->settlement[0]->rate) }}" required min="0"
                                max="100">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.settlement') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" min="0" step="0.01" name="processing_fee[settlement][0][fix]" id=""
                                value="{{ old('', $product->processing_fee->settlement[0]->fix) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" step="0.01" name="processing_fee[payout][0][rate]" id=""
                                value="{{ old('', $product->processing_fee->payout[0]->rate) }}" required min="0"
                                max="100">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" min="0" step="0.01" name="processing_fee[payout][0][fix]" id=""
                                value="{{ old('', $product->processing_fee->payout[0]->fix) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.top_up') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" step="0.01" name="processing_fee[top_up][0][rate]" id=""
                                value="{{ old('', $product->processing_fee->top_up[0]->rate) }}" required min="0"
                                max="100">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.top_up') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" min="0" step="0.01" name="processing_fee[top_up][0][fix]" id=""
                                value="{{ old('', $product->processing_fee->top_up[0]->fix) }}" required>
                        </div>
                    </div>
                </div>
                <h5>Processing Fee (Merchant)</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.top_up') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" step="0.01" name="processing_fee[top_up_merchant][0][rate]" id=""
                                value="{{ old('', $product->processing_fee->top_up_merchant[0]->rate) }}" required
                                min="0" max="100" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.top_up') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" min="0" step="0.01" name="processing_fee[top_up_merchant][0][fix]" id=""
                                value="{{ old('', $product->processing_fee->top_up_merchant[0]->fix) }}" required
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" step="0.01" name="processing_fee[payout_merchant][0][rate]" id=""
                                value="{{ old('', $product->processing_fee->payout_merchant[0]->rate) }}" required
                                min="0" max="100" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" min="0" step="0.01" name="processing_fee[payout_merchant][0][fix]" id=""
                                value="{{ old('', $product->processing_fee->payout_merchant[0]->fix) }}" required
                                readonly>
                        </div>
                    </div>
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
