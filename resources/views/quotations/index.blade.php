@extends('layouts.app')

@section('content')
    <div class="content p-3">
        @include('adminlte-templates::common.errors')
        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Targets</h3>
                </div>
                @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                    <a class="btn btn-primary"
                        href="{{ route('quotation.create') }}">
                        Add New
                    </a>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">   
                    @include('quotations.table')    
                </div>
            </div>
        </div>
    </div>
@endsection
