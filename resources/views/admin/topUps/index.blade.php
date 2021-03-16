@extends('layouts.admin')
@section('content')
    {{-- @can('deposit_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.top-ups.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.topUp.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'TopUp', 'route' => 'admin.top-ups.parseCsvImport'])
            </div>
        </div>
    @endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.topUp.title_singular') }} {{ trans('global.search') }}
        </div>
        <div class="card-body">
            <div class="row" id="search">
                <div class="form-group col-12 col-lg-6 col-xl-4">
                    <label>{{ trans('cruds.topUp.fields.date_range') }}</label>
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
                    <label>{{ trans('cruds.topUp.fields.merchant') }}</label>
                    <input type="text" class="form-control" id="merchant"
                        placeholder="{{ trans('cruds.topUp.fields.merchant') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.transaction') }}</label>
                    <input type="text" class="form-control" id="transaction"
                        placeholder="{{ trans('cruds.topUp.fields.transaction') }}">
                </div>
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.merchant_order_id') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.topUp.fields.merchant_order_id') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.sender') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.topUp.fields.sender') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.account_no') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.topUp.fields.account_no') }}">
                </div> --}}
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.settlement.fields.status') }}</label>
                    <select class="form-control" id="search_status">
                        <option value="">{{ trans('cruds.settlement.fields.status') }}</option>
                        @foreach (App\Models\TopUp::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.status_verify') }}</label>
                    <select class="form-control" id="search_status_verify">
                        <option value="">{{ trans('cruds.topUp.fields.status_verify') }}</option>
                        @foreach (App\Models\TopUp::STATUS_VERIFY_SELECT as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.bank') }}</label>
                    <input type="text" class="form-control" id="bank"
                        placeholder="{{ trans('cruds.topUp.fields.bank') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.date_option') }}</label>
                    <select class="form-control" id="date-option">
                        <option value="">{{ trans('global.please_select') }}
                            {{ trans('cruds.payout.fields.date_option') }}</option>
                        <option value="1">{{ trans('global.today') }}</option>
                        <option value="2">{{ trans('global.7_day') }}</option>
                        <option value="3">{{ trans('global.1_month') }}</option>
                    </select>
                </div>

                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.bank_serial_no') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.topUp.fields.bank_serial_no') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.reference_code') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.topUp.fields.reference_code') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.verifier_role') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.topUp.fields.verifier_role') }}">
                </div> --}}
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.currency') }}</label>
                    <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}"
                        name="currency_id" id="currency_id">
                        <option value="">{{ trans('cruds.settlement.fields.currency') }}</option>
                        @foreach ($currency_arr as $item)
                            <option value="{{ $item->id }}">{{ $item->short_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.topUp.fields.amount') }}</label>
                    <input type="text" class="form-control" id="amount"
                        placeholder="{{ trans('cruds.topUp.fields.amount') }}">
                </div>
                <div class="form-group col-12 col-lg-6 align-self-end">
                    <button type="button" class="btn btn-primary">
                        {{ trans('global.search') }}
                    </button>
                    {{-- <button type="button" class="btn btn-danger">
                        {{ trans('global.reset') }}
                    </button> --}}
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
            {{ trans('cruds.topUp.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-TopUp">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.topUp.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.merchant') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.gate') }}
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
                            {{ trans('cruds.topUp.fields.amount') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.processing_fee') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.transaction') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.client_transaction') }}
                        </th>
                        <th>
                            {{ trans('cruds.topUp.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.topUp.fields.status_verify') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.topUp.fields.remark') }}
                        </th>
                        <th>
                            {{ trans('cruds.topUp.fields.payment_slip') }}
                        </th>
                        <th>
                            {{ trans('cruds.topUp.fields.freeze') }}
                        </th>
                        <th>
                            {{ trans('cruds.topUp.fields.signature') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.created_at') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.topUp.fields.statement_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.settlement.fields.currency_id') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="7" style="text-align:right">Total:</th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                        <th colspan="13"></th>
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
                <form action="{{ route('admin.top-ups.topUp_approve') }}" id="approve_form" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="error_alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ trans('global.error') }}</strong>
                                    <span id="error_alert_span"></span>
                                </div>
                            </div>
                            <div class="col-lg-6" id="deposit_data">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.id') }}</td>
                                        <td id="id_display"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.transaction') }}</td>
                                        <td id="transaction"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.client_transaction') }}</td>
                                        <td id="client_transaction"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.savingAccount.fields.bank_account_name') }}</td>
                                        <td id="bank_account_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.savingAccount.fields.bank_account_number') }}</td>
                                        <td id="bank_account_number"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.savingAccount.fields.bank_name') }}</td>
                                        <td id="bank_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.user_name') }}</td>
                                        <td id="user_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.amount') }}</td>
                                        <td id="amount"></td>
                                    </tr>
                                    @can('deposit_adjustment')
                                        <tr>
                                            <td>
                                                {{ trans('cruds.amount_adjustment') }}
                                            </td>
                                            <td>
                                                <div id="display_amount_adjustment">

                                                </div>
                                                <div id="input_amount_adjustment">
                                                    <input class="form-control" id="amount_adjustment" name="amount_adjustment"
                                                        type="number" placeholder="{{ trans('cruds.amount_adjustment') }}">
                                                </div>
                                            </td>
                                        </tr>
                                    @endcan
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.processing_fee') }}</td>
                                        <td id="processing_fee"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.created_at') }}</td>
                                        <td id="created_at"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.status') }}</td>
                                        <td id="status_display"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('cruds.topUp.fields.remark') }}</td>
                                        <td id="remark"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-6" id="deposit_image">
                                <div class="form-group">
                                    <a id="img_link" target="_blank">
                                        <img class="img-fluid" id="img">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="amount">{{ trans('cruds.topUp.fields.remark') }} (Admin)</label>
                                    <textarea class="form-control" name="admin_remark" id="admin_remark" id=""
                                        rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dialog buttons -->
                    <div class="modal-footer">
                        @csrf
                        @auth('admin')
                            <div id="modal-choose">
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="status" id="status">
                                <input type="hidden" name="status_verify" id="status_verify">
                                <input type="hidden" name="approval_type">

                                <button type="button" data-approval_type="status_verify" id="button_reconfirm"
                                    class="btn btn-info approval" value="3">{{ trans('cruds.Reconfirm') }}</button>
                                <button type="button" data-approval_type="status_verify" id="button_verify"
                                    class="btn btn-warning approval" value="1">{{ trans('cruds.Verify') }}</button>
                                <button type="button" data-approval_type="status_verify" id="button_kiv"
                                    class="btn btn-success approval" value="2">{{ trans('cruds.KIV') }}</button>
                                <button type="button" data-approval_type="status" id="button_approve"
                                    class="btn btn-primary approval" value="7">{{ trans('cruds.Approve') }}</button>
                                <button type="button" data-approval_type="status" id="button_reject"
                                    class="btn btn-danger approval" value="2">{{ trans('cruds.Reject') }}</button>
                            @endauth
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            // @can('deposit_delete')
                //   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                //   let deleteButton = {
                //     text: deleteButtonTrans,
                //     url: "{{ route('admin.top-ups.massDestroy') }}",
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
                ajax: "{{ route('admin.top-ups.index') }}",
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
                        data: 'merchant_name', // 2
                        name: 'merchant.name'
                    },
                    {
                        data: 'gate_name', // 3
                        name: 'gate.name'
                    },
                    {
                        data: 'saving_account.bank_name', // 4
                        name: 'saving_account.bank_name'
                    },
                    {
                        data: 'saving_account.bank_account_name', // 5
                        name: 'saving_account.bank_account_name',
                        visible: false,
                    },
                    {
                        data: 'saving_account.bank_account_number', // 6
                        name: 'saving_account.bank_account_number',
                        visible: false,
                    },
                    {
                        data: 'amount', // 7
                        name: 'amount',
                        render: function(data, type, row) {
                            return row['c'] + row['amount'];
                        }
                    },
                    {
                        data: 'processing_fee', // 8
                        name: 'processing_fee',
                        render: function(data, type, row) {
                            return row['c'] + row['processing_fee'] + row['processing'];
                        }
                    },
                    {
                        data: 'transaction', // 9
                        name: 'document_no'
                    },
                    {
                        data: 'client_transaction', // 10
                        name: 'client_transaction'
                    },
                    {
                        data: 'status', // 11
                        name: 'status',
                        visible: false
                    },
                    {
                        data: 'status_verify', // 12
                        name: 'status_verify',
                        visible: false,
                    },
                    {
                        data: 'status_show', // 13
                        name: 'status_show',
                        render: function(data, type, row) {

                            var html = '';

                            switch (parseInt(row['status'])) {
                                case 0:
                                    html += '<span class="badge badge-secondary">' + row[
                                            'status_name'] +
                                        '</span>';
                                    break;
                                case 1:
                                    html += '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 2:
                                    html += '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 3:
                                    html += '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 4:
                                    html += '<span class="badge badge-success">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 5:
                                    html += '<span class="badge badge-warning">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 6:
                                    html += '<span class="badge badge-warning">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 7:
                                    html += '<span class="badge badge-primary">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 8:
                                    html += '<span class="badge badge-info">' + row['status_name'] +
                                        '</span>';
                                    break;
                                case 9:
                                    html += '<span class="badge badge-danger">' + row['status_name'] +
                                        '</span>';
                                    break;
                                default:
                                    html += '<span class="badge badge-secondary">' + row[
                                            'status_name'] +
                                        '</span>';
                                    break;
                            }

                            switch (parseInt(row['status_verify'])) {
                                case 0:
                                    html += '<span class="badge badge-danger">' + row[
                                            'status_verify_name'] +
                                        '</span>';
                                    break;
                                case 1:
                                    html += '<span class="badge badge-success">' + row[
                                            'status_verify_name'] +
                                        '</span>';
                                    break;
                                case 2:
                                    html += '<span class="badge badge-primary">' + row[
                                            'status_verify_name'] +
                                        '</span>';
                                    break;
                                default:
                                    html += '<span class="badge badge-secondary">' + row[
                                            'status_verify_name'] +
                                        '</span>';
                                    break;
                            }

                            return html;
                        }
                    },
                    {
                        data: 'remark', // 14
                        name: 'remark',
                        visible: false,
                    },
                    {
                        data: 'payment_slip', // 15
                        name: 'payment_slip',
                        sortable: false,
                        searchable: false,
                        visible: false,
                    },
                    {
                        data: 'freeze', // 16
                        name: 'freeze',
                        visible: false,
                    },
                    {
                        data: 'signature', // 17
                        name: 'signature',
                        visible: false,
                    },
                    {
                        data: 'created_at', // 18
                        name: 'created_at',
                    },
                    {
                        data: 'statement_date', // 19
                        name: 'statement_date',
                    },
                    {
                        data: 'gate.currency.id', // 20
                        name: 'gate.currency.id',
                        visible: false,
                    },
                    {
                        data: 'actions', // 21
                        name: '{{ trans('global.actions') }}'
                    }
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
                        .column(7, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    // Update footer
                    $(api.column(7).footer()).html(
                        /*'$'+*/
                        formatter.format(amountTotal) /* +' ( $'+ total +' total)'*/
                    );

                    feeTotal = api
                        .column(8, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    // Update footer
                    $(api.column(8).footer()).html(
                        /*'$'+*/
                        formatter.format(feeTotal) /* +' ( $'+ total +' total)'*/
                    );
                }
            };
            let table = $('.datatable-TopUp').DataTable(dtOverrideGlobals);
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

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = $('#search #min-date').val();
                    var max = $('#search #max-date').val();
                    var createdAt = moment(data[16]).format('YYYY-MM-DD') || 0; // Our date column in the table

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

            $('#search #merchant').on('keyup', function() {
                //console.log(this.value)
                table
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#search #transaction').on('keyup', function() {
                //console.log(this.value)
                table
                    .columns(9)
                    .search(this.value)
                    .draw();
            });

            $('#search #amount').on('keyup', function() {
                //console.log(this.value)
                table
                    .columns(7)
                    .search(this.value)
                    .draw();
            });

            $('#search #bank').on('keyup', function() {
                //console.log(this.value)
                table
                    .columns(4)
                    .search(this.value)
                    .draw();
            });

            $('#search #search_status').on('change', function() {
                if (this.value != undefined) {
                    //console.log(this.value)
                    table
                        .columns(11)
                        .search(this.value)
                        .draw();
                }
            });

            $('#search #search_status_verify').on('change', function() {
                if (this.value != undefined) {
                    //console.log(this.value)
                    table
                        .columns(12)
                        .search(this.value)
                        .draw();
                }
            });

            $('#search #currency_id').on('change', function() {
                if (this.value != undefined) {
                    table
                        .columns(20)
                        .search(this.value)
                        .draw();
                }
            });


        });

    </script>
    <!-- sometime later, probably inside your on load event callback -->
    <script>
        @auth('merchant')
            $('.modal-body #admin_remark').prop('readonly', true);
        @endauth

        @auth('partner')
            $('.modal-body #admin_remark').prop('readonly', true);
        @endauth

        $('#approveModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('row'); // Extract info from data-* attributes
            // var bank = button.data('bank');
            var img = button.data('img');

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);

            var status_html = '';

            switch (parseInt(data.status)) {
                case 0:
                    status_html += '<span class="badge badge-secondary">' + data.status_name +
                        '</span>';
                    break;
                case 1:
                    status_html += '<span class="badge badge-danger">' + data.status_name +
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
                case 4:
                    status_html += '<span class="badge badge-success">' + data.status_name +
                        '</span>';
                    break;
                case 5:
                    status_html += '<span class="badge badge-warning">' + data.status_name +
                        '</span>';
                    break;
                case 6:
                    status_html += '<span class="badge badge-warning">' + data.status_name +
                        '</span>';
                    break;
                case 7:
                    status_html += '<span class="badge badge-primary">' + data.status_name +
                        '</span>';
                    break;
                case 8:
                    status_html += '<span class="badge badge-info">' + data.status_name +
                        '</span>';
                    break;
                case 9:
                    status_html += '<span class="badge badge-danger">' + data.status_name +
                        '</span>';
                    break;
                default:
                    status_html += '<span class="badge badge-secondary">' + row[
                            'status_name'] +
                        '</span>';
                    break;
            }

            status_html += '   ';

            switch (parseInt(data.status_verify)) {
                case 0:
                    status_html += '<span class="badge badge-danger">' + data.status_verify_name +
                        '</span>';
                    break;
                case 1:
                    status_html += '<span class="badge badge-success">' + data.status_verify_name +
                        '</span>';
                    break;
                case 2:
                    status_html += '<span class="badge badge-primary">' + data.status_verify_name +
                        '</span>';
                    break;
                default:
                    status_html += '<span class="badge badge-secondary">' + data.status_verify_name +
                        '</span>';
                    break;
            }

            modal.find('.modal-body #img_link').attr('href', img);
            modal.find('.modal-body #img').attr('src', img);

            // set data
            modal.find('.modal-body #id_display').text(data.id);
            modal.find('.modal-body #transaction').text(data.document_no);
            modal.find('.modal-body #client_transaction').text(data.client_transaction);
            // modal.find('.modal-body #bank_account_name').text(bank.saving_account.bank_account_name);
            // modal.find('.modal-body #bank_account_number').text(bank.saving_account.bank_account_number);
            // modal.find('.modal-body #bank_name').text(bank.saving_account.bank_name);
            modal.find('.modal-body #bank_account_name').text(data.saving_account.bank_account_name);
            modal.find('.modal-body #bank_account_number').text(data.saving_account.bank_account_number);
            modal.find('.modal-body #bank_name').text(data.saving_account.bank_name);
            modal.find('.modal-body #amount').text(data.amount);
            modal.find('.modal-body #created_at').text(data.created_at);
            modal.find('.modal-body #status_display').html(status_html);
            modal.find('.modal-footer #id').val(data.id);
            modal.find('.modal-body #admin_remark').text(data.admin_remark);
            modal.find('.modal-body #user_name').text(data.user_name);
            modal.find('.modal-body #processing_fee').html(data.processing_fee + "<br>" + "(" + data
                .processing_rate + "% + " + data.processing_fix + ")");
            modal.find('.modal-body #remark').text(data.remark);

            // if (img == null || img == '') {
            //     $('#error_alert_span').html("{{ trans('global.deposit_havent_put_image_error') }}");
            //     $("#error_alert").addClass('show').removeClass('d-none');

            //     $('#modal_button').removeClass('d-inline').addClass('d-none');

            //     $('#deposit_data').removeClass('col-lg-6').addClass('col-lg-12');
            //     $('#deposit_image').addClass('d-none');
            // } else {
            //     $("#error_alert").addClass('d-none').removeClass('show');

            //     $('#modal_button').removeClass('d-none').addClass('d-inline');

            //     $('#deposit_data').removeClass('col-lg-12').addClass('col-lg-6');
            //     $('#deposit_image').removeClass('d-none');
            // }

            if (data.status == '7' || data.status == '2') {
                modal.find('#modal-choose #button_reject').hide();
                modal.find('#modal-choose #button_reconfirm').hide();
                modal.find('#modal-choose #button_verify').hide();
                modal.find('#modal-choose #button_kiv').hide();
                modal.find('#modal-choose #button_approve').hide();
                modal.find('.modal-body #admin_remark').prop('readonly', true);

                @can('deposit_adjustment')
                    modal.find('.modal-body #display_amount_adjustment').text(data.amount_adjustment);
                    modal.find('.modal-body #input_amount_adjustment').addClass('d-none');
                @endcan
            } else if (data.status == '9') {
                modal.find('#modal-choose #button_reject').hide();
                modal.find('#modal-choose #button_reconfirm').hide();
                modal.find('#modal-choose #button_verify').hide();
                modal.find('#modal-choose #button_kiv').hide();
                modal.find('#modal-choose #button_approve').hide();
                
                modal.find('.modal-body #admin_remark').prop('readonly', true);
            } else {
                if (data.status_verify == 0) {
                    //unverified
                    modal.find('#modal-choose #button_reject').show();
                    modal.find('#modal-choose #button_reconfirm').show();
                    modal.find('#modal-choose #button_verify').show();
                    modal.find('#modal-choose #button_kiv').show();
                    modal.find('#modal-choose #button_approve').hide();
                } else if (data.status_verify == 1) {
                    //verify
                    modal.find('#modal-choose #button_reject').hide();
                    modal.find('#modal-choose #button_reconfirm').hide();
                    modal.find('#modal-choose #button_verify').hide();
                    modal.find('#modal-choose #button_kiv').hide();
                    modal.find('#modal-choose #button_approve').show();
                } else if (data.status_verify == 2) {
                    //KIV
                    modal.find('#modal-choose #button_reject').show();
                    modal.find('#modal-choose #button_reconfirm').hide();
                    modal.find('#modal-choose #button_verify').show();
                    modal.find('#modal-choose #button_kiv').hide();
                    modal.find('#modal-choose #button_approve').show();

                } else if (data.status_verify == 3) {
                    //reconfirmed
                    modal.find('#modal-choose #button_reject').show();
                    modal.find('#modal-choose #button_reconfirm').hide();
                    modal.find('#modal-choose #button_verify').show();
                    modal.find('#modal-choose #button_kiv').show();
                    modal.find('#modal-choose #button_approve').hide();
                }
                modal.find('.modal-body #admin_remark').prop('readonly', false);

                if (img == null || img == '') {
                    @can('deposit_adjustment')
                        modal.find('.modal-body #display_amount_adjustment').text(data.amount_adjustment);
                        modal.find('.modal-body #input_amount_adjustment').addClass('d-none');
                    @endcan
                } else {
                    @can('deposit_adjustment')
                        modal.find('.modal-body #display_amount_adjustment').text('');
                        modal.find('.modal-body #input_amount_adjustment').removeClass('d-none');
                    @endcan
                }
            }

        });
        // set action
        $(".approval").on('click', function(e) {
            const _that = $(this);

            e.preventDefault();

            $('#status').val('');
            $('#status_verify').val('');

            if (_that.data('approval_type') == 'status') {
                $('#status').val(_that.val());
            } else if (_that.data('approval_type') == 'status_verify') {
                $('#status_verify').val(_that.val());
            }

            form = $('#approve_form');
            var formData = new FormData(form[0]);
            var type = form.attr('method');

            $(".approval").prop('disabled', true);
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
                    if (data.status == 0) {
                        location.reload();
                    } else {
                        $(".approval").prop('disabled', false);
                        $(_that).html(value);
                        alert(data.ret_msg);
                    }
                }
            });
        });

    </script>
@endsection
