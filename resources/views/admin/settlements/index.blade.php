@extends('layouts.admin')
@section('content')
    @can('settlement_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.settlements.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.settlement.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'Settlement', 'route' => 'admin.settlements.parseCsvImport'])
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.settlement.title_singular') }} {{ trans('global.search') }}
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
                <div class="form-group col-12 col-lg-6 col-xl-3">
                    <label>{{ trans('cruds.settlement.fields.status') }}</label>
                    <select class="form-control select2" id="search_status">
                        {{-- <option value="">{{ trans('cruds.settlement.fields.status') }}</option> --}}
                        @foreach(App\Models\Settlement::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group col-12 col-lg-6 col-xl-3">
                    <label>{{ trans('cruds.settlement.fields.saving_acc') }}</label>
                    <select class="form-control">
                        <option>{{ trans('cruds.settlement.fields.saving_acc') }}</option>
                    </select>
                </div> --}}
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
            {{ trans('cruds.settlement.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">

            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Settlement">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.transaction') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.merchant') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.gate') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.bank_name') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.bank_account_name') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.bank_account_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.currency') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.amount') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.processing_fee') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.status') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.remark') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.created_at') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.statement_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.payment_slip') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.currency') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.currency_id') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.amount') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="9" style="text-align:right">Total:</th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                        <th colspan="10"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


    <!-- set up the modal to start hidden and fade in and out -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">{{ trans('global.areYouSure') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- dialog body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div id="error_alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ trans('global.error') }}</strong>
                                <span id="error_alert_span"></span>
                            </div>
                        </div>
                        <div class="col-lg-6" id="settlement_data">
                            <table class="table table-bordered table-hover">
                                {{-- <tr>
                                    <td>{{ trans('cruds.settlement.fields.id') }}</td>
                                    <td id="id_display"></td>
                                </tr> --}}
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.transaction') }}</td>
                                    <td id="transaction"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.merchant') }}</td>
                                    <td id="merchant"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.project') }}</td>
                                    <td id="project"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.settlement_freeze_credit') }}</td>
                                    <td id="settlement_freeze_credit"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.bank_name') }}</td>
                                    <td id="bank_name"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.bank_account_name') }}</td>
                                    <td id="bank_account_name"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.bank_account_number') }}</td>
                                    <td id="bank_account_number"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.title_singular') }}
                                        {{ trans('cruds.settlement.fields.amount') }}</td>
                                    <td id="amount"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.topUp.fields.processing_fee') }}</td>
                                    <td id="processing_fee"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.settlement.fields.created_at') }}</td>
                                    <td id="created_at"></td>
                                </tr>
                                {{-- <tr>
                                    <td>{{ trans('cruds.settlement.fields.status') }}</td>
                                    <td id="status_display"></td>
                                </tr> --}}
                            </table>
                        </div>
                        <div class="col-lg-6" id="settlement_form_div">
                            <table class="table table-bordered table-hover">
                                <form action="{{ route('admin.settlements.settlement_approve') }}" method="POST"
                                    enctype="multipart/form-data" id="approve_form">
                                    @csrf
                                    <tr>
                                        <td>Bank Account</td>
                                        <td>
                                            <select name="saving_account_id" class="form-control" id="bank_list">
                                                <option value="">Please Select A Saving Account</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ trans('cruds.settlement.fields.bank_info') }}
                                        </td>
                                        <td>
                                            <div class="row form-group col-lg-12" id="bank_info"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.settlement.fields.payment_slip') }}</td>
                                        <td><input id="payment_slip" type="file" name="payment_slip"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.settlement.fields.remark') }}</td>
                                        <td><input id="remark" type="text" name="remark" class="form-control"></td>
                                    </tr>
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="status" id="status">
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button type="button" id="approve" name="status" class="btn btn-primary" value="1">{{ trans('global.approve') }}</button>
                    <button type="button" id="reject" name="status" class="btn btn-danger" value="3">{{ trans('global.reject') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('global.cancel') }}</button>
                </div>
            </div>
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
            // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            // @can('settlement_delete')
                //   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                //   let deleteButton = {
                //     text: deleteButtonTrans,
                //     url: "{{ route('admin.settlements.massDestroy') }}",
                //     className: 'btn-danger',
                //     action: function (e, dt, node, config) {
                //       var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                //           return entry.id
                //       });

                //       if (ids.length === 0) {
                //         alert('{{ trans('global.datatables.zero_selected') }}')

                //         return
                //       }

                //       if (confirm('{{ trans('global.areYouSure') }}')) {
                //         $.ajax({
                //           headers: {'x-csrf-token': _token},
                //           method: 'POST',
                //           url: config.url,
                //           data: { ids: ids, _method: 'DELETE' }})
                //           .done(function () { location.reload() })
                //       }
                //     }
                //   }
                //   dtButtons.push(deleteButton)
            // @endcan

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
                ajax: "{{ route('admin.settlements.index') }}",
                columns: [
                    {
                        data: 'placeholder', // 0
                        name: 'placeholder',
                        visible: false,
                    },
                    {
                        data: 'transaction', // 1
                        name: 'document_no'
                    },
                    {
                        data: 'id',  // 2
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'merchant_name', // 3
                        name: 'merchant.name'
                    },
                    {
                        data: 'gate.name', // 4
                        name: 'gate'
                    },
                    {
                        data: 'bank_name', // 5
                        name: 'bank_name'
                    },
                    {
                        data: 'bank_account_name', // 6
                        name: 'bank_account_name'
                    },
                    {
                        data: 'bank_account_number', // 7
                        name: 'bank_account_number'
                    },
                    {
                        data: 'currency.name', // 8
                        name: 'currency.name',
                        render: function(data, type, row) {
                            return row['c-name'] + "(" + row['c'] + ")";
                        }
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
                            return row['c'] + ' ' + row['processing_fee'] + row['processing']
                        }
                    },
                    {
                        data: 'status', // 11
                        name: 'status',
                        visible: false
                    },
                    {
                        data: 'status', // 12
                        name: 'status',
                        render: function(data, type, row) {
                            // console.log(row['status']);
                            switch (parseInt(row['status'])) {
                                case 0:
                                    return '<span class="badge badge-secondary">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 1:
                                    return '<span class="badge badge-success">' + row['status_name'] +
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
                        data: 'created_at', // 14
                        name: 'created_at',
                    },
                    {
                        data: 'statement_date', // 15
                        name: 'statement_date',
                    },
                    {
                        data: 'payment_slip', // 16
                        name: 'payment_slip',
                        sortable: false,
                        searchable: false,
                        visible: false,
                    },
                    {
                        data: 'currency.short_code', // 17
                        name: 'currency.short_code',
                        visible: false,
                    },
                    {
                        data: 'currency.id', // 18
                        name: 'currency.id',
                        visible: false,
                    },
                    {
                        data: 'amount', // 19
                        name: 'amount',
                        visible: false,
                    },
                    {
                        data: 'actions', // 20
                        name: '{{ trans('global.actions') }}',
                    }
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
            let table = $('.datatable-Settlement').DataTable(dtOverrideGlobals);
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
                    var createdAt = moment(data[13]).format('YYYY-MM-DD') ||
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
                        .columns(3)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(3)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(3)
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

            $('#search #currency').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(18)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(18)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(18)
                        .search('',true,false)
                        .draw();
                }
            });

            $('#search #search_amount').on('keyup', function() {
                if (this.value != undefined) {
                    table
                        .columns(19)
                        .search(this.value)
                        .draw();
                }
            });

            $('#search #search_status').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(11)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(11)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(11)
                        .search('',true,false)
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
            $('#search #search_status').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.settlement.fields.status') }}",
                allowClear: true
            });


            $("#reset").on('click', function(){
                $('#search #merchant').val('').trigger('change');
                $('#search #project').val('').trigger('change');
                $('#search #currency').val('').trigger('change');
                $('#search #search_status').val('').trigger('change');
            })

            $("#reset").click();

            $('#search_form_submit').on('click', function(){
                $('#search .date-range-filter').change();
                $('#search #merchant').change();
                $('#search #project').change();
                $('#search #currency').change();
                $('#search #search_amount').keyup();
                $('#search #search_status').change();
            })

        });

    </script>
    <!-- sometime later, probably inside your on load event callback -->
    <script>
        $('#approveModal').on('show.bs.modal', function(event) {
            var formatter = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
            });

            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('row'); // Extract info from data-* attributes
            // var bank = button.data('bank');
            var status = button.data('status');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            var currency = (data.currency_id != null) ? data.currency_id : 1;

            var color = 'green'

            if (parseFloat(data.amount) > parseFloat(data.gate.settlement_freeze_credit)) {
                $('#error_alert_span').html("{{trans('global.noEnoughMoney')}}" + data.gate.settlement_freeze_credit);
                $("#error_alert").addClass('show').removeClass('d-none');

                $('#approve').addClass('d-none');

                color = 'red';

                $('#settlement_data').removeClass('col-lg-6').addClass('col-lg-12');
                $('#settlement_form_div').addClass('d-none');
            } else {
                $("#error_alert").addClass('d-none').removeClass('show');

                $('#approve').removeClass('d-none');

                color = 'green'

                $('#settlement_data').removeClass('col-lg-12').addClass('col-lg-6');
                $('#settlement_form_div').removeClass('d-none');
            }

            //这里申请ajax 拿取pg 银行列表
            $.ajax({
                type: "GET",
                url: "/gate-saving-accounts/get_bank_list?gate_id=" + data.gate_id + "",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    bank_select_option = modal.find('.modal-body #bank_list');

                    bank_select_option.empty();

                    bank_select_option.append(new Option("Please Select A Saving Account", ''));

                    data.forEach(element => {
                        bank_select_option.append(new Option(element.saving_account
                            .bank_name,
                            element.saving_account.id));
                    });
                }
            });

            // set data
            // modal.find('.modal-body #id_display').text(data.id);
            modal.find('.modal-body #transaction').text(data.document_no);
            modal.find('.modal-body #merchant').text(data.merchant.name);
            modal.find('.modal-body #project').text(data.gate.name);
            modal.find('.modal-body #settlement_freeze_credit').html('<span style="color: ' + color + ';">' + data
                .currency.short_code + ' ' + data.gate.settlement_freeze_credit + '</span>');
            modal.find('.modal-body #bank_name').text(data.bank_name);
            modal.find('.modal-body #bank_account_name').text(data.bank_account_name);
            modal.find('.modal-body #bank_account_number').text(data.bank_account_number);
            modal.find('.modal-body #amount').html('<span style="color: ' + color + ';">' + data.currency
                .short_code + ' ' + data.amount + '</span>');
            modal.find('.modal-body #created_at').text(data.created_at);
            // modal.find('.modal-body #status_display').html(status);
            modal.find('.modal-body #id').val(data.id);
            modal.find('.modal-body #processing_fee').html(data.currency.short_code + ' ' + formatter.format(
                    data.processing_fee, 2) + "<br>" + "(" +
                formatter.format(data.processing_rate, 2) + "% + " + formatter.format(data.processing_fix,
                    2) + ")");
            modal.find('#bank_info').html('')
            modal.find('#remark').val('');
            modal.find('#payment_slip').val('');
        });

        $(document).on('change', '.modal-body #bank_list', function(e) {
            //之后需要去拿bank的资料
            bank_info = $('.modal-body #bank_info');
            bank_info.empty();

            if (e.target.value) {
                $.ajax({
                    type: "GET",
                    url: "/saving-accounts/get_bank_data?id=" + e.target.value + "",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data != null) {
                            var bank_name = data['bank_name'];
                            var bank_account_name = data['bank_account_name'];
                            var bank_account_number = data['bank_account_number'];

                            bank_info.append(
                                "<div>{{ trans('cruds.settlement.fields.bank_name') }} : " +
                                bank_name + "</div>");
                            bank_info.append(
                                "<div>{{ trans('cruds.settlement.fields.bank_account_name') }} : " +
                                bank_account_name + "</div>");
                            bank_info.append(
                                "<div>{{ trans('cruds.settlement.fields.bank_account_number') }} : " +
                                bank_account_number + "</div>");
                        }

                    }
                });
            }
        });

        // set action
        $("button[name=status]").on('click', function(e) {
            const _that = this;

            e.preventDefault();
            $('#status').val(_that.value);

            form = $('#approve_form');
            var formData = new FormData(form[0]);
            var type = form.attr('method');

            $("button[name=status]").prop('disabled', true);
            var value = $(_that).text();

            $(_that).html("{{ trans('cruds.loading') }}");

            $.ajax({
                type: type,
                url: form.attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $(_that).html(value);
                    $("button[name=status]").prop('disabled', false);

                    if (data.status == 0) {
                        location.reload();
                    } else {
                        $('#error_alert_span').html(data.ret_msg);
                        $("#error_alert").removeClass('d-none').addClass('show');
                    }
                }
            });
        });

    </script>
@endsection
