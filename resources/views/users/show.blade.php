@extends('layouts.app')

@section('content')
    <div class="content p-3">
        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>User Details</h3>
                </div>
                <a class="btn btn-default"
                    href="{{ route('user.index') }}">
                    Back
                </a>
            </div>
        </div>

        <div class="card">
            <div class="row">
                @include('users.show_fields')
            </div>
        </div>
    </div>
@endsection
