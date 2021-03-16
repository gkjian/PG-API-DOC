@extends('layouts.admin')
@section('content')
    @can('balance_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                {{-- <a class="btn btn-success" href="{{ route('admin.balances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.balance.title_singular') }}
            </a> --}}
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
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.balance.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Balance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.balance.fields.id') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.merchant') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.debit') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.credit') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.processing_fee') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.type') }}
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
                            {{ trans('cruds.balance.fields.currency') }}
                        </th>
                        <th class="export">
                            {{ trans('cruds.balance.fields.gate') }}
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
                        <th class="export">
                            {{ trans('cruds.balance.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
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
                ajax: "{{ route('admin.balances.index') }}",
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
                        data: 'merchant_name',
                        name: 'merchant.name'
                    },
                    {
                        data: 'debit',
                        name: 'debit'
                    },
                    {
                        data: 'credit',
                        name: 'credit'
                    },
                    {
                        data: 'processing_fee',
                        name: 'processing_fee'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            console.log(parseInt(row['status']));
                            switch (parseInt(row['status'])) {
                                case 0:
                                    return '<span class="badge badge-success">' + row['status_name'] +
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
                                default:
                                    return '<span class="badge badge-secondary">' + row['status_name'] +
                                        '</span>';
                                    break;
                            }
                        }
                    },
                    {
                        data: 'transaction',
                        name: 'document_no'
                    },
                    {
                        data: 'remark',
                        name: 'remark',
                        visible: false,
                    },
                    {
                        data: 'settlement_status',
                        name: 'settlement_status',
                        render: function(data, type, row) {
                            switch (parseInt(row['settlement_status'])) {
                                case 0:
                                    return '<span class="badge badge-secondary">' + row[
                                            'settlement_status_name'] +
                                        '</span>';
                                    break;
                                case 1:
                                    return '<span class="badge badge-success">' + row[
                                            'settlement_status_name'] +
                                        '</span>';
                                    break;
                                default:
                                    return '<span class="badge badge-secondary">' + row[
                                            'settlement_status_name'] +
                                        '</span>';
                                    break;
                            }
                        }
                    },
                    {
                        data: 'currency',
                        name: 'currency'
                    },
                    {
                        data: 'gate_name',
                        name: 'gate.name'
                    },
                    {
                        data: 'saving_account.bank_name',
                        name: 'saving_account.bank_name',
                        visible: false,
                    },
                    {
                        data: 'saving_account.bank_account_name',
                        name: 'saving_account.bank_account_name',
                        visible: false,
                    },
                    {
                        data: 'saving_account.bank_account_number',
                        name: 'saving_account.bank_account_number',
                        visible: false,
                    },
                    {
                        data: 'settlement_bank.bank_name',
                        name: 'settlement_bank.bank_name',
                        visible: false,
                    },
                    {
                        data: 'settlement_bank.bank_account_name',
                        name: 'settlement_bank.bank_account_name',
                        visible: false,
                    },
                    {
                        data: 'settlement_bank.bank_account_number',
                        name: 'settlement_bank.bank_account_number',
                        visible: false,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        visible: false,
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
            let table = $('.datatable-Balance').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });

    </script>
@endsection
