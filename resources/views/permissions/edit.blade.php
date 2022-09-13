@extends('layouts.app')

@section('content')

<div class="content p-3">

    @include('adminlte-templates::common.errors')
    
    <div class="card" style="margin-bottom: 0.2rem;">
        <div class="card-header d-sm-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3>Edit Permissions</h3>
            </div>
        </div>
    </div>

    <div class="card">
        {!! Form::model($permission, ['route' => ['permissions.update', $permission->id], 'method' => 'patch']) !!}

        <div class="card-body">
            <div class="row">
                @include('permissions.fields')
            </div>
        </div>

        <div class="card-footer">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('permissions.index') }}" class="btn btn-default">Cancel</a>
        </div>

       {!! Form::close() !!}

    </div>
</div>
    {{-- <div class="row">
        <div class="col-12 my-5">
            <form method="POST" action="{{ route('permissions.update', $permission) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="permission_name">Permission name</label>
                    <input type="text" class="form-control @error('permission_name') is-invalid @enderror" name="permission_name" id="permission_name" aria-describedby="permission_name" placeholder="Enter permission name" value="{{ !empty(old('permission_name')) ? old('permission_name') : $permission->name }}">
                    @error('permission_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('permission_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12 my-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
    @endsection