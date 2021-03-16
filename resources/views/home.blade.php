@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            {{-- <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div> --}}

            @auth('admin')
                <div class="col-lg-12">
                    <h4>Balance (Processing Fee) <span><a href="{{ route('admin.balances.index') }}"> More...</a></span></h4>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body card-body d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-value-lg">{{ $pending_processing_fee }}</div>
                                <div>Pending</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card text-white bg-success">
                        <div class="card-body card-body d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-value-lg">{{ $total_processing_fee }}</div>
                                <div>Completed</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">

                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Completed</th>
                                        <th class="text-center">Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group_by_currency as $index => $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $index }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ isset($item['complete']) ? $item['complete'] : 0 }}</div>
                                            </td>
                                            <td>
                                                <div>{{ isset($item['pending']) ? $item['pending'] : 0 }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">

                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Project</th>
                                        <th class="text-center">Completed</th>
                                        <th class="text-center">Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group_by_project as $index => $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $index }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ isset($item['complete']) ? $item['complete'] : 0 }}</div>
                                            </td>
                                            <td>
                                                <div>{{ isset($item['pending']) ? $item['pending'] : 0 }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">

                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Merchant</th>
                                        <th class="text-center">Completed</th>
                                        <th class="text-center">Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group_by_merchant as $index => $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $index }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ isset($item['complete']) ? $item['complete'] : 0 }}</div>
                                            </td>
                                            <td>
                                                <div>{{ isset($item['pending']) ? $item['pending'] : 0 }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @endauth

            @auth('merchant')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            User Data
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.merchant.fields.id') }}
                                            </th>
                                            <td>
                                                {{ $user->id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.merchant.fields.name') }}
                                            </th>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.merchant.fields.email') }}
                                            </th>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.merchant.fields.email_verified_at') }}
                                            </th>
                                            <td>
                                                {{ $user->email_verified_at }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.merchant.fields.person_incharge_name') }}
                                            </th>
                                            <td>
                                                {{ $user->person_incharge_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.merchant.fields.contact') }}
                                            </th>
                                            <td>
                                                {{ $user->contact }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.merchant.fields.roles') }}
                                            </th>
                                            <td>
                                                @foreach ($user->roles as $key => $roles)
                                                    <span class="label label-info">{{ $roles->name }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection
@section('scripts')
    @parent

    {{-- <script>
        $(function() {

            function over_ride(status = null, date_range = null) {
                return dtOverrideGlobals = {
                    buttons: [],
                    // buttons: [{
                    //         extend: 'excelHtml5',
                    //         className: "btn btn-success",
                    //         exportOptions: {
                    //             columns: [".export"]
                    //         }

                    //     },
                    //     {
                    //         extend: 'pdfHtml5',
                    //         className: "btn btn-default",
                    //         orientation: 'landscape',
                    //         exportOptions: {
                    //             columns: [".export"]
                    //         }

                    //     },
                    //     {
                    //         extend: 'csvHtml5',
                    //         className: "btn btn-info",
                    //         exportOptions: {
                    //             columns: [".export"]
                    //         }

                    //     },
                    // ],
                    processing: true,
                    serverside: false,
                    retrieve: true,
                    aaSorting: [],
                    ajax: "{{ route('admin.home.transaction_report') }}?status=" + status +
                        "&date_range=" + date_range +
                        "",
                    columns: [{
                            data: 'id',
                            name: 'id',
                        },
                        {
                            data: 'id',
                            name: 'id',
                        },
                        {
                            data: 'id',
                            name: 'id',
                        },
                    ],
                    orderCellsTop: true,
                    order: [
                        [1, 'desc']
                    ],
                    paging: false,
                    bLengthChange: false,
                    bFilter: false,
                    bInfo: false,
                    pageLength: 20,
                };
            }

            let table = $('.datatable-Payout').DataTable(over_ride());
        });

    </script> --}}

@endsection
