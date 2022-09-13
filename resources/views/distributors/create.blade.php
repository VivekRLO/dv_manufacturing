@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('adminlte-templates::common.errors')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Create Distributor</h3>
                </div>
            </div>
        </div>

        <div class="card">

            {!! Form::open(['route' => 'distributors.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('distributors.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('distributors.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
