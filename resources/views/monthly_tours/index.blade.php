@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DSE Route Log</h1>
                </div>
                
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('monthly_tours.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        {{-- @include('adminlte-templates::common.paginate', ['records' => $monthlyTours]) --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

