@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('flash::message')
        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Daily Orders Report</h3>
                </div>
            </div>
        </div>

        <ul class="navbar-nav ml-auto mb-1">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="btn btn-primary nav-link dropdown-toggle" style="width: 135px" data-toggle="dropdown">
                    <i class="fa fa-filter" aria-hidden="true">Filter Option</i>
                </a>
                <ul class="dropdown-menu dropdown-menu-left" style="width: 25% !important; padding:5px">
                    <form action="{{ route('report.daily_report_sales_officer') }}" method="POST">
                        @csrf
                        <li class="user-header" style="text-align: left!important; ">
                            <div class="row" >
                                
                                <div class="form-group col-sm-12">
                                    {!! Form::label('date_to', 'Date To:') !!}
                                    {!! Form::date('date_to', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
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
                                    <select name="filtername" id="filtername" class="form-control">
                                        <option value="" disabled selected>Choose Option</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-filter" aria-hidden="true">Filter</i> </button> 
                        </li>
                    </form>
                </ul>
            </li>
        </ul>

            <div class="card-body m-3">
                <h4>Information</h4>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <h5 class="title">
                            {{ App\Models\User::find(App\Models\User::find($sale->dse)->regionalmanager)->name??'-' }} [ {{App\Models\User::find(App\Models\User::find($sale->dse)->regionalmanager)->id??'-' }} ]
                        </h5>
                        <h6 class="subtitle mb-2 text-muted">
                            Regional Manager
                        </h6>
                    </div>
                    <div class="col-4">
                        <h5 class="title">
                            {{ App\Models\User::find(App\Models\User::find($sale->dse)->sales_supervisor_id)->name??'-' }} [ {{App\Models\User::find(App\Models\User::find($sale->dse)->sales_supervisor_id)->id??'-' }} ]
                        </h5>
                        <h6 class="subtitle mb-2 text-muted">
                            Sales Officer
                        </h6>
                    </div>
                    {{-- If user is DSE else number of active DSE under them --}}
                    <div class="col-4">
                        <h5 class="title">
                            {{ App\Models\User::find($sale->dse)->name??"-" }} [ {{App\Models\User::find($sale->dse)->id??"-" }} ]
                        </h5>
                        <h6 class="subtitle mb-2 text-muted">
                            DSE
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body row">
                <div class="table-responsive">
                    <table  id="daily-sales-table" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Sub D</th>
                                <th>Route</th>
                                <th>Outlet ID</th>
                                <th>Outlet</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($sales))
                            @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->date }}</td>
                                @php
                                    $user = App\Models\User::find($sale->dse);
                                @endphp
                                <td><a href="{{ route('users.user_filter', App\Models\User::find(App\Models\User::find($sale->dse)->regionalmanager)->id??'-') }}">{{ App\Models\User::find($user->regionalmanager)->name??"-" }}</a></td>
                                <td><a href="{{ route('users.user_filter', App\Models\User::find(App\Models\User::find($sale->dse)->sales_supervisor_id)->id??'-') }}">{{ App\Models\User::find(App\Models\User::find($sale->dse)->sales_supervisor_id)->name??"-" }}</a></td>
                                <td><a href="{{ route('users.user_filter', App\Models\User::find($sale->dse)->id) }}">{{ App\Models\User::find($sale->dse)->name??"-" }}</a></td>
                                <td><a href="{{ route('distributors.distributors_filter', App\Models\Distributor::find($sale->distributor_id)->id??'-') }}">{{ App\Models\Distributor::find($sale->distributor_id)->name??"-" }}</a></td>
                                <td><a href="{{ route('route.route_filter', App\Models\Routename::find($sale->route_id)->id??'-') }}">{{ App\Models\Routename::find($sale->route_id)->routename??"-" }}</a></td>
                                <td><a href="{{ route('outlets.show', App\Models\Outlet::find($sale->outlet_id)->id??'-') }}">{{ App\Models\Outlet::find($sale->outlet_id)->name??"-" }}</a></td>
                                @php
                                    $product=App\Models\Product::find($sale->product_id);
                                @endphp
                                <td>{{ $product->brand_name??"-"  }}</td>
                                <td><a href="{{ route('product.product_filter_by_id', $product->id??'-') }}">{{ $product->name??"-"  }}</a></td>
                                <td>
                                    @if ($sale->remarks == null)
                                        @php
                                            $products = (int) $product->value * (int) $sale->sum;
                                        @endphp
                                        Successful
                                    @else
                                        @php
                                            $products = 0;
                                        @endphp
                                        Unsuccessful
                                    @endif
                                </td>
                                <td>{{ $sale->sum }}</td>
                                <td>{{ $product->value??"-"  }}</td>
                                <td>{{ $products  }}</td>
                                <td>{{ $sale->remarks??"-"  }}</td>
                            </tr>
                               
                            @endforeach
                            
                            @endif
                        </tbody>
                    </table>
                </div>

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

            $('#daily-sales-table').DataTable({
                "paging": true,
                "info": false,
                "sort": true,
                "pageLength": 30,
                // "order": [ 2, "asc" ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',
                    {
                        extend: 'excel',
                        title: 'DV Trading (Daily Order Report)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',

                    },
                    {
                        extend: 'pdf',
                        title: 'DV Trading (Daily Order Report)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',

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