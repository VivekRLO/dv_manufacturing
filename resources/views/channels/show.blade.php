@extends('layouts.app')

@section('content')

    <div class="content p-3">

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Channel Details</h3>
                </div>
                <a class="btn btn-default"
                    href="{{ route('channels.index') }}">
                    Back
                </a>
            </div>
        </div>
        <div class="card">

            <div class="card-body">
                <div class="row">
                    @include('channels.show_fields')
                </div>
            </div>

        </div>
    </div>
@endsection
