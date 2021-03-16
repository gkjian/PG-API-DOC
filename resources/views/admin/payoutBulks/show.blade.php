@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.payoutBulk.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payout-bulks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBulk.fields.id') }}
                        </th>
                        <td>
                            {{ $payoutBulk->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBulk.fields.merchant') }}
                        </th>
                        <td>
                            {{ $payoutBulk->merchant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBulk.fields.file_path') }}
                        </th>
                        <td>
                            @if($payoutBulk->file_path)
                                <a href="{{ $payoutBulk->file_path->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payoutBulk.fields.name') }}
                        </th>
                        <td>
                            {{ $payoutBulk->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payout-bulks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection