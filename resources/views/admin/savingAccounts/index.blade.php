@extends('layouts.admin')
@section('content')
@can('saving_account_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.saving-accounts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.savingAccount.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'SavingAccount', 'route' => 'admin.saving-accounts.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.savingAccount.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SavingAccount">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.bank_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.bank_account_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.bank_account_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.currency') }}
                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.daily_limit') }}
                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.transaction_limit') }}
                    </th>
                    <th>
                        {{ trans('cruds.savingAccount.fields.status') }}
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
// @can('saving_account_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.saving-accounts.massDestroy') }}",
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
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.saving-accounts.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'bank_name', name: 'bank_name' },
{ data: 'bank_account_name', name: 'bank_account_name' },
{ data: 'bank_account_number', name: 'bank_account_number' },
{ data: 'currency_name', name: 'currency.name' },
{ data: 'daily_limit', name: 'daily_limit' },
{ data: 'transaction_limit', name: 'transaction_limit' },
{ data: 'status', name: 'status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-SavingAccount').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection