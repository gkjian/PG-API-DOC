@if (isset($viewGate))
    @can($viewGate)
        <a class="btn btn-xs btn-outline-primary mt-2" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
            {{ trans('global.view') }}
        </a>
    @endcan
@endif
@if (isset($editGate))
    @can($editGate)
        <a class="btn btn-xs btn-info mt-2" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
            {{ trans('global.edit') }}
        </a>
    @endcan
@endif
@if (isset($deleteGate))
    @can($deleteGate)
        <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST"
            onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-xs btn-danger mt-2" value="{{ trans('global.delete') }}">
        </form>
    @endcan
@endif
@if (isset($approveGate))
    {{-- @if ($row->status != 0 && $row->status != 1 && $row->status != 2) --}}
    <button type="button" class="btn btn-xs btn-primary mt-2" data-toggle="modal" data-target="#approveModal"
        data-row="{{ $row }}" @if (isset($gateSavingAccount)) data-bank="{{ $gateSavingAccount }}" @endif
        data-img="{{ $img }}">{{ trans('global.actions') }}</button>
    {{-- @endif --}}
@endif

@if (isset($settlementAction))
    @if ($row->status == 0)
        <button type="button" class="btn btn-xs btn-primary mt-2 " data-toggle="modal" data-target="#approveModal"
            data-row="{{ $row }}" @if (isset($gateSavingAccount)) data-bank="{{ $gateSavingAccount }}" @endif
            data-status="{{ $status }}">{{ trans('global.actions') }}</button>
    @endif
@endif

@if (isset($depositAction))
    @if ($row->status == 0)
        <button type="button" class="btn btn-xs btn-primary mt-2" data-toggle="modal" data-target="#approveModal"
            data-row="{{ $row }}" @if (isset($gateSavingAccount)) data-bank="{{ $gateSavingAccount }}" @endif
            data-status="{{ $status }}" data-img="{{ $img }}">{{ trans('global.actions') }}</button>
    @endif
@endif

@if (isset($manage_toUp_request))
    @if ($row->status == 0)
        <button type="button" class="btn btn-xs btn-primary mt-2" data-toggle="modal" data-target="#approveModal"
            data-row="{{ $row }}" data-status="{{ $status }}">Action</button>
    @endif
@endif
