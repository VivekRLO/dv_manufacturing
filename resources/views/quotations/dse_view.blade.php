@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('adminlte-templates::common.errors')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Target for {{ $quotations[0]->month }}</h3>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('quotations.dse_table')
                </div>
            </div>
        </div>
    </div>
@endsection
