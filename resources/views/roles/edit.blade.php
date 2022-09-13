@extends('layouts.app')

@section('content')

<div class="content p-3">

    @include('adminlte-templates::common.errors')

    <div class="card" style="margin-bottom: 0.2rem;">
        <div class="card-header d-sm-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3>Edit Role</h3>
            </div>
        </div>
    </div>

    <div class="card">

        {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'patch']) !!}


        <div class="card-body">

            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="role_name">Role name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" aria-describedby="name" placeholder="Enter role name"
                        value="{{ !empty(old('name')) ? old('name') : $role->name }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="card col-12">
                    <h5 class="card-header">Permission List</h5>
                    <div class="card-body">
                
                        @foreach ($permissions as $permission)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="{{ $permission->name . $permission->id }}"
                                    name="permissions[{{ $permission->id }}]" value="1" @if (old('permissions') && array_key_exists($permission->id, old('permissions')))
                                checked
                                @elseif ( !old('permissions') && $role->permissions->contains($permission->id) )
                                    checked
                            @endif
                            >
                            <label class="form-check-label"
                                for="{{ $permission->name . $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('roles.index') }}" class="btn btn-default">Cancel</a>
        </div>

        {!! Form::close() !!}

    </div>
</div>
@endsection