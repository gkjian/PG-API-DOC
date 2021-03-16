@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.deposit_daily_adjustment.title_singular') }} {{ trans('global.search') }}
        </div>
        <div class="card-body">
            <form class="row" id="search">
                <div class="form-group col-12 col-lg-6 col-xl-6">
                    <label>{{ trans('cruds.settlement.fields.date_range') }}</label>
                    <div class="input-group date-range-filter">
                        <input type="date" class="form-control" id="min-date">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </div>
                        <input type="date" class="form-control" id="max-date">
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-3">
                    <label>{{ trans('cruds.settlement.fields.merchant') }}</label>
                    <select class="form-control select2" id="merchant">
                        {{-- <option value="">{{ trans('cruds.settlement.fields.merchant') }}</option> --}}
                        @foreach ($merchant_arr as $item)
                            <option value="{{$item->name}}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-3">
                    <label>{{ trans('cruds.settlement.fields.project') }}</label>
                    <select class="form-control select2" id="project">
                        {{-- <option value="">{{ trans('cruds.settlement.fields.project') }}</option> --}}
                        @foreach ($project_arr as $item)
                            <option value="{{$item->name}}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-3">
                    <label>{{ trans('cruds.settlement.fields.currency') }}</label>
                    <select class="form-control select2" id="currency">
                        {{-- <option value="">{{ trans('cruds.settlement.fields.currency') }}</option> --}}
                        @foreach ($currency_arr as $item)
                            <option value="{{$item->id}}">{{$item->name}} ( {{ $item->short_code }} )</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-3">
                    <label>{{ trans('cruds.topUp.fields.amount') }}</label>
                    <input type="text" class="form-control" id="search_amount" placeholder="{{ trans('cruds.topUp.fields.amount') }}">
                </div>
                <div class="form-group col-12 col-xl-3 align-self-end">
                    <button type="button" id="search_form_submit" class="btn btn-primary">
                        {{ trans('global.search') }}
                    </button>
                    <button type="reset" id="reset" class="btn btn-danger">
                        {{ trans('global.reset') }}
                    </button>
                </div>
            </form>
            <div class="form-check col-12 text-right">
                <label class="checkbox-inline mr-2">
                    <input class="form-check-input" type="checkbox" value="" id="refresh" checked>
                    <label class="form-check-label" for="refresh">
                        {{ trans('global.auto_refresh') }}
                    </label>
                </label>
                <button type="button" id="refresh_button" class="btn btn-light">
                    {{ trans('global.refresh') }} (<span id="countdown_number">15</span>)
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.deposit_daily_adjustment.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-deposit_daily_adjustment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.deposit_daily_adjustment.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.transaction') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.client_transaction') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.merchant') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.gate') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.savingAccount.fields.bank_name') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.savingAccount.fields.bank_account_name') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.savingAccount.fields.bank_account_number') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.amount') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.processing_fee') }}
                        </th>
                        <th >
                            {{ trans('cruds.deposit_daily_adjustment.fields.status') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit_daily_adjustment.fields.remark') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit_daily_adjustment.fields.payment_slip') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit_daily_adjustment.fields.freeze') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit_daily_adjustment.fields.signature') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.created_at') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.deposit_daily_adjustment.fields.statement_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit_daily_adjustment.fields.approver') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.currency_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.amount') }}
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="8" style="text-align:right">Total:</th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                        <th colspan="11"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            var formatter = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
            });

            let dtOverrideGlobals = {
                buttons: [{
                        extend: 'excelHtml5',
                        className: "btn btn-success",
                        exportOptions: {
                            columns: [".export"]
                        }

                    },
                    {
                        extend: 'pdfHtml5',
                        className: "btn btn-default",
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [".export"]
                        }

                    },
                    {
                        extend: 'csvHtml5',
                        className: "btn btn-info",
                        exportOptions: {
                            columns: [".export"]
                        }

                    },
                ],
                processing: true,
                serverside: false,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.reporting.deposit_daily_adjustment') }}",
                columns: [{
                        data: 'placeholder', // 0
                        name: 'placeholder',
                        visible: false,
                    },
                    {
                        data: 'id', // 1
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'transaction', // 2
                        name: 'document_no'
                    },
                    {
                        data: 'client_transaction', // 3
                        name: 'client_transaction'
                    },
                    {
                        data: 'merchant_name', // 4
                        name: 'merchant.name'
                    },
                    {
                        data: 'gate_name', // 5
                        name: 'gate.name'
                    },
                    {
                        data: 'saving_account.bank_name', // 6
                        name: 'saving_account.bank_name'
                    },
                    {
                        data: 'saving_account.bank_account_name', // 7
                        name: 'saving_account.bank_account_name',
                        visible: false,
                    },
                    {
                        data: 'saving_account.bank_account_number', // 8
                        name: 'saving_account.bank_account_number',
                        visible: false,
                    },
                    {
                        data: 'amount', // 9
                        name: 'amount',
                        render: function(data, type, row) {
                            return row['c'] + ' ' + formatter.format(row['amount'], 2);
                        }
                    },
                    {
                        data: 'processing_fee', // 10
                        name: 'processing_fee',
                        render: function(data, type, row) {
                            return row['c'] + row['processing_fee'] + row['processing'];
                        }
                    },
                    {
                        data: 'status', // 11
                        name: 'status',
                        visible:false
                    },
                    {
                        data: 'status', // 12
                        name: 'status',
                        visible: false,
                        render: function(data, type, row) {

                            switch (parseInt(row['status'])) {
                                case 0:
                                    return '<span class="badge badge-secondary">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 1:
                                    return '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 2:
                                    return '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 3:
                                    return '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 4:
                                    return '<span class="badge badge-success">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 5:
                                    return '<span class="badge badge-warning">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 6:
                                    return '<span class="badge badge-warning">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 7:
                                    return '<span class="badge badge-primary">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 8:
                                    return '<span class="badge badge-info">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 9:
                                    return '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                default:
                                    return '<span class="badge badge-secondary">' + row['status_name'] +
                                        '</span>';
                                    break;
                            }
                        }

                    },
                    {
                        data: 'remark', // 13
                        name: 'remark',
                        visible: false,
                    },
                    {
                        data: 'payment_slip', // 14
                        name: 'payment_slip',
                        sortable: false,
                        searchable: false,
                        visible: false,
                    },
                    {
                        data: 'freeze', // 15
                        name: 'freeze',
                        visible: false,
                    },
                    {
                        data: 'signature', // 16
                        name: 'signature',
                        visible: false,
                    },
                    {
                        data: 'created_at', // 17
                        name: 'created_at',
                    },
                    {
                        data: 'statement_date', // 18
                        name: 'statement_date',
                    },
                    {
                        data: 'approve_by', // 19
                        name: 'approve_by',
                    },
                    {
                        data: 'gate.currency.id', // 20
                        name: 'gate.currency.id',
                        visible: false,
                    },
                    {
                        data: 'amount', // 20
                        name: 'amount',
                        visible: false,
                    },
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
                footerCallback: function ( row, data, start, end, display ) {
                    var formatter = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                    });

                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    // total = api
                    //     .column( 5 )
                    //     .data()
                    //     .reduce( function (a, b) {
                    //         console.log("a: "+a);
                    //         console.log("b: "+intVal(b));
                    //         return intVal(a) + intVal(b);
                    //     }, 0 );

                    // Total over this page
                    amountTotal = api
                        .column( 9, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 9 ).footer() ).html(
                        /*'$'+*/formatter.format(amountTotal)/* +' ( $'+ total +' total)'*/
                    );

                    feeTotal = api
                        .column( 10, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 10 ).footer() ).html(
                        /*'$'+*/formatter.format(feeTotal)/* +' ( $'+ total +' total)'*/
                    );
                }
            };
            let table = $('.datatable-deposit_daily_adjustment').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            $("#refresh_button").click(function() {
                table.ajax.reload(null, false);
            })

            var doUpdate = function() {
                if ($('#refresh').is(':checked')) {
                    var count = parseInt($('#countdown_number').html());
                    if (count !== 0) {
                        $('#countdown_number').html(count - 1);
                    } else {
                        $('#refresh_button').click();
                        $('#countdown_number').html(15);
                    }
                }
            };

            setInterval(doUpdate, 1000);

            // set min date / max date default value
            // $('#search #min-date').val(moment().format("YYYY-MM-DD"));
            // $('#search #max-date').val(moment().format("YYYY-MM-DD"));
            //  Extend dataTables search
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#search #min-date').val();
                    var max = $('#search #max-date').val();
                    var createdAt = moment(data[17]).format('YYYY-MM-DD') ||
                        0; // Our date column in the table

                    if (
                        (min == "" || max == "") ||
                        (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
                    ) {
                        return true;
                    }

                    return false;
                }
            );

            $('#search .date-range-filter').change(function() {
                table.draw();
            });

            $('#search #merchant').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(4)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(4)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(4)
                        .search('',true,false)
                        .draw();
                }
            });

            $('#search #project').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(5)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(5)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(5)
                        .search('',true,false)
                        .draw();
                }
            });

            $('#search #currency').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(20)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(20)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(20)
                        .search('',true,false)
                        .draw();
                }
            });

            $('#search #search_amount').on('keyup', function() {
                if (this.value != undefined) {
                    table
                        .columns(20)
                        .search(this.value)
                        .draw();
                }
            });

            $('#search #merchant').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.settlement.fields.merchant') }}",
                allowClear: true
            });
            $('#search #project').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.settlement.fields.project') }}",
                allowClear: true
            });
            $('#search #currency').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.settlement.fields.currency') }}",
                allowClear: true
            });


            $("#reset").on('click', function(){
                $('#search #merchant').val('').trigger('change');
                $('#search #project').val('').trigger('change');
                $('#search #currency').val('').trigger('change');
            })

            $("#reset").click();

            $('#search_form_submit').on('click', function(){
                $('#search .date-range-filter').change();
                $('#search #merchant').change();
                $('#search #project').change();
                $('#search #currency').change();
                $('#search #search_amount').keyup();
            })
        });

    </script>
@endsection
