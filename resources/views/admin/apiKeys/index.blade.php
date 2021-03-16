@extends('layouts.admin')
@section('content')
@can('api_key_create')
    <div style="margin-bottom: 10px;" class="row">
        {{-- <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.api-keys.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.apiKey.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'ApiKey', 'route' => 'admin.api-keys.parseCsvImport'])
        </div> --}}
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.apiKey.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ApiKey">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.apiKey.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.apiKey.fields.api_key') }}
                    </th>
                    <th>
                        {{ trans('cruds.apiKey.fields.gate') }}
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
// @can('api_key_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.api-keys.massDestroy') }}",
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
    ajax: "{{ route('admin.api-keys.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'api_key', name: 'api_key' },
{ data: 'gate_name', name: 'gate.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-ApiKey').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection