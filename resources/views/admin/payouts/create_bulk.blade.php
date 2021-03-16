@extends('layouts.admin')
@section('content')

    {{-- {{dd($gate_arr)}} --}}

    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    {{ trans('global.create') }} {{ trans('cruds.payoutBulk.title_singular') }}
                </div>
                <div>
                    <label for="excelfile" class="btn btn-success m-1">
                        {{ trans('global.import') }}
                    </label>
                    <input type="file" style="display:none" id="excelfile" />
                    {{-- <button id='DLtoExcel-2' class="btn btn-default m-1">Export Sample Excel</button> --}}

                    <a href="{{ asset('sample/sample_payout.xlsx') }}" class="btn btn-default" download="">
                        {{ trans('global.export') }} {{ trans('global.sample') }} {{ trans('global.excel') }}
                    </a>
                    {{-- <button  class="btn btn-default m-1">Export Sample Excel</button> --}}
                </div>
            </div>
        </div>

        {{-- 接收 controller的资料 去给 js 使用 --}}
        <div id="data-passer" data-gate_arr="{{ $gate_arr }}"></div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group" id="errors">
                </div>
                <form method="POST" class="col-12" id="form" style="height: 500px;overflow: auto"
                    action="{{ route('admin.payouts.store_bulk') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="bulk_name">{{ trans('cruds.payout.fields.bulk_name') }}</label>
                        <input class="form-control" type="text" name="bulk_name" id="bulk_name" value="" required>
                    </div>

                    <input type="submit" id="form-submit" style="display: none;" />
                </form>

                <div class="d-flex col-12">
                    <input type="button" class="btn btn-primary mr-auto"
                        value="{{ trans('global.more') }} {{ trans('global.column') }}" id="more_column">
                    <input type="button" class="btn btn-success" id="submit" value="{{ trans('global.submit') }}">
                </div>
            </div>

        </div>
    </div>

    {{-- sample excel --}}
    <table id='tableData' class="table table-bordered table-striped" style="display: none">
        <tr>
            <th>project</th>
            <th>full_name</th>
            <th>account_no</th>
            <th>bank_code</th>
            <th>branch</th>
            <th>city</th>
            <th>state</th>
            <th>amount</th>
            <th>remark</th>
        </tr>
    </table>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var test_global = 0;

            var gate_arr = $('#data-passer').data('gate_arr');

            init();

            function init() {

                var default_init = 0;

                for (var i = 0; i <
                    default_init; i++) {
                    $('#form').append(row_form());
                }
            }

            $(document).on('click', '.del_form_row', function() {
                $(this).parent('.form_row').remove();
            });

            $('#more_column').on('click', function() {
                $('#form').append(row_form({
                    'gate': "1"
                }));
            });

            function row_form(vals = []) {
                var append = "";

                i = test_global;

                let client_transaction = vals['transaction'] || "";
                let gate = vals['project'] || "";
                let fullname = vals['fullname'] || "";
                let account_no = vals['account_no'] || "";
                let bank_code = vals['bank_code'] || "";
                let branch = vals['branch'] || "";
                let city = vals['city'] || "";
                let state = vals['state'] || "";
                let amount = vals['amount'] || "";
                let remark = vals['remark'] || "";

                append += ` <div class='d-flex mb-3 form_row'>`;

                append +=
                    `<input type='text' class='form-control flex-grow payouts.${i}.client_transaction' name='payouts[${i}][client_transaction]' value='${client_transaction}' placeholder='Transaction' required>`;

                append +=
                    ` <select name='payouts[${i}][gate]' class='form-control payouts.${i}.gate' style='width: 150px' required>`;

                append += `<option value="">Please Select</option>`;

                $.each(gate_arr, function(index, value) {
                    console.log('index :' + index);
                    console.log('gate :' + gate);
                    var selected = "";
                    // console.log(index);
                    // console.log(gate);
                    if (index == gate) {
                        console.log('selected');
                        selected = "selected";
                    }

                    append += `<option value="${index}" ${selected}>${value}</option>`;
                });

                append += "</select>";

                append +=
                    `<input type='text' class='form-control flex-grow payouts.${i}.gate' name='payouts[${i}][fullname]' value='${fullname}' placeholder='Full Name' required>`;

                append +=
                    `<input type='text' class='form-control flex-grow' name='payouts[${i}][account_no]' value='${account_no}' placeholder='Account No' required>`;

                append +=
                    `<input type='text' class='form-control' style='width: 100px' name='payouts[${i}][bank_code]' value='${bank_code}' placeholder='Bank Code' required>`;

                append +=
                    `<input type='text' class='form-control' name='payouts[${i}][branch]' value='${branch}' placeholder='Branch'>`;

                append +=
                    `<input type='text' class='form-control' name='payouts[${i}][city]' value='${city}' placeholder='City'>`;

                append +=
                    `<input type='text' class='form-control' name='payouts[${i}][state]' value='${state}' placeholder='State'>`;

                append +=
                    `<input type='number' class='form-control' name='payouts[${i}][amount]' value='${amount}' placeholder='Amount' min='0' required>`;

                append +=
                    `<input type='text' class='form-control flex-grow' name='payouts[${i}][remark]' value='${remark}' placeholder='Remark'>`;

                append +=
                    `<i class='fa fa-trash-o del_form_row' aria-hidden='true' style="cursor: pointer;font-size:1.3em;margin:10px;text-align:center;color:red"></i>`;

                append += "</div>";

                test_global++;

                return append;
            }

            var $btnDLtoExcel = $('#DLtoExcel-2');
            $btnDLtoExcel.on('click', function() {
                $("#tableData").excelexportjs({
                    containerid: "tableData",
                    datatype: 'table'
                });

            });

            $('#excelfile').on('change', function() {
                export_excel();
            });

            function export_excel() {
                var regex = /^([a-zA-Z0-9\s_\\.\-:()])+(.xlsx|.xls)$/;
                /*Checks whether the file is a valid excel file*/
                if (regex.test($("#excelfile").val().toLowerCase())) {
                    var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/
                    if ($("#excelfile").val().toLowerCase().indexOf(".xlsx") > 0) {
                        xlsxflag = true;
                    }
                    /*Checks whether the browser supports HTML5*/
                    if (typeof(FileReader) != "undefined") {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var data = e.target.result;
                            /*Converts the excel data in to object*/
                            if (xlsxflag) {
                                var workbook = XLSX.read(data, {
                                    type: 'binary'
                                });
                            } else {
                                var workbook = XLS.read(data, {
                                    type: 'binary'
                                });
                            }
                            /*Gets all the sheetnames of excel in to a variable*/
                            var sheet_name_list = workbook.SheetNames;

                            var cnt =
                                0; /*This is used for restricting the script to consider only first sheet of excel*/
                            sheet_name_list.forEach(function(y) {
                                /*Iterate through all sheets*/
                                /*Convert the cell value to Json*/
                                if (xlsxflag) {
                                    var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                                } else {
                                    var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[
                                        y]);
                                }
                                if (exceljson.length > 0 && cnt == 0) {
                                    // BindJqurery(exceljson, '#selectOption');

                                    import_to_form(exceljson);

                                    cnt++;
                                }
                            });
                            $('#exceltable').show();
                        }
                        if (xlsxflag) {
                            /*If excel file is .xlsx extension than creates a Array Buffer from excel*/
                            reader.readAsArrayBuffer($("#excelfile")[0].files[0]);
                        } else {
                            reader.readAsBinaryString($("#excelfile")[0].files[0]);
                        }
                    } else {
                        alert("Sorry! Your browser does not support HTML5!");
                    }
                } else {
                    alert("Please upload a valid Excel file!");
                }
            }

            function import_to_form(excel_json) {

                // //把 id form 清空
                // $('#form').empty();
                $('#excelfile').val('');

                $.each(excel_json, function(index, value) {
                    // console.log(value);
                    $('#form').append(row_form(value));

                });
            }

            $('#submit').on('click', function(e) {

                $("#form-submit").trigger('click');
                // $('#form').submit();
            });

            $('#form').on('submit', function(e) {

                e.preventDefault();

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // alert(data.errors['bulk_name'][0]);
                        if (data.status == 0) {
                            location.reload();
                        } else if (data.status == 422) {

                            var append =
                                `<div class="alert alert-danger alert-dismissible fade show">`

                            append +=
                                ` <button type="button" class="close" data-dismiss="alert">&times;</button>`;

                            $.each(data.errors, function(index, value) {

                                $.each(value, function(index2, value2) {
                                    append += `<p>${value2}</p>`;
                                });

                            });
                            append += `</div>`;

                            $("#errors").append(append);
                        } else {
                            alert(data.ret_msg);
                        }
                    }
                });
            })

        });

    </script>
@endsection
