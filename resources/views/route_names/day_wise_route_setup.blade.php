@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Assign Route to {{ $user->name }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            @if ($route_data == null)
                {!! Form::open(['route' => 'user.store_day_wise_route_setup']) !!}
            @else
                {!! Form::open(['route' => ['user.update_day_wise_route_setup', $user->id], 'method' => 'patch']) !!}
            @endif


            <div class="card-body">

                <div class="row">
                    @include('route_names.fields_day_wise_route_setup')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('user.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
        
    </div>
@endsection
