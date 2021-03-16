@extends('layouts.admin')
@section('content')
    @can('top_up_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.deposits.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.deposit.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'Deposit', 'route' => 'admin.deposits.parseCsvImport'])
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.deposit.title_singular') }} {{ trans('global.search') }}
        </div>
        <div class="card-body">
            <div class="row" id="search">
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.merchant') }}</label>
                    <input type="text" class="form-control" id="dmerchant" placeholder="{{ trans('cruds.deposit.fields.merchant') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.transaction') }}</label>
                    <input type="text" class="form-control" id="dtransaction" placeholder="{{ trans('cruds.deposit.fields.transaction') }}">
                </div>
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.merchant_order_id') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.deposit.fields.merchant_order_id') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.sender') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.deposit.fields.sender') }}">
                </div> --}}
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.account_no') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.deposit.fields.account_no') }}">
                </div> --}}
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.status') }}</label>
                    <select class="form-control" id="dstatus">
                        <option>{{ trans('cruds.payout.fields.status') }}</option>
                        @foreach (App\Models\Deposit::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach

                    </select>
                </div>
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.bank') }}</label>
                    <input type="text" class="form-control" id="bank" placeholder="{{ trans('cruds.deposit.fields.bank') }}">
                </div> --}}               
                <div class="form-group col-12 col-lg-6 col-xl-4">
                    <label>{{ trans('cruds.deposit.fields.date_range') }}</label>
                    <div class="input-group">
                        <input type="date" class="form-control date-range-filter" id="min-date" >
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </div>
                        <input type="date" class="form-control date-range-filter" id="max-date">
                    </div>
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.date_option') }}</label>
                    <select class="form-control" id="date-option">
                        <option value="">{{ trans('global.please_select') }}
                            {{ trans('cruds.payout.fields.date_option') }}</option>
                        <option value="1">{{ trans('global.today') }}</option>
                        <option value="2">{{ trans('global.7_day') }}</option>
                        <option value="3">{{ trans('global.1_month') }}</option>
                    </select>
                </div>                
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.bank_serial_no') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.deposit.fields.bank_serial_no') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.reference_code') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.deposit.fields.reference_code') }}">
                </div>
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.verifier_role') }}</label>
                    <input type="text" class="form-control" placeholder="{{ trans('cruds.deposit.fields.verifier_role') }}">
                </div> --}}
                {{-- <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.currency') }}</label>
                    <select class="form-control">
                        <option>{{ trans('cruds.deposit.fields.currency') }}</option>
                    </select>
                </div> --}}
                <div class="form-group col-12 col-lg-6 col-xl-2">
                    <label>{{ trans('cruds.deposit.fields.amount') }}</label>
                    <input type="text" class="form-control" id="amount" placeholder="{{ trans('cruds.deposit.fields.amount') }}">
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
            {{ trans('cruds.deposit.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">

            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Deposit">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.transaction') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.merchant') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.project') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.processing_fee') }}
                        </th>
                        {{-- <th>
                        {{ trans('cruds.deposit.fields.description') }}
                    </th> --}}
                        <th>
                            {{ trans('cruds.deposit.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.remark') }}
                        </th>
                        <th>
                            {{ trans('cruds.deposit.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
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
                        <div class="col-lg-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.document_no') }}</td>
                                    <td id="transaction"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.merchant') }}</td>
                                    <td id="merchant"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.amount') }}</td>
                                    <td id="amount"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.processing_fee') }}</td>
                                    <td id="processing_fee"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.status') }}</td>
                                    <td id="status_display"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.description') }}</td>
                                    <td id="description"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.remark') }}</td>
                                    <td id="remark"></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('cruds.deposit.fields.created_at') }}</td>
                                    <td id="created_at"></td>
                                </tr>
                                
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <a id="img_link" target="_blank">
                                <img class="img-fluid" id="img">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer">
                    <form action="{{ route('admin.deposits.deposit_approve') }}" id="approve_form" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="status" id="status">
                        <button type="button" name="status" id="approve" class="btn btn-primary" value="1">Approve</button>
                        <button type="button" name="status" id="reject" class="btn btn-danger" value="3">Reject</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            // @can('top_up_delete')
                //   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                //   let deleteButton = {
                //     text: deleteButtonTrans,
                //     url: "{{ route('admin.deposits.massDestroy') }}",
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
                ajax: "{{ route('admin.deposits.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder',
                        visible: false,
                    },
                    {
                        data: 'id',
                        name: 'id',
                        visible: false,
                    },
                    {
                        data: 'document_no',
                        name: 'document_no'
                    },
                    {
                        data: 'merchant_name',
                        name: 'merchant.name'
                    },
                    {
                        data: 'project_name',
                        name: 'gate.name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'processing_fee',
                        name: 'processing_fee'
                    },
                    // { data: 'description', name: 'description' },
                    {
                        data: 'status',
                        name: 'status',
                        visible: false,                    
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            
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
                                case 4:
                                    return '<span class="badge badge-secondary">' + row['status_name'] +
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
                        data: 'remark',
                        name: 'remark'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            };
            let table = $('.datatable-Deposit').DataTable(dtOverrideGlobals);
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
                    var createdAt = moment(data[10]).format('YYYY-MM-DD') || 0; // Our date column in the table

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

            $('#search #dmerchant').on('keyup', function() {
                table
                    .columns(3)                    
                    .search(this.value)
                    .draw();                   
            });

            $('#search #dtransaction').on('keyup', function() {
                table
                    .columns(2)
                    .search(this.value)
                    .draw();
                    console.log(this.value)
            });

            $('#search #dstatus').on('change', function() {
                if (this.value != undefined) {        
                    //console.log(this.value)            
                    table
                        .columns(7)
                        .search(this.value)
                        .draw();
                }
            });

            $('#search #amount').on('keyup', function() {
                table
                    .columns(5)
                    .search(this.value)
                    .draw();                   
            });

        });

    </script>
    <!-- sometime later, probably inside your on load event callback -->
    <script>
        $(document).ready(function() {
            $('#approveModal').on('show.bs.modal', function(event) {
                var formatter = new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                });
                var button = $(event.relatedTarget); // Button that triggered the modal
                var data = button.data('row'); // Extract info from data-* attributes
                // var bank = button.data('bank');
                var status = button.data('status');
                var img = button.data('img');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                if (img == '') {
                    modal.find('.modal-dialog').removeClass('modal-lg');
                    modal.find('.modal-body .row').removeClass('row');
                    modal.find('.modal-body .col-lg-6').removeClass('col-lg-6');
                    modal.find('.modal-body #img').remove();
                }
                // set image
                modal.find('.modal-body #img_link').attr('href', img);
                modal.find('.modal-body #img').attr('src', img);
                // set data
                modal.find('.modal-body #id_display').text(data.id);
                modal.find('.modal-body #transaction').text(data.document_no);
                modal.find('.modal-body #merchant').text(data.merchant.name);
                // modal.find('.modal-body #bank_account_name').text(bank.saving_account.bank_account_name);
                // modal.find('.modal-body #bank_account_number').text(bank.saving_account.bank_account_number);
                // modal.find('.modal-body #bank_name').text(bank.saving_account.bank_name);
                modal.find('.modal-body #amount').text(data.amount);
                modal.find('.modal-body #processing_fee').html(formatter.format(data.processing_fee, 2) +
                    "<br>" + "(" + formatter.format(data.processing_rate, 2) + "% + " + formatter
                    .format(data.processing_fix, 2) + ")");
                modal.find('.modal-body #description').text(data.description);
                modal.find('.modal-body #remark').text(data.remark);
                modal.find('.modal-body #created_at').text(data.created_at);
                modal.find('.modal-body #status_display').html(status);
                modal.find('.modal-footer #id').val(data.id);

                if (data.status != '0') {
                    modal.find('#approve').hide();
                    modal.find('#reject').hide();
                } else {
                    modal.find('#approve').show();
                    modal.find('#reject').show();
                }

            });
            // set action
            $("button[name=status]").on('click', function(e) {
                e.preventDefault();
                $('#status').val(this.value);
                form = $('#approve_form');
                var formData = new FormData(form[0]);
                var type = form.attr('method');

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
                            alert(data.ret_msg);
                        }
                    }
                });
            });

        })

    </script>
@endsection
