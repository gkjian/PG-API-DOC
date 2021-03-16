@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.project.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                @if (!$merchants)
                    <input type="hidden" name='merchant_id' value="{{ $merchant_id }}">
                @endif

                @if ($merchants)
                    <div class="form-group">
                        <label class="required" for="merchant_id">{{ trans('cruds.settlement.fields.merchant') }}</label>
                        <select id='sel1' class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}"
                            name="merchant_id" id="merchant_id">
                            <option value="">{{ trans('global.pleaseSelect') }}</option>
                            @foreach ($merchants as $id => $merchant)
                                <option value="{{ $merchant['id'] }}"
                                    {{ old('merchant_id') == $merchant['id'] ? 'selected' : '' }}>
                                    {{ $merchant['name'] }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('merchant'))
                            <div class="invalid-feedback">
                                {{ $errors->first('merchant') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.settlement.fields.merchant_helper') }}</span>
                    </div>
                @endif
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.project.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="callback_url">{{ trans('cruds.project.fields.callback_url') }}</label>
                    <input class="form-control {{ $errors->has('callback_url') ? 'is-invalid' : '' }}" type="text"
                        name="callback_url" id="callback_url" value="{{ old('callback_url', '') }}">
                    @if ($errors->has('callback_url'))
                        <div class="invalid-feedback">
                            {{ $errors->first('callback_url') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.callback_url_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="redirect_url">{{ trans('cruds.project.fields.redirect_url') }}</label>
                    <input class="form-control {{ $errors->has('redirect_url') ? 'is-invalid' : '' }}" type="text"
                        name="redirect_url" id="redirect_url" value="{{ old('redirect_url', '') }}" >
                    @if ($errors->has('redirect_url'))
                        <div class="invalid-feedback">
                            {{ $errors->first('redirect_url') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.redirect_url_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.project.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status"
                        id="status">
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Product::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                        name="description" id="description" value="{{ old('description', '') }}">
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="currency_id">{{ trans('cruds.project.fields.currency') }}</label>
                    <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}"
                        name="currency_id" id="currency_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($currencies as $id => $currency)
                            <option value="{{ $currency['id'] }}">
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
                                    <input class="form-check-input" id="inline-radio1" value="{{ $key }}" disabled
                                        name="processing_fee_calc_type" type="radio"
                                        {{ old('processing_fee_calc_type', '') == $key ? 'checked' : '' }} required>
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
                            <input class="form-control" type="number" name="processing_fee[deposit][0][rate]" id=""
                                value="{{ old('processing_fee.deposit.0.rate', '') }}" min="0" max="100" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.deposit') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" name="processing_fee[deposit][0][fix]" id=""
                                value="{{ old('processing_fee.deposit.0.fix', '') }}" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.settlement') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" name="processing_fee[settlement][0][rate]" id=""
                                value="{{ old('processing_fee.settlement.0.rate', '') }}" min="0" max="100" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.settlement') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" name="processing_fee[settlement][0][fix]" id=""
                                value="{{ old('processing_fee.settlement.0.fix', '') }}" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" name="processing_fee[payout][0][rate]" id=""
                                value="{{ old('processing_fee.payout.0.rate', '') }}" min="0" max="100" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" name="processing_fee[payout][0][fix]" id=""
                                value="{{ old('processing_fee.payout.0.fix', '') }}" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.top_up') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" name="processing_fee[top_up][0][rate]" id=""
                                value="{{ old('processing_fee.top_up.0.rate', '') }}" min="0" max="100" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.top_up') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" name="processing_fee[top_up][0][fix]" id=""
                                value="{{ old('processing_fee.top_up.0.fix', '') }}" min="0" step="0.01" required>
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
                            <input class="form-control" type="number" value="0"
                                name="processing_fee[top_up_merchant][0][rate]" id=""
                                value="{{ old('processing_fee.top_up_merchant.0.rate', '') }}" min="0" max="100"
                                required step="0.01" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.top_up') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" value="0"
                                name="processing_fee[top_up_merchant][0][fix]" id=""
                                value="{{ old('processing_fee.top_up_merchant.0.fix', '') }}" required min="0" step="0.01" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.rate') }})</label>
                            <br>
                            <input class="form-control" type="number" value="0"
                                name="processing_fee[payout_merchant][0][rate]" id=""
                                value="{{ old('processing_fee.payout_merchant.0.rate', '') }}" min="0" max="100"
                                required step="0.01" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('cruds.project.fields.payout') }}
                                ({{ trans('cruds.project.fields.fix') }})</label>
                            <br>
                            <input class="form-control" type="number" value="0" name="processing_fee[payout_merchant][0][fix]" id=""
                                value="{{ old('processing_fee.payout_merchant.0.fix', '') }}" min="0" value="0" step="0.01" required readonly>
                        </div>
                    </div>
                </div>

                {{-- <div class="element"></div> --}}
                {{-- <div class="form-group">
                    <a style="cursor: pointer" class="create_element"><i class="fa fa-plus-square fa-2x" aria-hidden="true"
                            style="color: green"></i></a>
                </div> --}}
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- <div id="element_create" style="display: none">
        <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    <a style="cursor: pointer" class="remove_element"><i class="fa fa-minus-square fa-2x" style="color: red"
                            aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="col-form-label">{{ trans('cruds.project.fields.fee_type') }}</label>
                    <br>
                    @foreach (App\Models\SettingProcessingFee::FEE_TYPE as $key => $label)
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio1" type="radio" value="{{ $key }}"
                                name="process_fee[]['fee_type']">
                            <label class="form-check-label" for="inline-radio1">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label">{{ trans('cruds.project.fields.type') }}</label>
                    <br>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                        name="process_fee[]['status']">
                        <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\SettingProcessingFee::TYPE as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label">{{ trans('cruds.project.fields.range_min') }}</label>
                    <br>
                    <input class="form-control" type="number" name="" id="" value="">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label">{{ trans('cruds.project.fields.range_max') }}</label>
                    <br>
                    <input class="form-control" type="number" name="" id="" value="">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label">{{ trans('cruds.project.fields.value') }}</label>
                    <br>
                    <input class="form-control" type="number" name="" id="" value="">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="col-form-label">{{ trans('cruds.project.fields.status') }}</label>
                    <br>
                    @foreach (App\Models\SettingProcessingFee::STATUS_SELECT as $key => $label)
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-radio1" type="radio">
                            <label class="form-check-label" for="inline-radio1">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div> --}}

@endsection


@section('scripts')
    @parent

    {{-- <script>
        $('.create_element').click(function(e) {
            $('.element').append($('#element_create').html())
        });

        $(document).on('click', '.remove_element', function() {
            $(this).parent().parent().parent().remove();
        });

        // $('#form').on('submit', function(e) {
        //     e.preventDefault();

        //     $.ajax({

        //     });
        // })

    </script> --}}
@endsection
