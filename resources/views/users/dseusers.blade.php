@extends('layouts.app')

@section('content')
    <style>
        .dot {
            height: 25px;
            width: 25px;

            border-radius: 50%;
            display: inline-block;
        }

    </style>
    
    <div class="content p-3">

        @include('flash::message')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Sales By DSE</h3>
                </div>
            </div>
        </div>

        {{-- Filter Option Start --}}

        <ul class="navbar-nav ml-auto mb-1">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="btn btn-primary nav-link dropdown-toggle" style="width: 135px" data-toggle="dropdown">
                    <i class="fa fa-filter" aria-hidden="true">Filter Option</i>
                </a>
                <ul class="dropdown-menu dropdown-menu-left" style="width: 25% !important; padding:5px">
                    <form action="{{ route('users.dse_filter') }}" method="POST">
                        @csrf
                        <li class="user-header" style="text-align: left!important; ">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    {!! Form::label('date_from', 'From:') !!}
                                    {!! Form::date('date_from', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-sm-6">
                                    {!! Form::label('date_to', 'To:') !!}
                                    {!! Form::date('date_to', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-6">
                                    {!! Form::label('filter_by', 'Filter By:') !!}
                                    <select name="filter_by" id="filter_by" class="form-control"
                                        onclick="getnamefilterwise(value)">
                                        <option value="" disabled selected>Choose Option</option>
                                        <option value="DSE">DSE</option>
                                        <option value="Sub D">Sub D</option>
                                        <option value="Routewise">Routewise</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    {!! Form::label('name', 'Name:') !!}
                                    <select name="filtername" id="filtername" class="form-control">
                                        <option value="" disabled selected>Choose Option</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-filter"
                                    aria-hidden="true">Filter</i> </button>
                        </li>
                    </form>
                </ul>
            </li>
        </ul>

        {{-- Filter option END --}}

        <div class="card">
            <div class="card-body">
                <div class="row table-responsive">
                    <table class="table" id="daily-dse-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Distributor</th>
                                <th>Route / TimeStamp</th>
                                <th>Total Call</th>
                                <th>Productivity Call</th>
                                <th>Unsuccess Call</th>
                                <th>Remaining Call</th>
                                <th>Order Recevied</th>
                                <th>Target</th>
                                {{-- <th>Acheived</th> --}}
                                <th>Outlet Sale Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($dseusers))
                                @foreach ($dseusers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->salesOfficer_distributor[0]->name ?? '-' }}</td>
                                        <td>
                                            @php
                                                $routename = App\Models\RouteLog::where('salesofficer_id', $user->id)
                                                    ->whereBetween('created_at', [$date_from, $date_to])
                                                    ->get();
                                                $routename = $routename->unique('route');
                                                $route_array = $routename->pluck('route');
                                                foreach ($routename as $item) {
                                                    if (!is_null($item)) {
                                                        echo '<li>' . App\Models\RouteName::find($item->route)->routename . ' / ' . $item->created_at . '</li>';
                                                        // echo '<li>' . $item->route . ' / ' . $item->created_at . '</li>';
                                                    } else {
                                                        echo '<li> No route selected </li>';
                                                    }
                                                }
                                            @endphp
                                        </td>
                                        @php
                                            $sales = App\Models\Sale::where('sales_officer_id', $user->id)
                                                ->whereNotNull('outlet_id')
                                                ->whereBetween('created_at', [$date_from, $date_to])
                                                ->get();

                                            $totalcall = App\Models\Outlet::whereIn('route_id', $route_array)
                                                ->where('flag', 0)
                                                ->get()
                                                ->count();

                                            $success_outlets = $sales # Gives Success calls
                                                ->where('product_id', '>', 0)
                                                ->where('quantity', '>', 0)
                                                ->unique('outlet_id')->pluck('outlet_id');

                                            $productivity_call = $success_outlets->count();

                                            $unsuccess_call = $sales
                                                ->where('product_id', '=', 0)
                                                ->where('quantity', '=', 0)
                                                ->unique('outlet_id')
                                                // ->where('outlet_id', '!=', $success_outlets)
                                                ->count();

                                            $outlets = App\Models\Outlet::whereIn('route_id', $route_array)->get();
                                            $remainingcall = $outlets->where('flag', 0)->count() - $productivity_call - $unsuccess_call;
                                            if($remainingcall < 0){
                                                $remainingcall = 0;
                                            }
                                            $data = Illuminate\Support\Facades\DB::table('sales')
                                                ->whereBetween('sales.created_at', [$date_from, $date_to])
                                                ->where('sales_officer_id', $user->id)
                                                ->whereNotNull('product_id')
                                                ->groupBy(['product_id', 'products.value'])
                                                ->join('products', 'products.id', '=', 'sales.product_id')
                                                ->select('product_id', 'products.value', DB::raw('sum(quantity) as totalquantity'))
                                                ->get();
                                            $orderRecevied = 0;
                                            foreach ($data as $value) {
                                                $orderRecevied += $value->totalquantity * $value->value;
                                            }
                                            
                                            $target = App\Models\Quotation::where(['user_id' => $user->id, 'month' => \Carbon\Carbon::now()->format('M-Y')])->first();
                                            if (!isset($target)) {
                                                $achivement = 0;
                                            } else {
                                                $achivement = $target->achieved;
                                            }
                                            
                                            if ($achivement == null) {
                                                $achivement = 0;
                                            }
                                            
                                        @endphp
                                        <td>{{ $totalcall }}</td>
                                        <td>{{ $productivity_call }}</td>
                                        <td>{{ $unsuccess_call }}</td>
                                        <td>{{ $remainingcall }}</td>
                                        <td>{{ $orderRecevied }}</td>
                                        <td>{{ $target->value ?? '0' }}</td>
                                        {{-- <td>{{ $achivement }}</td> --}}
                                        <td>
                                            @if (isset($routename[0]->id))
                                                {!! Form::open(['method' => 'POST', 'route' => 'report.daily_report_sales_officer']) !!}
                                                {!! Form::date('date_to', Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d'), ['class' => 'form-control', 'hidden' => true]) !!}
                                                {!! Form::text('filter_by', 'DSE', ['class' => 'form-control', 'hidden' => true]) !!}
                                                {!! Form::text('filtername', $user->id, ['class' => 'form-control', 'hidden' => true]) !!}

                                                <button type="submit" class="right badge badge-primary">View
                                                    Details</button>
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                if (empty($route_array->toarray())) {
                                                    echo '<span class="dot" style="background-color: red;"></span>';
                                                } else {
                                                    echo '<span class="dot" style="background-color: green;"></span>';
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $users])
                    </div>
                </div> --}}
            </div>

        </div>
    </div>

@endsection

@section('third_party_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#daily-dse-table').DataTable({
                "paging": true,
                "info": true,
                "sort": true,
                "pageLength": 50,
                "order": [
                    [3, "desc"]
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',
                    {
                        extend: 'excel',
                        title: 'Dv Trading (Daily sales by DSE Tables)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }

                    },
                    {
                        extend: 'pdf',
                        title: 'Dv Trading (Daily sales by DSE Tables)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }

                    }
                ]
            });
        });

        function getnamefilterwise(value) {
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
