@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.payout.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.payouts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="merchant_id">{{ trans('cruds.settlement.fields.merchant') }}</label>
                    <select class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}"
                        name="merchant_id" id="merchant_id">
                        <option value="">{{ trans('global.pleaseSelect') }}</option>
                        @foreach ($merchants as $id => $merchant)
                            <option value="{{ $merchant['id'] }}" data-value="{{ $merchant }}"
                                {{ old('merchant_id') == $merchant['id'] ? 'selected' : '' }} >{{ $merchant['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('merchant'))
                        <div class="invalid-feedback">
                            {{ $errors->first('merchant') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.settlement.fields.merchant_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="project_id">{{ trans('cruds.payout.fields.gate') }}</label>
                    <select class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="project_id"
                        id="project_id">
                        {{-- @foreach ($gates as $id => $gate)
                            <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>
                                {{ $gate }}</option>
                        @endforeach --}}
                    </select>
                    @if ($errors->has('gate'))
                        <div class="invalid-feedback">
                            {{ $errors->first('gate') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.gate_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="client_transaction">{{ trans('cruds.payout.fields.client_transaction') }}</label>
                    <input class="form-control {{ $errors->has('client_transaction') ? 'is-invalid' : '' }}" type="text"
                        name="client_transaction" id="client_transaction" value="{{ old('client_transaction') }}">
                    @if ($errors->has('client_transaction'))
                        <div class="invalid-feedback">
                            {{ $errors->first('client_transaction') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.client_transaction_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="amount">{{ trans('cruds.payout.fields.amount') }}</label>
                    <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number"
                        name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01">
                    @if ($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.amount_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="bank_name">{{ trans('cruds.payout.fields.bank_name') }}</label>
                    <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text"
                        name="bank_name" id="bank_name" value="{{ old('bank_name', '') }}">
                    @if ($errors->has('bank_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bank_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.bank_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="bank_account_name">{{ trans('cruds.payout.fields.bank_account_name') }}</label>
                    <input class="form-control {{ $errors->has('bank_account_name') ? 'is-invalid' : '' }}" type="text"
                        name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name', '') }}">
                    @if ($errors->has('bank_account_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bank_account_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.bank_account_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="bank_account_number">{{ trans('cruds.payout.fields.bank_account_number') }}</label>
                    <input class="form-control {{ $errors->has('bank_account_number') ? 'is-invalid' : '' }}" type="text"
                        name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', '') }}"
                        step="1">
                    @if ($errors->has('bank_account_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bank_account_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.bank_account_number_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="bank_branch">{{ trans('cruds.payout.fields.bank_branch') }}</label>
                    <input class="form-control {{ $errors->has('bank_branch') ? 'is-invalid' : '' }}" type="text"
                        name="bank_branch" id="bank_branch" value="{{ old('bank_branch') }}">
                    @if ($errors->has('bank_branch'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bank_branch') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.bank_branch_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="bank_city">{{ trans('cruds.payout.fields.bank_city') }}</label>
                    <input class="form-control {{ $errors->has('bank_city') ? 'is-invalid' : '' }}" type="text"
                        name="bank_city" id="bank_city" value="{{ old('bank_city') }}">
                    @if ($errors->has('bank_city'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bank_city') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.bank_city_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="bank_state">{{ trans('cruds.payout.fields.bank_state') }}</label>
                    <input class="form-control {{ $errors->has('bank_state') ? 'is-invalid' : '' }}" type="text"
                        name="bank_state" id="bank_state" value="{{ old('bank_state') }}">
                    @if ($errors->has('bank_state'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bank_state') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.bank_state_helper') }}</span>
                </div>

                {{-- <div class="form-group">
                    <label>{{ trans('cruds.payout.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status"
                        id="status">
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Payout::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.status_helper') }}</span>
                </div> --}}
                <div class="form-group">
                    <label for="remark">{{ trans('cruds.payout.fields.remark') }}</label>
                    <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text"
                        name="remark" id="remark" value="{{ old('remark', '') }}">
                    @if ($errors->has('remark'))
                        <div class="invalid-feedback">
                            {{ $errors->first('remark') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.remark_helper') }}</span>
                </div>
                {{-- <div class="form-group">
                    <label for="bulk_id">{{ trans('cruds.payout.fields.bulk') }}</label>
                    <select class="form-control select2 {{ $errors->has('bulk') ? 'is-invalid' : '' }}" name="bulk_id"
                        id="bulk_id">
                        @foreach ($bulks as $id => $bulk)
                            <option value="{{ $id }}" {{ old('bulk_id') == $id ? 'selected' : '' }}>
                                {{ $bulk }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('bulk'))
                        <div class="invalid-feedback">
                            {{ $errors->first('bulk') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.bulk_helper') }}</span>
                </div> --}}

                {{-- <div class="form-group">
                    <label for="payment_slip">{{ trans('cruds.payout.fields.payment_slip') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('payment_slip') ? 'is-invalid' : '' }}"
                        id="payment_slip-dropzone">
                    </div>
                    @if ($errors->has('payment_slip'))
                        <div class="invalid-feedback">
                            {{ $errors->first('payment_slip') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.payout.fields.payment_slip_helper') }}</span>
                </div> --}}
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        $(function() {

            giveSelection($('#merchant_id').val());

            $('#merchant_id').on('change', function() {
                giveSelection($(this).val());
            });

            function giveSelection(selValue) {

                if (selValue) {
                    var array = $('#merchant_id').children('option:selected').data('value');
                    var value = selValue;

                    // 这里申请ajax 拿取pg 银行列表
                    $.ajax({
                        type: "GET",
                        url: "/products/get_gate_list?merchant_id=" + array['id'] + "",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            gate_select_option = $('#project_id');
                            var val = gate_select_option.val();

                            gate_select_option.empty();

                            gate_select_option.append(new Option("Please select", ''));

                            data.forEach(element => {

                                if (val != null) {
                                    if (val == element.id) {
                                        gate_select_option.append('<option value="' + element
                                            .id +
                                            '" data-current_credit="' + element
                                            .current_credit +
                                            '" data-short_code="' + element.currency
                                            .short_code +
                                            '" selected >' + element.name + ' - ' + element
                                            .currency
                                            .short_code + ' ' + element.current_credit +
                                            '</option>');
                                    } else {
                                        gate_select_option.append('<option value="' + element
                                            .id +
                                            '" data-current_credit="' + element
                                            .current_credit +
                                            '" data-short_code="' + element.currency
                                            .short_code +
                                            '" >' + element.name + ' - ' + element.currency
                                            .short_code +
                                            ' ' + element.current_credit + '</option>');
                                    }
                                } else {
                                    gate_select_option.append('<option value="' + element.id +
                                        '" data-current_credit="' + element.current_credit +
                                        '" data-short_code="' + element.currency
                                        .short_code + '" >' +
                                        element.name + ' - ' + element.currency.short_code +
                                        ' ' +
                                        element.current_credit + '</option>');
                                }
                            });

                            // displayBankDetails(bank_id.value);
                            // onchangeCurrent_credit(project_id.value);
                        }
                    });

                } else {
                    var value = null;
                }
            }
        });

    </script>
    {{-- <script>
    Dropzone.options.paymentSlipDropzone = {
    url: '{{ route('admin.payouts.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="payment_slip"]').remove()
      $('form').append('<input type="hidden" name="payment_slip" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="payment_slip"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if (isset($payout) && $payout->payment_slip)
      var file = {!! json_encode($payout->payment_slip) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="payment_slip" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script> --}}
@endsection
