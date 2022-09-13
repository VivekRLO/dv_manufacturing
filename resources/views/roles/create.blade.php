@extends('layouts.app')

@section('content')

<div class="content p-3">

    @include('adminlte-templates::common.errors')

    <div class="card" style="margin-bottom: 0.2rem;">
        <div class="card-header d-sm-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3>Create Roles</h3>
            </div>
        </div>
    </div>

    <div class="card">

        {!! Form::open(['route' => 'roles.store']) !!}

        <div class="card-body">

            <div class="row">
                <div class="form-group col-sm-12">
                    {!! Form::label('name', 'Role Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 255, 'maxlength' => 255, 'required' => 'required']) !!}
                </div>
                <div class="card col-12">
                    <h5 class="card-header">Permission List</h5>
                    <div class="card-body">
                
                        @foreach ($permissions as $permission)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="{{ $permission->name . $permission->id }}"
                                    name="permissions[{{ $permission->id }}]" value="1">
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
