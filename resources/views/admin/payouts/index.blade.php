@extends('layouts.admin')
<style>
    .approval-modal-border {
        margin: 4px;
        padding: 8px;
        border: 1px solid lightgrey;
        max-height: 400px;
        overflow-y: auto;
    }

    .approval-modal-border label {
        font-weight: bold;
    }

    input[type=file] {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }

</style>
@section('content')
    @can('payout_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                @can('payout_create')
                    <a class="btn btn-success" href="{{ route('admin.payouts.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.payout.title_singular') }}
                    </a>

                    <a class="btn btn-success" href="{{ route('admin.payouts.create_bulk') }}">
                        {{ trans('global.add') }} {{ trans('cruds.payoutBulk.title_singular') }}
                    </a>
                @endcan

                {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'Payout', 'route' => 'admin.payouts.parseCsvImport']) --}}
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.payout.title_singular') }} {{ trans('global.search') }}
        </div>
        <div class="card-body">
            <div class="row" id="search">
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.merchant') }}</label>
                    <select class="form-control select2" id="merchant">
                        {{-- <option value="">{{ trans('cruds.payout.fields.merchant') }}</option> --}}
                        @foreach ($merchant_arr as $item)
                            <option value="{{$item->name}}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-4">
                    <label>{{ trans('cruds.payout.fields.date_range') }}</label>
                    <div class="input-group">
                        <input type="date" class="form-control date-range-filter" id="min-date">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </div>
                        <input type="date" class="form-control date-range-filter" id="max-date">
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.date_option') }}</label>
                    <select class="form-control" id="date-option">
                        <option value="">{{ trans('global.please_select') }}
                            {{ trans('cruds.payout.fields.date_option') }}</option>
                        <option value="1">{{ trans('global.today') }}</option>
                        <option value="2">{{ trans('global.7_day') }}</option>
                        <option value="3">{{ trans('global.1_month') }}</option>
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.transaction') }}</label>
                    <input type="text" class="form-control" id="transaction"
                        placeholder="{{ trans('cruds.payout.fields.transaction_id') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.project') }}</label>
                    <select class="form-control select2" id="project">
                        {{-- <option value="">{{ trans('cruds.payout.fields.merchant') }}</option> --}}
                        @foreach ($project_arr as $item)
                            <option value="{{$item->name}}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.bank_account_name') }}</label>
                     <select class="form-control select2" id="name">
                        {{-- <option value="">{{ trans('cruds.payout.fields.merchant') }}</option> --}}
                        @foreach ($bankHolder_arr as $item)
                            <option value="{{$item->bank_account_name}}">{{ $item->bank_account_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.account_no') }}</label>
                    <select class="form-control select2" id="account">
                        {{-- <option value="">{{ trans('cruds.payout.fields.merchant') }}</option> --}}
                        @foreach ($bankAcc_arr as $item)
                            <option value="{{$item->bank_account_number}}">{{ $item->bank_account_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.status') }}</label>
                    <select class="form-control" id="pstatus">
                        <option>{{ trans('cruds.payout.fields.status') }}</option>
                        @foreach (App\Models\Payout::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.bank_name') }}</label>
                    <select class="form-control select2" id="bank">
                        {{-- <option value="">{{ trans('cruds.payout.fields.merchant') }}</option> --}}
                        @foreach ($bankName_arr as $item)
                            <option value="{{$item->bank_name}}">{{ $item->bank_name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.payout_agent') }}</label>
                    <input type="text" class="form-control"
                        placeholder="{{ trans('cruds.payout.fields.payout_agent') }}">
                </div> --}}
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.currency') }}</label>
                    <select class="form-control select2" id="currency">
                        @foreach ($currency_arr as $item)
                            <option value="{{ $item->short_code }}">{{ $item->short_code }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.id') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.payout.fields.id') }}">
                </div> --}}
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.amount') }}</label>
                    <input type="number" class="form-control" id="amount"
                        placeholder="{{ trans('cruds.payout.fields.amount') }}">
                </div>
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.payout.fields.saving_acc') }}</label>
                    <select class="form-control">
                        <option>{{ trans('cruds.payout.fields.saving_acc') }}</option>
                    </select>
                </div> --}}
                <div class="form-group col-12 col-lg-6 col-xl-4 align-self-end">
                    <button type="button" id="search_form_submit" class="btn btn-primary">
                        {{ trans('global.search') }}
                    </button>
                    <button type="button" id="reset" class="btn btn-danger">
                        {{ trans('global.reset') }}
                    </button> 
                </div>

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
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.payout.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Payout">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.payout.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.transaction') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.client_transaction') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.merchant') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.gate') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.bulk') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.bank_name') }} (User)
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.bank_account_name') }} (User)
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.bank_account_number') }} (User)
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.bank_name') }} (PG)
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.bank_account_name') }} (PG)
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.bank_account_number') }} (PG)
                        </th>
                        <th>
                            {{ trans('cruds.payout.fields.currency') }}
                        </th>                       
                        <th class="export">
                            {{ trans('cruds.payout.fields.amount') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.processing_fee') }}
                        </th>
                        <th>
                            {{ trans('cruds.payout.fields.status') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.payout.fields.remark') }}
                        </th>
                        <th>
                            {{ trans('cruds.payout.fields.payment_slip') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.created_at') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.payout.fields.statement_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.payout.fields.amount') }}
                        </th>                     
                        <th>
                            &nbsp;
                        </th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        {{-- <th>0</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th> --}}
                        <th colspan="13" style="text-align:right">Total:</th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
                    <h5 class="modal-title" id="modalLabel">{{ trans('global.approval') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.payouts.payout_approve') }}" id="approve_form"
                    enctype="multipart/form-data" method="POST">
                    <!-- dialog body -->
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="error_alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ trans('global.error') }}</strong>
                                    <span id="error_alert_span"></span>
                                </div>
                            </div>
                            <div class="col-lg-6" id="payout_data">
                                <table class="table table-bordered table-hover">
                                    {{-- <tr>
                                        <td>{{ trans('cruds.payout.fields.id') }}</td>
                                        <td id="id_display"></td>
                                    </tr> --}}
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.transaction_id') }}</td>
                                        <td id="transaction"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.client_transaction') }}</td>
                                        <td id="client_transaction"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.merchant') }}</td>
                                        <td id="merchant"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.project') }}</td>
                                        <td id="project"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.current_amount') }}</td>
                                        <td id="current_amount"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.bank_name') }}</td>
                                        <td id="bank_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.bank_account_name') }}</td>
                                        <td id="bank_account_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.bank_account_number') }}</td>
                                        <td id="bank_account_number"></td>
                                    </tr>
                                    {{-- <tr>
                                        <td>{{ trans('cruds.payout.fields.currency') }}</td>
                                        <td id="currency"></td>
                                    </tr> --}}
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.amount') }}</td>
                                        <td id="amount_display"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.processing_fee') }}</td>
                                        <td id="processing_fee"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.status') }}</td>
                                        <td id="status_display"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.remark') }}</td>
                                        <td id="remark"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.payout.fields.created_at') }}</td>
                                        <td id="created_at"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-6" id="payout_form_div">
                                <table class="table table-bordered table-hover">
                                    {{-- <tr>
                                        <td>
                                            {{ trans('cruds.payout.fields.approve_type') }}
                                        </td>
                                        <td>
                                            <div class="row form-group col-lg-12">
                                                <select name="" class="form-control" required>
                                                    <option value="">Manual</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td>
                                            {{ trans('cruds.payout.fields.bank_account') }}
                                        </td>
                                        <td>
                                            <div class="row form-group col-lg-12">
                                                <select name="saving_account_id" class="form-control" id="bank_list"
                                                    required>
                                                    <option value="">Please Select A Saving Account</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ trans('cruds.payout.fields.bank_info') }}
                                        </td>
                                        <td id="bank_info">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ trans('cruds.payout.fields.payment_slip') }}
                                        </td>
                                        <td>
                                            <div class="row form-group col-lg-12">
                                                <input type="file" class="form-control-file" name="payment_slip"
                                                    id="payment_slip">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ trans('cruds.payout.fields.remark') }} (Admin)
                                        </td>
                                        <td>
                                            <div class="row form-group col-lg-12">
                                                <textarea class="form-control" rows="3" cols="10" name="admin_remark"
                                                    id="admin_remark"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" id="id" name="id" value="">
                                <input type="hidden" name="status" id="status" value="">
                            </div>
                        </div>
                    </div>
                    <!-- dialog buttons -->
                    <div class="modal-footer">
                        <button type="button" name="status" id="approve" class="btn btn-primary"
                            value="1">{{ trans('global.approve') }}</button>
                        <button type="button" name="status" id="reject" class="btn btn-danger"
                            value="3">{{ trans('global.reject') }}</button>
                        <button type="button" class="btn btn-default clr_white"
                            data-dismiss="modal">{{ trans('global.cancel') }}</button>
                    </div>
                </form>
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
            //  @can('payout_delete')
                //       let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                //         let deleteButton = {
                //          text: deleteButtonTrans,
                //          url: "{{ route('admin.payouts.massDestroy') }}",
                //          className: 'btn-danger',
                //          action: function (e, dt, node, config) {
                //            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                //                return entry.id
                //            });

                //            if (ids.length === 0) {
                //              alert('{{ trans('global.datatables.zero_selected') }}')

                //              return
                //            }

                //            if (confirm('{{ trans('global.areYouSure') }}')) {
                //              $.ajax({
                //                headers: {'x-csrf-token': _token},
                //                method: 'POST',
                //                url: config.url,
                //                data: { ids: ids, _method: 'DELETE' }})
                //                .done(function () { location.reload() })
                //            }
                //          }
                //        }
                //        dtButtons.push(deleteButton)
            //  @endcan

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
                ajax: "{{ route('admin.payouts.index') }}",
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
                        data: 'bulk_name', // 6
                        name: 'bulk.name'
                    },
                    {
                        data: 'bank_name', // 7
                        name: 'bank_name'
                    },
                    {
                        data: 'bank_account_name', // 8
                        name: 'bank_account_name',
                        // visible: false,
                    },
                    {
                        data: 'bank_account_number', // 9
                        name: 'bank_account_number',
                        // visible: false,
                    },
                    {
                        data: 'saving_account.bank_name', // 10
                        name: 'saving_account.bank_name'
                    },
                    {
                        data: 'saving_account.bank_account_name', // 11
                        name: 'saving_account.bank_account_name',
                        // visible: false,
                    },
                    {
                        data: 'saving_account.bank_account_number', // 12
                        name: 'saving_account.bank_account_number',
                        // visible: false,
                    },
                    {
                        data: 'gate.currency.short_code', // 13
                        name: 'gate.currency.short_code',
                        //visible: false,
                    },                 
                    {
                        data: 'amount', // 14
                        name: 'amount',
                        render: function(data, type, row) {
                            return row['currency'] + formatter.format(row['amount'], 2);
                        }
                    },
                    {
                        data: 'processing_fee', // 15
                        name: 'processing_fee',
                        render: function(data, type, row) {
                            return row['currency'] + row['processing_fee'] + row['processing'];
                        }
                    },
                    {
                        data: 'status', // 16
                        name: 'status',
                        visible: false
                    },
                    {
                        data: 'status', // 17
                        name: 'status',
                        render: function(data, type, row) {
                            //console.log(row['status']);
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
                        data: 'remark', // 18
                        name: 'remark',
                        visible: false,
                    },
                    {
                        data: 'payment_slip', // 19
                        name: 'payment_slip',
                        sortable: false,
                        searchable: false,
                        visible: false,
                    },
                    {
                        data: 'created_at', // 20
                        name: 'created_at',
                    },
                    {
                        data: 'statement_date', // 21
                        name: 'statement_date',
                    },
                    {
                        data: 'amount', // 22
                        name: 'amount',
                        visible: false
                    },

                    {
                        data: 'actions', // 23
                        name: '{{ trans('global.actions') }}'
                    },
                    
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
                footerCallback: function(row, data, start, end, display) {
                    var formatter = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                    });

                    var api = this.api(),
                        data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
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
                        .column(13, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    // Update footer
                    $(api.column(13).footer()).html(
                        /*'$'+*/
                        formatter.format(amountTotal) /* +' ( $'+ total +' total)'*/
                    );

                    feeTotal = api
                        .column(14, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    // Update footer
                    $(api.column(14).footer()).html(
                        /*'$'+*/
                        formatter.format(feeTotal) /* +' ( $'+ total +' total)'*/
                    );
                }
            };
            let table = $('.datatable-Payout').DataTable(dtOverrideGlobals);
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
            //  $('#search #min-date').val(moment().format("YYYY-MM-DD"));
            //  $('#search #max-date').val(moment().format("YYYY-MM-DD"));
            //  Extend dataTables search
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#search #min-date').val();
                    var max = $('#search #max-date').val();
                    var createdAt = moment(data[20]).format('YYYY-MM-DD') || 0; // Our date column in the table

                    //date option 优先 于 date range
                    if ($('#search #date-option').val() != "" && $('#search #date-option').val() != undefined) {

                        var date_option = $('#search #date-option').val(); // 1= 今天

                        if (date_option == 1) {
                            //今天
                            var target_date = moment().subtract(0, "days").format('YYYY-MM-DD');

                            if (moment(createdAt).isSameOrAfter(target_date)) {
                                return true;
                            }
                        } else if (date_option == 2) {
                            //7天
                            var target_date = moment().subtract(7, "days").format('YYYY-MM-DD');

                            if (moment(createdAt).isSameOrAfter(target_date)) {
                                return true;
                            }
                        }
                    } else {

                        if (
                            (min == "" || max == "") ||
                            (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
                        ) {
                            return true;
                        }

                    }

                    return false;
                }
            );

            $('#search .date-range-filter').change(function() {
                table.draw();
            });

            $('#search #date-option').change(function() {
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

            $('#search #transaction').on('keyup', function() {
                table
                    .columns(2)
                    .search(this.value)
                    .draw();
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

            $('#search #name').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(8)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(8)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(8)
                        .search('',true,false)
                        .draw();
                }
            });

            $('#search #account').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(9)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(9)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(9)
                        .search('',true,false)
                        .draw();
                }
            });

            $('#search #bank').on('change', function() {
                var val = new Array();
                //set val to current element in the dropdown.
                val = $(this).val();

                if (val.length > 1){

                valString = val.toString();
                valPiped =  valString.replace(/,/g,"|")

                    table
                        .columns(7)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(7)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(7)
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
                        .columns(13)
                        .search( valPiped ? '^'+valPiped+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else if (val.length == 1) {
                    table
                        .columns(13)
                        .search( val ? '^'+val+'$' : '', true, false ) //find this value in this column, if it matches, draw it into the table.
                        .draw();
                } else {
                    table
                        .columns(13)
                        .search('',true,false)
                        .draw();
                }
            });

            $('#search #amount').on('keyup', function() {
                table
                    .columns(22)
                    .search(this.value)
                    .draw();
            });

            $('#search #pstatus').on('change', function() {
                if (this.value != undefined) {
                    //console.log(this.value);
                    table
                        .columns(16)
                        .search(this.value)
                        .draw();
                }
            });

            $('#search #merchant').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.payout.fields.merchant') }}",
                allowClear: true
            });

            $('#search #project').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.payout.fields.project') }}",
                allowClear: true
            });

            $('#search #name').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.payout.fields.bank_account_name') }}",
                allowClear: true
            });

            $('#search #account').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.payout.fields.bank_account_number') }}",
                allowClear: true
            });

            $('#search #bank').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.payout.fields.bank_name') }}",
                allowClear: true
            });

            $('#search #currency').select2({
                multiple: true,
                placeholder: "{{ trans('cruds.payout.fields.currency') }}",
                allowClear: true
            });

            $("#reset").on('click', function(){
                $('#search #merchant').val('').trigger('change');
                $('#search #min-date').val('').trigger('change');
                $('#search #max-date').val('').trigger('change');
                $('#search #date-option').val('').trigger('change');
                $('#search #transaction').val('').trigger('change');
                $('#search #project').val('').trigger('change');
                $('#search #name').val('').trigger('change');
                $('#search #account').val('').trigger('change');
                $('#search #bank').val('').trigger('change');
                $('#search #amount').val('').trigger('change');
                $('#search #currency').val('').trigger('change');
                $('#search #pstatus').val('').trigger('change');
            })
                                   
            $("#reset").click();

            $('#search_form_submit').on('click', function(){
                $('#search #min-date').change();
                $('#search #max-date').change();
                $('#search #date-option').change();
                $('#search #merchant').change();
                $('#search #project').change();
                $('#search #transaction').change();
                $('#search #name').change();
                $('#search #account').change();
                $('#search #bank').change();
                $('#search #currency').change();
                $('#search #amount').keyup();
                $('#search #pstatus').change();
            })

        });

    </script>

    <!-- sometime later, probably inside your on load event callback -->
    <script>
        $(document).on('change', '.modal-body #bank_list', function(e) {
            //之后需要去拿bank的资料

            // console.log($(this).find("option:selected").attr('value') );

            var bank_id = $(this).find("option:selected").attr('value');
            var gate_id = $(this).find("option:selected").data('gate_id');

            $.ajax({
                type: "GET",
                url: "/saving-accounts/check_bank_balance?bank_id=" + bank_id + "&gate_id=" + gate_id,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {

                    bank_info = $('.modal-body #bank_info');

                    bank_info.empty();

                    if (data['saving_acc'] != null) {
                        var bank_account_name = data['saving_acc']['bank_account_name'];
                        var bank_account_number = data['saving_acc']['bank_account_number'];

                        var gate_balance = data['gate_balance'];
                        var gate_balance_limit = data['gate_balance_limit'];

                        var gate_saving_balance = data['gate_saving_balance'];
                        var gate_saving_balance_limit = data['gate_saving_balance_limit'];

                        var saving_acc_balance = data['saving_acc_balance'];
                        var saving_acc_balance_limit = data['saving_acc_balance_limit'];

                        bank_info.append('<div>Bank Acc Name : ' + bank_account_name + '</div>');
                        bank_info.append('<div>Bank Acc Number : ' + bank_account_number + '</div>');
                        bank_info.append('<div>Gate Balance(Amount) : ' + gate_balance + '</div>');
                        bank_info.append('<div>Gate Balance : ' + gate_balance_limit + '</div>');
                        bank_info.append('<div>Gate Saving Balance (Amount) : ' + gate_saving_balance +
                            '</div>');
                        bank_info.append('<div>Gate Saving Balance : ' + gate_saving_balance_limit +
                            '</div>');
                        bank_info.append('<div>Saving Acc Balance （Amount） : ' + saving_acc_balance +
                            '</div>');
                        bank_info.append('<div>Saving Acc Balance : ' + saving_acc_balance_limit +
                            '</div>');
                    }

                }
            });


        });
        $('#approveModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('row');
            var status = button.data('status');
            // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);

            var formatter = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
            });

            var color = 'green'

            if (parseFloat(data.amount) > parseFloat(data.gate.current_credit)) {
                $('#error_alert_span').html("{{ trans('global.noEnoughMoney') }}" + data.gate.current_credit);
                $("#error_alert").addClass('show').removeClass('d-none');

                $('#approve').addClass('d-none');

                color = 'red';

                $('#payout_data').removeClass('col-lg-6').addClass('col-lg-12');
                $('#payout_form_div').addClass('d-none');
            } else {
                $("#error_alert").addClass('d-none').removeClass('show');

                $('#approve').removeClass('d-none');

                color = 'green'

                $('#payout_data').removeClass('col-lg-12').addClass('col-lg-6');
                $('#payout_form_div').removeClass('d-none');
            }

            //这里申请ajax 拿取pg 银行列表

            $.ajax({
                type: "GET",
                url: "/gate-saving-accounts/get_bank_list?gate_id=" + data.gate_id + "",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data2) {

                    console.log(data2);

                    bank_select_option = modal.find('.modal-body #bank_list');

                    bank_select_option.empty();

                    bank_select_option.append(new Option("Please Select A Saving Account", ''));

                    // new Option(element.saving_account.bank_name,
                    //     element.saving_account.id)

                    data2.forEach(element => {
                        bank_select_option.append("<option value='" + element.saving_account
                            .id + "' data-gate_id='" + data.gate_id + "'>" + element
                            .saving_account.bank_name + "</option>");
                    });
                }
            });

            var status_html = '';

            switch (parseInt(data.status)) {
                case 0:
                    status_html += '<span class="badge badge-secondary">' + data.status_name +
                        '</span>';
                    break;
                case 1:
                    status_html += '<span class="badge badge-success">' + data.status_name +
                        '</span>';
                    break;
                case 2:
                    status_html += '<span class="badge badge-danger">' + data.status_name +
                        '</span>';
                    break;
                case 3:
                    status_html += '<span class="badge badge-danger">' + data.status_name +
                        '</span>';
                    break;
                default:
                    status_html += '<span class="badge badge-secondary">' + data.status_name +
                        '</span>';
                    break;
            }

            // modal.find('.modal-body #id_display').text(data.id);
            modal.find('.modal-body #transaction').text(data.document_no);
            modal.find('.modal-body #client_transaction').text(data.client_transaction);
            modal.find('.modal-body #merchant').text(data.merchant.name);
            modal.find('.modal-body #project').text(data.gate.name);
            modal.find('.modal-body #current_amount').html('<span style="color: ' + color + ';">' + data.gate
                .currency.short_code + ' ' + data.gate.current_credit + '</span>');
            modal.find('.modal-body #bank_name').text(data.bank_name);
            modal.find('.modal-body #bank_account_name').text(data.bank_account_name);
            modal.find('.modal-body #bank_account_number').text(data.bank_account_number);
            // modal.find('.modal-body #currency').text(data.gate.currency.name);
            modal.find('.modal-body #status_display').html(status_html);
            modal.find('.modal-body #created_at').text(data.created_at);
            modal.find('.modal-body #statement_at').text(data.statement_at);
            modal.find('.modal-body #remark').text(data.remark);
            modal.find('.modal-body #admin_remark').text(data.admin_remark);

            modal.find('.modal-body #amount_display').html('<span style="color: ' + color + ';">' + data.gate
                .currency.short_code + ' ' + data.amount + '</span>');
            modal.find('.modal-body #processing_fee').html(data.gate.currency.short_code + ' ' + formatter.format(
                    data.processing_fee, 2) + "<br>" + "(" +
                formatter.format(data.processing_rate, 2) + "% + " + formatter.format(data.processing_fix, 2) +
                ")")

            // modal.find('.modal-body #amount').val(data.amount);
            modal.find('.modal-body #id').val(data.id);

            if (data.status == '1' || data.status == '2') {
                modal.find('#approve').hide();
                modal.find('#reject').hide();
            } else {
                modal.find('#approve').show();
                modal.find('#reject').show();
            }

        });

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
