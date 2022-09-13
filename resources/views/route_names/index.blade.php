@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('flash::message')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Routes</h3>
                </div>
                @if (Auth::user()->role == 0)
                    <a href="{{ route('routeNames.outlet_map_plot', 0) }}" class='btn btn-primary'>
                        No Route Outlets
                    </a>

                    <a class="btn btn-primary ml-2"
                        href="{{ route('routeName.create') }}">
                        Add New
                    </a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-body row">
                @include('route_names.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        {{-- @include('adminlte-templates::common.paginate', ['records' => $routeNames]) --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

