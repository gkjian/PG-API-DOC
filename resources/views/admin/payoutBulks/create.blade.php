@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.payoutBulk.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payout-bulks.store") }}" enctype="multipart/form-data">
            @csrf
            
            @if(!$merchants)
            <input type="hidden" name='merchant_id' value="{{$merchant_id}}">
            @endif

            @if($merchants)
            <div class="form-group">
                <label for="merchant_id">{{ trans('cruds.settlement.fields.merchant') }}</label>
                <select id='sel1' onchange="giveSelection(this.value)" class="form-control select2 {{ $errors->has('merchant') ? 'is-invalid' : '' }}" name="merchant_id" id="merchant_id">
                    <option value="">{{trans('global.pleaseSelect')}}</option>
                    @foreach($merchants as $id => $merchant)
                    <option value="{{ $merchant['id'] }}" data-value="{{ $merchant }}" {{ old('merchant_id') == $merchant['id'] ? 'selected' : '' }}>{{ $merchant['name'] }}</option>
                    @endforeach
                </select>
                <div class="mt-2">
                    <span style="color: red; font-size: 90%;" id="current_credit"></span>
                </div>
                @if($errors->has('merchant'))
                <div class="invalid-feedback">
                    {{ $errors->first('merchant') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.merchant_helper') }}</span>
            </div>
            @endif
            
            <div class="form-group">
                <label for="file_path">{{ trans('cruds.payoutBulk.fields.file_path') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file_path') ? 'is-invalid' : '' }}" id="file_path-dropzone">
                </div>
                @if($errors->has('file_path'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file_path') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payoutBulk.fields.file_path_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.payoutBulk.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.payoutBulk.fields.name_helper') }}</span>
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
    Dropzone.options.filePathDropzone = {
    url: '{{ route('admin.payout-bulks.storeMedia') }}',
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
      $('form').find('input[name="file_path"]').remove()
      $('form').append('<input type="hidden" name="file_path" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file_path"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($payoutBulk) && $payoutBulk->file_path)
      var file = {!! json_encode($payoutBulk->file_path) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file_path" value="' + file.file_name + '">')
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