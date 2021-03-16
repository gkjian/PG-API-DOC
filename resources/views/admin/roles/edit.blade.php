@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.roles.update", [$role->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.role.fields.title') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required>
                @if($errors->has('name'))
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.role.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs" id="select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs" id="deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <div class="row">
                    @foreach($unique as $u)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header btn select-part a" data-l="{{$u->type}}" checked>
                                    {{ $u->type }}
                                </div>
                                <div class="card-body overflow-auto" style="height: 200px;">
                                    @foreach ($permissions as $permission)
                                        @if ($permission->type == $u->type)
                                        {{-- <option value="{{ $permission->id }}" {{ (in_array($id, old('permissions', [])) || $role->permissions->contains($permission->id)) ? 'selected' : '' }}>{{ $permission->title }}</option> --}}
                                        <div class="form-check">
                                            <input type="checkbox" class="check2 {{$permission->type}}" name="permissions[]" id="" value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                            <label for="">{{ $permission->name }}</label>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required>
                    @foreach($permissions as $id => $permissions)
                    @if(substr($permissions->name, -7, 7) != '_delete')
                    @if($permissions->guard_name == "admin")
                    <option title="{{$permissions->name}}" value="{{ $permissions->id }}" {{ (in_array($permissions->id, old('permissions', [])) || $role->permissions->contains($permissions->id)) ? 'selected' : '' }}>{{ $permissions->name." (admin)" }}</option>
                    @else
                    <option title="{{$permissions->name}}" value="{{ $permissions->id }}" {{ (in_array($permissions->id, old('permissions', [])) || $role->permissions->contains($permissions->id)) ? 'selected' : '' }}>{{ $permissions->name }}</option>
                    @endif
                    @endif
                    @endforeach
                </select> --}}
                @if($errors->has('permissions'))
                <div class="invalid-feedback">
                    {{ $errors->first('permissions') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.role.fields.permissions_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
@parent

<script>
    $(function(){
        $(document).on('click' , '.a' , function(e){
            var v = $(this).attr('data-l');
            if($('.'+v+'').is(':checked')) {
                $('.'+v+'').prop('checked', false);
            } else {
                $('.'+v+'').prop('checked', true);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#select-all').click(function() {

            var checked = true;
            $('input[type="checkbox"]').each(function() {
            this.checked = checked;
            });
        })
    });
</script>

<script>
    $(document).ready(function() {
        $('#deselect-all').click(function() {

            var checked = false;
            $('input[type="checkbox"]').each(function() {
            this.checked = checked;
            });
        })
    });
</script>

@endsection
