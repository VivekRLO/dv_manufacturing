@extends('layouts.app')

@section('content')
    <style>
        .select2-container .select2-selection--single {
            height: 39px !important;
        }

    </style>

    <div class="content p-3">

        @include('flash::message')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Routewise Outlet Activity</h3>
                </div>
            </div>
        </div>
    
        <ul class="navbar-nav ml-auto mb-1">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="btn btn-primary nav-link dropdown-toggle text-white" style="width: 135px" data-toggle="dropdown">
                    <i class="fa fa-filter" aria-hidden="true">Filter Option</i>
                </a>
                <ul class="dropdown-menu dropdown-menu-left" style="width: 25% !important; padding:5px">
                    <form action="{{ route('report.routewise_outlet_report') }}" method="POST">
                        @csrf
                        <li class="user-header" style="text-align: left!important; ">
                            <div class="row" >
                                <div class="form-group col-sm-6">
                                    {!! Form::label('date_from', 'Date From:') !!}
                                    {!! Form::date('date_from', null, ['class' => 'form-control','required'=>'required']) !!}
                                </div>
                                <div class="form-group col-sm-6">
                                    {!! Form::label('date_to', 'Date To:') !!}
                                    {!! Form::date('date_to', null, ['class' => 'form-control','required'=>'required']) !!}
                                </div>
                                <div class="form-group col-sm-6">
                                    {!! Form::label('filter_by', 'Filter By:') !!}
                                    {{-- {!! Form::select('filter_by',[''=>'Choice option','DSE'=>'DSE','Sub D'=>'Sub D','Routewise'=>'Routewise'], null, ['class' => 'form-control','id'=>'filter_by','onClick' => 'getnamefilterwise(value)']) !!} --}}
                                    <select name="filter_by" id="filter_by" class="form-control" onclick="getnamefilterwise(value)">
                                        <option value="" disabled selected>Choose Option</option>
                                        <option value="DSE" >DSE</option>
                                        <option value="Sub D" >Sub D</option>
                                        <option value="Routewise" >Routewise</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    {!! Form::label('name', 'Name:') !!}
                                    {{-- {!! Form::select('name',[], null, ['class' => 'form-control','id'=>'filtername']) !!} --}}
                                    <select name="filtername" id="filtername" class="form-control">
                                        <option value="" disabled selected>Choose Option</option>
                                    </select>
                                </div>
                            </div>
                    
                            <button type="submit" class="btn btn-success"><i class="fa fa-filter" aria-hidden="true">Filter</i> </button> 
                        
                    </form>
                </ul>
            </li>
        </ul>
       
        <div class="card">
            <div class="card-body row">
                <div class="table-responsive">
                    <table class="table" id="outletwise_product_report" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>DSE Id</th>
                                <th>DSE Name</th>
                                <th>Sub D</th>
                                <th>Route</th>
                                <th>Outlets Visited</th>
                                <th>Order Party</th>
                                <th>No Order Party</th>
                                <th>Last Date</th>
                                <th>Oultet Sale Details</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->dsub }}</td>
                                    <td>
                                        @php
                                            // $routename = App\Models\RouteName::find($user->route)->routename ?? '';
                                            if($user->created_at == null){
                                                $date = Carbon\Carbon::now(); 
                                            }else{
                                                $date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('Y-m-d');
                                            }
                                            $route = App\Models\RouteLog::where('salesofficer_id', $user->id)->whereDate('created_at', 'like', '%' . $date . '%')->get();
                                            $route=$route->unique('route');
                                            $route_array=$route->pluck('route');
                                            foreach($route as $item){
                                                if (!empty($item)) {
                                                    echo '<li>'.App\Models\RouteName::find($item->route)->routename.'</li>';
                                                }
                                            }
                                        @endphp
                                    </td>

                                    @php
                                        $sales_of_the_day = App\Models\Sale::where('sales_officer_id',$user->id)->whereDate('sold_at', 'like', '%' . $date . '%')->get();

                                        $total_outlet = App\Models\Outlet::whereIn('route_id',$route_array)->where('distributor_id', '3')->get()->count();
                                        
                                        $no_order_party = $sales_of_the_day->where('product_id', '=', 0)->unique('outlet_id')->count();

                                        $sales_party = $sales_of_the_day->where('product_id', '>', 0)->unique('outlet_id')->count();

                                        $total_outlet = (int) $sales_party + (int) $no_order_party;
                                        
                                    @endphp
                                    <td>{{ $total_outlet??'-' }}</td>
                                    <td>{{ $sales_party??'-' }}</td>
                                    <td>{{ $no_order_party??'-' }}</td>
                                    <td>{{ $user->created_at??'-' }}</td>
                                    <td>
                                        @if(isset($user->routelogid))
                                            {!! Form::open(['method' => 'POST', 'route' => 'report.daily_report_sales_officer']) !!}
                                                {!! Form::date('date_to', $date, ['class' => 'form-control', 'hidden' => true] ) !!}
                                                {!! Form::text('filter_by', 'DSE', ['class' => 'form-control', 'hidden' => true] ) !!}
                                                {!! Form::text('filtername', $user->id, ['class' => 'form-control', 'hidden' => true] ) !!}

                                                <button type="submit" class="right badge badge-primary">View Details</button>
                                            {!! Form::close() !!}
                                            {{-- <a href="{{ route('report.daily_report_sales_officer') }}" class="right badge badge-primary"> View Report</a> --}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    @endsection
    @section('third_party_scripts')
        <script type="text/javascript">
            $('#date').datetimepicker({
                format: 'YYYY-MM-DD',
                sideBySide: true,
            })
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".search-dropdown").select2({
                    dropdownCssClass: 'bigdrop'
                });
            });
        </script>

        <script>
            $(document).ready(function() {

                $('#outletwise_product_report').DataTable({
                    "paging": false,
                    "info": false,
                    "sort": true,
                    // "order": [ 2, "asc" ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv',
                        {
                            extend: 'excel',
                            title: 'DV Trading (Routewise Outlet Activity)',
                            messageTop: 'DSE Outlet Status Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',

                        },
                        {
                            extend: 'pdf',
                            title: 'DV Trading (Routewise Outlet Activity)',
                            messageTop: 'DSE Outlet Status Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',

                        }
                    ]
                });
            });
            function getnamefilterwise(value){
                console.log(value);
                select = document.getElementById('filtername');
                select.options.length = 1;
                const url = {!! '"' . url('api/get-data?filterby=') . '"' !!} + value;
                $.get(url, function(data, status) {
                    console.log(data);
                    for (var i = 0; i < data.data.length; i++) {
                        var option = document.createElement("option");
                        option.value = data.data[i].id;
                        option.text = data.data[i].name;
                        select.appendChild(option);
                    }
                });
            }
        </script>
    @endsection
