@extends('layouts.admin')
@section('content')
@can('role_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.roles.create') }}?guard=admin">
                {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }} (Admin)
            </a>

            <a class="btn btn-success" href="{{ route('admin.roles.create') }}?guard=merchant">
                {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }} (Merchant)
            </a>

            <a class="btn btn-success" href="{{ route('admin.roles.create') }}?guard=partner">
                {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }} (Partner)
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Role', 'route' => 'admin.roles.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Role">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.role.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.role.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.permission.fields.created_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.permission.fields.created_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.permission.fields.modified_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.role.fields.permissions') }}
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
// @can('role_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.roles.massDestroy') }}",
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
    serverside: false,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.roles.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'created_at', name: 'created_at' },
{ data: 'created_by_name', name: 'created_by.name' },
{ data: 'modified_by_name', name: 'modified_by.name' },
{ data: 'permissions', name: 'permissions.title' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Role').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
