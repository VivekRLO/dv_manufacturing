@extends('layouts.app')

@section('content')
    @include('flash::message')
    <div class="container-fluid">

        <div class="p-3 row">
            <div class="col-md-12">
                <div class="row">
                    @if (isset($user_rolewise_count[5]))
                        <div class="col-xl-3">
                            <a href="{{ route('users.dse_users') }}">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden ms-3">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                   DSE </p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="fs-4 flex-grow-1 mb-0">
                                                        {{ sizeof($user_rolewise_count[5]) }} <span
                                                            class="counter-value">
                                                        </span></h4>
                                                </div>
                                                <p class="text-muted text-truncate mb-0"> <b>Active</b>
                                                    [{{ $active_dse }}] <b>Inactive</b>
                                                    [{{ sizeof($user_rolewise_count[5]) - $active_dse }}] </p>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                            </a>
                        </div><!-- end col -->
                    @endif

                    @if (isset($user_rolewise_count[3]))
                        <div class="col-xl-3">
                            <a href="{{ route('users.so_users') }}">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden ms-3">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Sales Officer </p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="fs-4 flex-grow-1 mb-0">
                                                        {{ sizeof($user_rolewise_count[3]) }} <span
                                                            class="counter-value">
                                                        </span></h4>
                                                </div>
                                                <p class="text-muted text-truncate mb-0">
                                                    <b>Active</b>
                                                    [
                                                    @if (isset($active_web_user[3]))
                                                        {{ sizeof($active_web_user[3]) }}
                                                    @else
                                                        0
                                                    @endif
                                                    ]
                                                    <b>Inactive</b>
                                                    [
                                                    @if (isset($active_web_user[3]))
                                                        {{ sizeof($user_rolewise_count[3]) - sizeof($active_web_user[3]) }}
                                                    @else
                                                        {{ sizeof($user_rolewise_count[3]) }}
                                                    @endif
                                                    ]
                                                </p>

                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                            </a>
                        </div><!-- end col -->
                    @endif

                    @if (isset($user_rolewise_count[4]))
                        <div class="col-xl-3">
                            <a href="{{ route('users.rm_users') }}">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden ms-3">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Regional Manager </p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="fs-4 flex-grow-1 mb-0">
                                                        {{ sizeof($user_rolewise_count[4]) }} <span
                                                            class="counter-value">
                                                        </span></h4>
                                                </div>
                                                <p class="text-muted text-truncate mb-0">
                                                    <b>Active</b>
                                                    [
                                                    @if (isset($active_web_user[4]))
                                                        {{ sizeof($active_web_user[4]) }}
                                                    @else
                                                        0
                                                    @endif
                                                    ]
                                                    <b>Inactive</b>
                                                    [
                                                    @if (isset($active_web_user[4]))
                                                        {{ sizeof($user_rolewise_count[4]) - sizeof($active_web_user[4]) }}
                                                    @else
                                                        {{ sizeof($user_rolewise_count[4]) }}
                                                    @endif
                                                    ]
                                                </p>

                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                            </a>
                        </div><!-- end col -->
                    @endif

                    <div class="col-xl-3">
                        <a href="{{ route('users.outlets') }}">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                Outlets </p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0">
                                                    {{ $outlets_count }}
                                                    <span
                                                        class="counter-value">
                                                    </span></h4>
                                            </div>
                                            <p class="text-muted text-truncate mb-0">
                                                <b>Order Party</b>
                                                [
                                                    {{ $order_outlets }}
                                                ]
                                                <b>No order Party</b>
                                                [
                                                    {{ $outlets_count - $order_outlets }}
                                                ]
                                            </p>

                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </a>
                    </div><!-- end col -->

                    @if (isset($user_rolewise_count[5]))
                        <div class="col-xl-3">
                            <a href="{{ route('products.index') }}">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden ms-3">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">
                                                    Product </p>
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="fs-4 flex-grow-1 mb-0">
                                                        @php
                                                            $products_count =  $products->count();
                                                            $brands =  $products->unique('brand_name')->count();
                                                        @endphp
                                                        {{ $products_count }}
                                                        <span
                                                            class="counter-value">
                                                        </span></h4>
                                                </div>
                                                <p class="text-muted text-truncate mb-0">
                                                    <b>Total brands</b>
                                                    
                                                    [
                                                        {{ $brands }}
                                                    ]
                                                    {{-- <b>No order Party</b>
                                                    [
                                                        {{ $outlets_count - $order_outlets }}
                                                    ] --}}
                                                </p>

                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div>
                            </a>
                        </div><!-- end col -->
                    @endif

                </div><!-- end row -->
            </div><!-- end col -->

            <div class="col-md-3" style="float: right;">
                @if (Auth::user()->role == 0)
                    <!-- Chart's container -->
                    <div class="card">
                        <div class="card-body">
                        <div class="text-uppercase text-muted">
                            Target
                        </div>
                            <div id="chart" style="height: 300px;"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <script>
      const chart = new Chartisan({
        el: '#chart',
        url: "@chart('test_chart')",
        hooks: new ChartisanHooks()
            .legend()
            .datasets([{type: 'pie', radius: ['40%', '60%']}])
            .axis(false)
      });
    </script>
@endsection
