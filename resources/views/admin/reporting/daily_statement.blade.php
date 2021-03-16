@extends('layouts.admin')
@section('content')
    {{-- @can('balance_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.balances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.balance.title_singular') }}
            </a>
                <form method="POST" action="{{ route('admin.balances.balance_settle') }}" id="balance_settle">
                    @method('PUT')
                    @csrf
                </form>
                <button class="btn btn-success" onclick="document.getElementById('balance_settle').submit()">
                    Manual Balance Settle
                </button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'Balance', 'route' => 'admin.balances.parseCsvImport'])
            </div>
        </div>
    @endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.search') }}
        </div>
        <div class="card-body">
            <form class="row" id="search">
                <div class="form-group col-12 col-lg-6 col-xl-4">
                    <label>{{ trans('cruds.dailyStatement.fields.date_range') }}</label>
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
                <div class=" form-group col-12 col-lg-6 col-xl-4">
                    <label>{{ trans('cruds.dailyStatement.fields.merchant') }}</label>
                    <input type="text" id="merchant" class="form-control" placeholder="{{ trans('cruds.dailyStatement.fields.merchant') }}">
                </div>
                <div class=" form-group col-12 col-lg-6 col-xl-4">
                    <label>{{ trans('cruds.dailyStatement.fields.gate') }}</label>
                    <input type="text" id="gate" class="form-control" placeholder="{{ trans('cruds.dailyStatement.fields.gate') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.dailyStatement.fields.currency') }}</label>
                    <select class="form-control" id="currency">
                        <option value="">{{ trans('cruds.dailyStatement.fields.all') }}</option>
                        @foreach ($currency_arr as $id => $short_code)
                            <option value="{{ $short_code }}">{{ $short_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.dailyStatement.fields.type') }}</label>
                    <select class="form-control" id="search_type">
                        <option value="">{{ trans('cruds.dailyStatement.fields.all') }}</option>
                        @foreach(App\Models\Balance::TYPE_SELECT as $key => $label)
                            @if ($key > 3)
                                @php
                                    break;
                                @endphp
                            @endif
                            <option value="{{ $label }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-xl-3 align-self-end">
                    {{-- <button type="button" class="btn btn-primary">
                        {{ trans('global.search') }}
                    </button>
                    <button type="button" id="reset" class="btn btn-danger">
                        {{ trans('global.reset') }}
                    </button> --}}
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.dailyStatement.title_singular') }} {{-- trans('global.list') --}}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Balance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.created_at') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.merchant') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.gate') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.type') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.amount') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.processing_fee') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.total_amount') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.dailyStatement.fields.balance_after') }}
                        </th>
                        <th>
                            {{ trans('cruds.balance.fields.currency') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.balance.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.debit') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.credit') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.status') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.transaction') }}
                        </th>
                        <th>
                            {{ trans('cruds.balance.fields.remark') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.settlement_status') }}
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
                            {{ trans('cruds.settlement.fields.bank_name') }} ({{ trans('cruds.settlement.title') }})
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.bank_account_name') }}
                            ({{ trans('cruds.settlement.title') }})
                        </th>
                        <th class="export">
                            {{ trans('cruds.settlement.fields.bank_account_number') }}
                            ({{ trans('cruds.settlement.title') }})
                        </th>
                        <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align:right">Total:</th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                        <th></th>
                        <th></th>
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
            // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            // @can('balance_delete')
                //   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                //   let deleteButton = {
                //     text: deleteButtonTrans,
                //     url: "{{ route('admin.balances.massDestroy') }}",
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
                serverside: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.reporting.daily_statement') }}",
                columns: [{
                        data: 'placeholder', // 0
                        name: 'placeholder',
                        visible: false,
                    },
                    {
                        data: 'date', // 1
                        name: 'date',
                    },
                    {
                        data: 'merchant_name', // 2
                        name: 'merchant.name'
                    },
                    {
                        data: 'gate_name', // 3
                        name: 'gate.name'
                    },
                    {
                        data: 'type', // 4
                        name: 'type'
                    },
                    {
                        data: 'amount', // 5
                        name: 'amount',
                        class: 'dt-body-right',
                        render: function(data, type, row) {
                            if (row['total_credit'] != 0) {
                                return "(" + row['currency'] + ") <b class='text-danger'>" + row['amount'] + "</b>";
                            }
                            return "(" + row['currency'] + ") <b class='text-success'>" + row['amount'] + "</b>";
                        }
                    },
                    {
                        data: 'total_fee', // 6
                        name: 'total_fee',
                        class: 'dt-body-right',
                        render: function(data, type, row) {
                            return "(" + row['currency'] + ") <b class='text-danger'>" + row['total_fee'] + "</b>" + row['processing'];
                        }
                    },
                    {
                        data: 'total_amount', // 7
                        name: 'total_amount',
                        class: 'dt-body-right',
                        render: function(data, type, row) {
                            if (row['total_credit'] != 0) {
                                return "(" + row['currency'] + ") <b class='text-danger'>" + row['total_amount'] + "</b>";
                            }
                            return "(" + row['currency'] + ") <b class='text-success'>" + row['total_amount'] + "</b>";
                        }
                    },
                    {
                        data: 'balance_after', // 8
                        name: 'balance_after',
                        class: 'dt-body-right',
                        render: function(data, type, row) {
                            return "("+row['currency']+") <b>" + row['balance_after'] + "</b>";
                        }
                    },
                    {
                        data: 'currency', // 9
                        name: 'currency',
                        visible: false,
                    },
                    // {
                    //     data: 'id',
                    //     name: 'id',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'debit',
                    //     name: 'debit'
                    // },
                    // {
                    //     data: 'credit',
                    //     name: 'credit'
                    // },
                    // {
                    //     data: 'status',
                    //     name: 'status',
                    //     render: function(data, type, row) {
                    //         console.log(parseInt(row['status']));
                    //         switch (parseInt(row['status'])) {
                    //             case 0:
                    //                 return '<span class="badge badge-success">' + row['status_name'] +
                    //                     '</span>';
                    //                 break;
                    //             case 1:
                    //                 return '<span class="badge badge-danger">' + row['status_name'] +
                    //                     '</span>';
                    //                 break;
                    //             case 2:
                    //                 return '<span class="badge badge-danger">' + row['status_name'] +
                    //                     '</span>';
                    //                 break;
                    //             default:
                    //                 return '<span class="badge badge-secondary">' + row['status_name'] +
                    //                     '</span>';
                    //                 break;
                    //         }
                    //     }
                    // },
                    // {
                    //     data: 'transaction',
                    //     name: 'document_no'
                    // },
                    // {
                    //     data: 'remark',
                    //     name: 'remark',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'settlement_status',
                    //     name: 'settlement_status',
                    //     render: function(data, type, row) {
                    //         switch (parseInt(row['settlement_status'])) {
                    //             case 0:
                    //                 return '<span class="badge badge-secondary">' + row[
                    //                         'settlement_status_name'] +
                    //                     '</span>';
                    //                 break;
                    //             case 1:
                    //                 return '<span class="badge badge-success">' + row[
                    //                         'settlement_status_name'] +
                    //                     '</span>';
                    //                 break;
                    //             default:
                    //                 return '<span class="badge badge-secondary">' + row[
                    //                         'settlement_status_name'] +
                    //                     '</span>';
                    //                 break;
                    //         }
                    //     }
                    // },
                    // {
                    //     data: 'saving_account.bank_name',
                    //     name: 'saving_account.bank_name',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'saving_account.bank_account_name',
                    //     name: 'saving_account.bank_account_name',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'saving_account.bank_account_number',
                    //     name: 'saving_account.bank_account_number',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'settlement_bank.bank_name',
                    //     name: 'settlement_bank.bank_name',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'settlement_bank.bank_account_name',
                    //     name: 'settlement_bank.bank_account_name',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'settlement_bank.bank_account_number',
                    //     name: 'settlement_bank.bank_account_number',
                    //     visible: false,
                    // },
                    // {
                    //     data: 'actions',
                    //     name: '{{ trans('global.actions') }}'
                    // }
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
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 5 ).footer() ).html(
                        /*'$'+*/formatter.format(amountTotal)/* +' ( $'+ total +' total)'*/
                    );

                    feeTotal = api
                        .column( 6, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 6 ).footer() ).html(
                        /*'$'+*/formatter.format(feeTotal)/* +' ( $'+ total +' total)'*/
                    );

                    tTotal = api
                        .column( 7, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column( 7 ).footer() ).html(
                        /*'$'+*/formatter.format(tTotal)/* +' ( $'+ total +' total)'*/
                    );
                }
            };
            let table = $('.datatable-Balance').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#search #min-date').val();
                    var max = $('#search #max-date').val();
                    var createdAt = moment(data[1]).format('YYYY-MM-DD') || 0; // Our date column in the table

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

            $('#search #merchant').on('keyup', function() {
                table
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#search #gate').on('keyup', function() {
                table
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#search #search_type').on('change', function() {
                if (this.value != undefined) {
                    table
                        .columns(4)
                        .search(this.value)
                        .draw();
                }
            });

            $('#search #currency').on('change', function() {
                if (this.value != undefined) {
                    table
                        .columns(8)
                        .search(this.value)
                        .draw();
                }
            });
        });
    </script>
@endsection
