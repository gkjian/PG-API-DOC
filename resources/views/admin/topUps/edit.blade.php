@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.topUp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.top-ups.update", [$topUp->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="merchant_id">{{ trans('cruds.topUp.fields.merchant') }}</label>
                <select class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}" name="merchant_id" id="merchant_id">
                    @foreach($merchants as $id => $merchant)
                        <option value="{{ $id }}" {{ (old('merchant_id') ? old('merchant_id') : $topUp->merchant->id ?? '') == $id ? 'selected' : '' }}>{{ $merchant }}</option>
                    @endforeach
                </select>
                @if($errors->has('merchant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('merchant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.merchant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.topUp.fields.gate') }}</label>
                <select class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="gate_id" id="gate_id">
                    @foreach($gates as $id => $gate)
                        <option value="{{ $id }}" {{ (old('gate_id') ? old('gate_id') : $topUp->gate->id ?? '') == $id ? 'selected' : '' }}>{{ $gate }}</option>
                    @endforeach
                </select>
                @if($errors->has('gate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.gate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount">{{ trans('cruds.topUp.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $topUp->amount) }}" step="0.01">
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="processing_fee">{{ trans('cruds.topUp.fields.processing_fee') }}</label>
                <input class="form-control {{ $errors->has('processing_fee') ? 'is-invalid' : '' }}" type="number" name="processing_fee" id="processing_fee" value="{{ old('processing_fee', $topUp->processing_fee) }}" step="0.01">
                @if($errors->has('processing_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('processing_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.processing_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="document_no">{{ trans('cruds.topUp.fields.transaction') }}</label>
                <input class="form-control {{ $errors->has('document_no') ? 'is-invalid' : '' }}" type="text" name="document_no" id="document_no" value="{{ old('document_no', $topUp->document_no) }}">
                @if($errors->has('document_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.transaction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="client_transaction">{{ trans('cruds.topUp.fields.client_transaction') }}</label>
                <input class="form-control {{ $errors->has('client_transaction') ? 'is-invalid' : '' }}" type="text" name="client_transaction" id="client_transaction" value="{{ old('client_transaction', $topUp->client_transaction) }}">
                @if($errors->has('client_transaction'))
                    <div class="invalid-feedback">
                        {{ $errors->first('client_transaction') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.client_transaction_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.topUp.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\TopUp::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $topUp->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.topUp.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $topUp->remark) }}">
                @if($errors->has('remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_slip">{{ trans('cruds.topUp.fields.payment_slip') }}</label>
                <div class="needsclick dropzone {{ $errors->has('payment_slip') ? 'is-invalid' : '' }}" id="payment_slip-dropzone">
                </div>
                @if($errors->has('payment_slip'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_slip') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.payment_slip_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="freeze">{{ trans('cruds.topUp.fields.freeze') }}</label>
                <input class="form-control {{ $errors->has('freeze') ? 'is-invalid' : '' }}" type="number" name="freeze" id="freeze" value="{{ old('freeze', $topUp->freeze) }}" step="1">
                @if($errors->has('freeze'))
                    <div class="invalid-feedback">
                        {{ $errors->first('freeze') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.freeze_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="signature">{{ trans('cruds.topUp.fields.signature') }}</label>
                <input class="form-control {{ $errors->has('signature') ? 'is-invalid' : '' }}" type="text" name="signature" id="signature" value="{{ old('signature', $topUp->signature) }}">
                @if($errors->has('signature'))
                    <div class="invalid-feedback">
                        {{ $errors->first('signature') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topUp.fields.signature_helper') }}</span>
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
    url: '{{ route('admin.top-ups.storeMedia') }}',
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
@if(isset($topUp) && $topUp->payment_slip)
      var file = {!! json_encode($topUp->payment_slip) !!}
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
