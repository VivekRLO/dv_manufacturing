@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('adminlte-templates::common.errors')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Create App Version</h3>
                </div>
            </div>
        </div>

        <div class="card">

            {!! Form::open(['route' => 'appVersions.store', 'files' => true]) !!}

            <div class="card-body">

                <div class="row">
                    @include('app_versions.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('appVersions.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

<script>
    console.log('post_max_size');
</script>