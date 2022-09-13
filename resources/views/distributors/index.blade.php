@extends('layouts.app')

@section('content')
    
    <div class="content p-3">
        @include('flash::message')
        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Distributors</h3>
                </div>
                @if (Auth::user()->role == 0)
                    <a class="btn btn-primary" href="{{ route('distributors.bulk_create') }}">Bulk Add</a>
                    <a class="btn btn-primary ml-2"
                        href="{{ route('distributors.create') }}">
                        Add New
                    </a>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('distributors.table')
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            @include('adminlte-templates::common.paginate', ['records' => $distributors])
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
