@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.settlement.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.settlements.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="document_no">{{ trans('cruds.settlement.fields.transaction') }}</label>
                <input class="form-control {{ $errors->has('document_no') ? 'is-invalid' : '' }}" type="text" name="document_no" id="document_no" value="{{ old('document_no', $document_no) }}" readonly>
                @if($errors->has('document_no'))
                <div class="invalid-feedback">
                    {{ $errors->first('document_no') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.transaction_helper') }}</span>
            </div>

            @if(!$merchants)
            <input type="hidden" name='merchant_id' value="{{$merchant_id}}">
            @endif

            @if($merchants)
            <div class="form-group">
                <label for="merchant_id">{{ trans('cruds.settlement.fields.merchant') }}</label>
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
                <span class="help-block">{{ trans('cruds.settlement.fields.merchant_helper') }}</span>
            </div>
            @endif

            <div class="form-group">
                <label for="gate_id">{{ trans('cruds.gateSavingAccount.fields.gate') }}</label>
                <select onchange="onchangeCurrent_credit(this.value)" class="form-control select2 {{ $errors->has('gate') ? 'is-invalid' : '' }}" name="gate_id" id="gate_id">
                    <option value="">{{trans('global.pleaseSelect')}}</option>
                    @if($gates)
                        @foreach($gates as $id => $gate)
                            <option value="{{ $gate['id'] }}" data-current_credit="{{ $gate['current_credit'] }}" data-short_code="{{$gate['currency']['short_code']}}" {{ old('gate_id') == $gate['id'] ? 'selected' : '' }}>{{ $gate['name'] }} - {{$gate['currency']['short_code']}} {{ $gate['current_credit'] }}</option>
                        @endforeach
                    @endif
                </select>
                @if($errors->has('gate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.gateSavingAccount.fields.gate_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="amount">{{ trans('cruds.settlement.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" onchange="CheckingAmount(this.value)" min='0' type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01">
                <span id="current_credit" style="color: red;font-size: 90%;"></span>
                @if($errors->has('amount'))
                <div class="invalid-feedback">
                    {{ $errors->first('amount') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.amount_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="bank_id">{{ trans('cruds.settlement.fields.bank') }}</label>
                <select onchange="displayBankDetails(this.value)" class="form-control select2 {{ $errors->has('bank') ? 'is-invalid' : '' }}" name="bank_id" id="bank_id">
                    <option value="">{{trans('global.pleaseSelect')}}</option>
                    @foreach($banks as $id => $bank)
                    <option data-option="{{ $bank['merchant_id'] }}" data-value="{{ $bank }}" value="{{ $bank['id'] }}">{{ $bank['bank_name'] }}</option>
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
                <label for="bank_name">{{ trans('cruds.settlement.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', '') }}" readonly>
                @if($errors->has('bank_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_name">{{ trans('cruds.settlement.fields.bank_account_name') }}</label>
                <input class="form-control {{ $errors->has('bank_account_name') ? 'is-invalid' : '' }}" type="text" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name', '') }}" readonly>
                @if($errors->has('bank_account_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.bank_account_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account_number">{{ trans('cruds.settlement.fields.bank_account_number') }}</label>
                <input class="form-control {{ $errors->has('bank_account_number') ? 'is-invalid' : '' }}" type="text" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number', '') }}" step="1" readonly>
                @if($errors->has('bank_account_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.bank_account_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remark">{{ trans('cruds.settlement.fields.remark') }}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', '') }}">
                @if($errors->has('remark'))
                <div class="invalid-feedback">
                    {{ $errors->first('remark') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.settlement.fields.remark_helper') }}</span>
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
    var bank_id = document.querySelector('#bank_id');
    var gate_id = document.querySelector('#gate_id');
    var options2 = bank_id.querySelectorAll('option');

    function giveSelection(selValue) {

        if (selValue) {
            var array = $('#merchant_id').children('option:selected').data('value');
            var merchant_id = array['id'];

            var value = selValue;
        } else {
            var value = null;
            var merchant_id = null;
        }

        // 这里申请ajax 拿取pg 银行列表
        $.ajax({
            type: "GET",
            url: "/products/get_gate_list?merchant_id="+ merchant_id +"",
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
                            gate_select_option.append('<option value="' + element.id + '" data-current_credit="' + element.current_credit +'" data-short_code="' + element.currency.short_code + '" selected >' + element.name + ' - ' + element.currency.short_code + ' ' + element.current_credit + '</option>');
                        }else{
                            gate_select_option.append('<option value="' + element.id + '" data-current_credit="' + element.current_credit +'" data-short_code="' + element.currency.short_code + '" >' + element.name + ' - ' + element.currency.short_code + ' ' + element.current_credit + '</option>');
                        }
                    }else{
                        gate_select_option.append('<option value="' + element.id + '" data-current_credit="' + element.current_credit +'" data-short_code="' + element.currency.short_code + '" >' + element.name + ' - ' + element.currency.short_code + ' ' + element.current_credit + '</option>');
                    }
                });

                displayBankDetails(bank_id.value);
                onchangeCurrent_credit(gate_id.value);
            }
        });

        bank_id.innerHTML = '';
        for (var i = 0; i < options2.length; i++) {
            if (options2[i].dataset.option === value || options2[i].dataset.option === undefined) {
                bank_id.appendChild(options2[i]);
            }
        }
    }

    function onchangeCurrent_credit(value) {
        if (value) {
            var current_credit = $('#gate_id').children('option:selected').data('current_credit');
            var short_code = $('#gate_id').children('option:selected').data('short_code');
            
            $('#current_credit').text('( ' + short_code + ' ' + current_credit + " {{trans('cruds.merchant.fields.current_credit')}} )");

            if (current_credit > 0) {
                $("#amount").attr({
                    "max": current_credit,
                });
                $('#amount').attr('readonly', false);
            } else {
                resetAmountInput();
            }
        } else {
            $('#current_credit').text('');
            resetAmountInput();
        }
    }

    function resetAmountInput() {
        $('#amount').val('');
        $('#amount').attr('readonly', true);
    }

    function displayBankDetails(value) {
        if (value) {

            var array = $('#bank_id').children('option:selected').data('value');

            $("#bank_name").val(array['bank_name']);
            $("#bank_account_name").val(array['bank_account_name']);
            $("#bank_account_number").val(array['bank_account_number']);

        } else {
            $("#bank_name").val('');
            $("#bank_account_name").val('');
            $("#bank_account_number").val('');
        }
    }

    function CheckingAmount(value) {
        if (value < 0) {
            $('#amount').val(0);
        };
    };

    @if($merchants)
    giveSelection(merchant_id.value);
    @endif

    displayBankDetails(bank_id.value);
    onchangeCurrent_credit(gate_id.value);
</script>
@endsection
