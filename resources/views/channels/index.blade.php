@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('flash::message')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Channels</h3>
                </div>
                @if (Auth::user()->role == 0)
                    <a class="btn btn-primary"
                        href="{{ route('channels.create') }}">
                        Add New
                    </a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body row">
                @include('channels.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $channels])
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

