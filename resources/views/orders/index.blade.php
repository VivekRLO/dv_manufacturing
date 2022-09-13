@extends('layouts.app')

@section('content')

    <div class="content px-3">

        @include('flash::message')
        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Orders</h3>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body row">
                @include('orders.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $orders])
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

