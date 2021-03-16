@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.settlement.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settlements.update", [$settlement->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="merchant_id">{{ trans('cruds.settlement.fields.merchant') }}</label>
                <select class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}" name="merchant_id" id="merchant_id">
                    @foreach($merchants as $id => $merchant)
                        <option value="{{ $id }}" {{ (old('merchant_id') ? old('merchant_id') : $settlement->merchant->id ?? '') == $id ? 'selected' : '' }}>{{ $merchant }}</option>
                    @endforeach
                </select>
                @if($errors->has('merchant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('merchant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.merchant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount">{{ trans('cruds.settlement.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $settlement->amount) }}" step="0.01">
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_name">{{ trans('cruds.settlement.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $settlement->bank_name) }}">
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_name">{{ trans('cruds.settlement.fields.bank_account_name') }}</label>
                <input class="form-control {{ $errors->has('bank_account_name') ? 'is-invalid' : '' }}" type="text" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name', $settlement->bank_account_name) }}">
                @if($errors->has('bank_account_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.bank_account_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_number">{{ trans('cruds.settlement.fields.bank_account_number') }}</label>
                <input class="form-control {{ $errors->has('bank_account_number') ? 'is-invalid' : '' }}" type="text" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', $settlement->bank_account_number) }}" step="1">
                @if($errors->has('bank_account_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.bank_account_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.settlement.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Settlement::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $settlement->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.settlement.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $settlement->remark) }}">
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="document_no">{{ trans('cruds.settlement.fields.transaction') }}</label>
                <input class="form-control {{ $errors->has('document_no') ? 'is-invalid' : '' }}" type="text" name="document_no" id="document_no" value="{{ old('document_no', $settlement->document_no) }}">
                @if($errors->has('document_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.transaction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_id">{{ trans('cruds.settlement.fields.bank') }}</label>
                <select class="form-control select2 {{ $errors->has('bank') ? 'is-invalid' : '' }}" name="bank_id" id="bank_id">
                    @foreach($banks as $id => $bank)
                        <option value="{{ $id }}" {{ (old('bank_id') ? old('bank_id') : $settlement->bank->id ?? '') == $id ? 'selected' : '' }}>{{ $bank }}</option>
                    @endforeach
                </select>
                @if($errors->has('bank'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.bank_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_slip">{{ trans('cruds.settlement.fields.payment_slip') }}</label>
                <div class="needsclick dropzone {{ $errors->has('payment_slip') ? 'is-invalid' : '' }}" id="payment_slip-dropzone">
                </div>
                @if($errors->has('payment_slip'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_slip') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.payment_slip_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.paymentSlipDropzone = {
    url: '{{ route('admin.settlements.storeMedia') }}',
    maxFilesize: 5, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
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
@if(isset($settlement) && $settlement->payment_slip)
      var file = {!! json_encode($settlement->payment_slip) !!}
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
</script>
@endsection
