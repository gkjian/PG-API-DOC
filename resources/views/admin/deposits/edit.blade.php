@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.deposit.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.deposits.update", [$deposit->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="document_no">{{ trans('cruds.deposit.fields.document_no') }}</label>
                <input class="form-control {{ $errors->has('document_no') ? 'is-invalid' : '' }}" type="text" name="document_no" id="document_no" value="{{ old('document_no', $deposit->document_no) }}" readonly>
                @if($errors->has('document_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.transaction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="merchant_id">{{ trans('cruds.deposit.fields.merchant') }}</label>
                <select class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}" name="merchant_id" id="merchant_id">
                    @foreach($merchants as $id => $merchant)
                        <option value="{{ $id }}" {{ (old('merchant_id') ? old('merchant_id') : $deposit->merchant->id ?? '') == $id ? 'selected' : '' }}>{{ $merchant }}</option>
                    @endforeach
                </select>
                @if($errors->has('merchant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('merchant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.merchant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount">{{ trans('cruds.deposit.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $deposit->amount) }}" step="0.01">
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="processing_fee">{{ trans('cruds.deposit.fields.processing_fee') }}</label>
                <input class="form-control {{ $errors->has('processing_fee') ? 'is-invalid' : '' }}" type="number" name="processing_fee" id="processing_fee" value="{{ old('processing_fee', $deposit->processing_fee) }}" step="0.01">
                @if($errors->has('processing_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('processing_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.processing_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="processing_rate">{{ trans('cruds.deposit.fields.processing_rate') }}</label>
                <input class="form-control {{ $errors->has('processing_rate') ? 'is-invalid' : '' }}" type="number" name="processing_rate" id="processing_rate" value="{{ old('processing_rate', $deposit->processing_rate) }}" step="0.01">
                @if($errors->has('processing_rate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('processing_rate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.processing_rate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="currency_id">{{ trans('cruds.deposit.fields.currency') }}</label>
                <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency_id" id="currency_id">
                    @foreach($currencies as $id => $currency)
                        <option value="{{ $id }}" {{ (old('currency_id') ? old('currency_id') : $deposit->currency->id ?? '') == $id ? 'selected' : '' }}>{{ $currency }}</option>
                    @endforeach
                </select>
                @if($errors->has('currency'))
                    <div class="invalid-feedback">
                        {{ $errors->first('currency') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.currency_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.deposit.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $deposit->description) }}">
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.deposit.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Deposit::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $deposit->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.deposit.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $deposit->remark) }}">
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_slip">{{ trans('cruds.deposit.fields.payment_slip') }}</label>
                <div class="needsclick dropzone {{ $errors->has('payment_slip') ? 'is-invalid' : '' }}" id="payment_slip-dropzone">
                </div>
                @if($errors->has('payment_slip'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_slip') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.payment_slip_helper') }}</span>
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
    url: '{{ route('admin.deposits.storeMedia') }}',
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
@if(isset($deposit) && $deposit->payment_slip)
      var file = {!! json_encode($deposit->payment_slip) !!}
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
