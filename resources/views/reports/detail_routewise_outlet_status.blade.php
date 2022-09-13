@extends('layouts.app')

@section('content')
    <style>
        .select2-container .select2-selection--single {
            height: 39px !important;
        }

    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Routewise Outlet Status Report</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-secondary float-right"
                       href="{{ route('report.routewise_outlet_status') }}">
                        Back
                    </a>
                </div>
                
            </div>
            
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')
        {{-- <form action="{{ route('report.routewise_outlet_report') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-sm-1">
                    {!! Form::label('date', 'Select Date:') !!}
                    {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date', 'required' => 'required']) !!}
                </div>
                <!-- RegionalManager Field -->
                <div class="form-group col-sm-2"  id="RegionalManager">
                    {!! Form::label('RegionalManager', 'Regional Manager:') !!}
                    <select class=" form-control" id="regionalmanager" name="regionalmanager" onchange="getSalesSupervisor(value)" value="{{ old('regionalmanager') }}" required>
                        <option selected disabled value="">Select the Regional Manager</option>
                        @foreach (\app\Models\User::where('role', 4)->get() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- supervisor_sales_officer Field -->
                <div class="form-group col-sm-2"  id="supervisor_sales_officer">
                    {!! Form::label('supervisor_sales_officer', 'Sales Supervisor:') !!}
                    <select class=" form-control" id="supervisor_sales_officer_id" name="sales_supervisor_id" value="{{ old('sales_supervisor_id') }}" onchange="getDSE(value)" required>
                        <option selected disabled value="">Select the Sales Supervisor</option>
                    </select>
                </div>

                <!-- DSE Field -->
                <div class="form-group col-sm-2"  id="dse_div">
                    {!! Form::label('dse_div', 'DSE:') !!}
                    <select class=" form-control" id="dse_id" name="sale_officer_id" value="{{ old('sale_officer_id') }}" onchange="getroutelist(value)" required >
                        <option selected disabled value="">Select DSE</option>
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    {!! Form::label('route_id', 'Route Name:') !!}
                   
                    <select class="search-dropdown form-control" id="route_id" name="route_id" value="{{ old('route_id') }}"  required >
                        <option selected disabled value="">Select Route</option>
                    </select>
                </div>
                <div style=" padding-top: 25px;">
                    <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>

        </form> --}}
      

        <div class="clearfix"></div>
        @if (isset($outlestdata_array))
            <div class="card">
                <div class="card-header">
                    @if (isset($date) || isset($route))
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Route  :{{ $route ?? '' }}</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>DSE  :{{ $sale_officer_name?? '' }}</h4>
                        </div>

                        <div class="col-md-4">
                            <h4> Date:{{ $date ?? '' }}</h4>
                        </div>
                    </div>
                @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table" id="outletwise_product_report" class="display nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Outlet ID</th>
                                    <th>Outlets</th>
                                    <th>Status</th>


                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{ dd($outlestdata_array) }} --}}
                                @foreach ($outlestdata_array as $outlet)
                                    <tr>
                                        <td>{{  $outlet->id }}</td>
                                        {{-- <td>{{  $loop->index+1 }}</td> --}}
                                        <td>{{$outlet->name }}</td>
                                        <td>
                                            @php
                                                $carbon = \Carbon\Carbon::now()->format('Y-m-d');
                                                $remark = 0;

                                                foreach ($outlet->sales as $sale) {
                                                    if($sale->remarks != null && strpos($sale->sold_at, $carbon)){
                                                        $remark = 1;
                                                    }elseif($sale->remarks == null && strpos($sale->sold_at, $carbon)){
                                                        $remark = 2;
                                                    }else{
                                                        $remark = 3;
                                                    }
                                                }
                                            @endphp

                                            @if($remark == 1)
                                                <small class="badge badge-warning"><i class="far fa-clock"></i> Remarks </small> 
                                            @elseif($remark == 2)
                                                <small class="badge badge-success"><i class="fa fa-check"></i> Sales Made </small>
                                            @else
                                                <small class="badge badge-danger"><i class="fa fa-clock"></i> No Order Party </small>
                                            @endif

                                            {{-- @if($outlet->sales_count>0)
                                                <small class="badge badge-success"><i class="fa fa-check"></i> Sales Made</small>                                           
                                            @else
                                                <small class="badge badge-danger"><i class="far fa-clock"></i> No orders made </small>                                          
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        @endif
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


                var t =   $('#outletwise_product_report').DataTable({
                    "paging":   false,
                    "info":     false,
                    "sort": false,
                    // "order": [ 2, "asc" ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv',
                        {
                        extend: 'excel',
                        title: 'Dv Trading (Outlet Status Report Of {!! json_encode( $date??"")  !!})',
                        messageTop: 'Route Name: {!! json_encode(  $route??"")  !!}, DSE: {!! json_encode(  $sale_officer_name??"")  !!}',

                    },
                    {
                        extend: 'pdf',
                        title:'Dv Trading (Outlet Status Report of {!! json_encode( $date??"")  !!})',
                        messageTop: 'Route Name: {!! json_encode(  $route??"")  !!}, DSE: {!! json_encode(  $sale_officer_name??"")  !!}',

                    }
                    ],
                    // columnDefs: [{
                    //         orderable: true,
                    //         className: 'reorder',
                    //         targets: [0,1,2,3,4]
                    //     },
                    //     {
                    //         orderable: false,
                    //         targets: '_all'
                    //     }
                    // ]
                });
    //             t.on( 'order.dt search.dt', function () {
    //     t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //         cell.innerHTML = i+1;
    //     } );
    // } ).draw();
            });
        </script>
            <script type="text/javascript">
           
      
                function getSalesSupervisor(value) {
                    selectBranch = document.getElementById('supervisor_sales_officer_id');
                    selectBranch.options.length = 1;
                    const url = {!! '"' . url('api/get-data?regionalmanager=') . '"' !!} + value;
                    $.get(url, function(data, status) {
                        for (var i = 0; i < data.data.length; i++) {
                            var option = document.createElement("option");
                            option.value = data.data[i].id;
                            option.text = data.data[i].name;
                            selectBranch.appendChild(option);
                        }
                    });
                }
    
                function getDSE(value) {
                    selectBranch = document.getElementById('dse_id');
                    selectBranch.options.length = 1;
                    const url = {!! '"' . url('api/get-data?sales_supervisor_id=') . '"' !!} + value;
                    $.get(url, function(data, status) {
                        for (var i = 0; i < data.data.length; i++) {
                            var option = document.createElement("option");
                            option.value = data.data[i].name;
                            option.text = data.data[i].name;
                            selectBranch.appendChild(option);
                        }
                    });
                }
            
                function getroutelist(value){
                    console.log("hello");
                    selectBranch = document.getElementById('route_id');
                    selectBranch.options.length = 1;
                    const url2 = {!! '"' . url('api/get-data?route_user_api=') . '"' !!} + value;
                    $.get(url2, function(data, status) {
                        console.log(data);
                        for (var i = 0; i < data.data.length; i++) {
                            var option = document.createElement("option");
                            option.value = data.data[i].id;
                            option.text = data.data[i].routename;
                            selectBranch.appendChild(option);
                        }
                    });
                }
            </script>
    @endsection
