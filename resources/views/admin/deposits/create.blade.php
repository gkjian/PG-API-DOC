@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.deposit.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.deposits.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="document_no">{{ trans('cruds.deposit.fields.document_no') }}</label>
                <input class="form-control {{ $errors->has('document_no') ? 'is-invalid' : '' }}" type="text" name="document_no" id="document_no" value="{{ old('document_no', $document_no) }}" readonly>
                @if($errors->has('document_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.document_no_helper') }}</span>
            </div>

            @if (!$merchants)
            <input type="hidden" name='merchant_id' value="{{ $merchant_id }}">
            @endif

            @if ($merchants)
            <div class="form-group">
                <label for="merchant_id">{{ trans('cruds.deposit.fields.merchant') }}</label>
                <select onchange="giveSelection(this.value)" class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}" name="merchant_id" id="merchant_id">
                    <option value="">{{trans('global.pleaseSelect')}}</option>
                    @foreach($merchants as $id => $merchant)
                    <option value="{{ $merchant['id'] }}" data-value="{{ $merchant }}" {{ old('merchant_id') == $merchant['id'] ? 'selected' : '' }}>{{ $merchant['name'] }}</option>
                    @endforeach
                </select>
                @if($errors->has('merchant'))
                <div class="invalid-feedback">
                    {{ $errors->first('merchant') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.merchant_helper') }}</span>
            </div>
            @endif

            <div class="form-group">
                <label for="amount">{{ trans('cruds.deposit.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" min="0" id="amount" value="{{ old('amount', '') }}" step="0.01">
                @if($errors->has('amount'))
                <div class="invalid-feedback">
                    {{ $errors->first('amount') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.amount_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.gateSavingAccount.fields.gate') }}</label>
                <select class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="gate_id" id="gate_id">
                    <option value="">{{trans('global.pleaseSelect')}}</option>
                    @foreach($gates as $id => $gate)
                        <option value="{{ $gate['id'] }}" data-value="{{ $gate['current_credit'] }}" {{ old('gate_id') == $gate['id'] ? 'selected' : '' }}>{{ $gate['name'] }}</option>
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
                <label for="description">{{ trans('cruds.deposit.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                <div class="invalid-feedback">
                    {{ $errors->first('description') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.deposit.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', '') }}">
                @if($errors->has('remark'))
                <div class="invalid-feedback">
                    {{ $errors->first('remark') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.deposit.fields.remark_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_slip">{{ trans('cruds.payout.fields.payment_slip') }}</label>
                <div class="needsclick dropzone {{ $errors->has('payment_slip') ? 'is-invalid' : '' }}" id="payment_slip-dropzone">
                </div>
                @if($errors->has('payment_slip'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_slip') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.payment_slip_helper') }}</span>
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
    var merchant_id = document.querySelector('#merchant_id');
    var gate_id = document.querySelector('#gate_id');

    function giveSelection(selValue) {

        if (selValue) {
            var array = $('#merchant_id').children('option:selected').data('value');

            // 这里申请ajax 拿取pg 银行列表
            $.ajax({
                type: "GET",
                url: "/products/get_gate_list?merchant_id="+array['id']+"",
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    gate_select_option = $('#gate_id');
                    var val = gate_select_option.val();

                    gate_select_option.empty();

                    gate_select_option.append(new Option("Please select", ''));

                    data.forEach(element => {

                        if(val != null){
                            if(val == element.id){
                                gate_select_option.append('<option value="' + element.id + '" data-value="' + element.current_credit +'" selected >' + element.name + '</option>');
                            }else{
                                gate_select_option.append('<option value="' + element.id + '" data-value="' + element.current_credit +'" >' + element.name + '</option>');
                            }
                        }else{
                            gate_select_option.append('<option value="' + element.id + '" data-value="' + element.current_credit +'" >' + element.name + '</option>');
                        }
                    });
                }
            });

        }
    }

    @if($merchants)
    giveSelection(merchant_id.value);
    @endif

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
