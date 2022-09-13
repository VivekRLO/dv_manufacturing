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
                    <h3>Outletwise Product Sales</h3>
                </div>
            </div>
        </div>

        <form action="{{ route('report.dse_outlestwise_product_report') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body row">
                    <div class="form-group col-sm-2">
                        {!! Form::label('date', 'Select Date:') !!}
                        {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date', 'required' => 'required']) !!}
                    </div>
                    <!-- RegionalManager Field -->
                    <div class="form-group col-sm-3" id="RegionalManager">
                        {!! Form::label('RegionalManager', 'Regional Manager:') !!}
                        <select class=" form-control" id="regionalmanager" name="regionalmanager"
                            onchange="getSalesSupervisor(value)" value="{{ old('regionalmanager') }}" required>
                            <option selected disabled value="">Select the Regional Manager</option>
                            @foreach (\app\Models\User::where('role', 4)->get() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- supervisor_sales_officer Field -->
                    <div class="form-group col-sm-3" id="supervisor_sales_officer">
                        {!! Form::label('supervisor_sales_officer', 'Sales Supervisor:') !!}
                        <select class=" form-control" id="supervisor_sales_officer_id" name="sales_supervisor_id"
                            value="{{ old('sales_supervisor_id') }}" onclick="getDSE(value)" required>
                            <option selected disabled value="">Select the Sales Supervisor</option>
                        </select>
                    </div>

                    <!-- DSE Field -->
                    <div class="form-group col-sm-3" id="dse_div">
                        {!! Form::label('dse_div', 'DSE:') !!}
                        <select class=" form-control" id="dse_id" name="sale_officer_id"
                            value="{{ old('sale_officer_id') }}" required>
                            <option selected disabled value="">Select DSE</option>
                        </select>
                    </div>

                    {{-- <div class="form-group col-sm-3">
                    {!! Form::label('sale_officer_id', 'DSE:') !!}
                    {!! Form::select('sale_officer_id', $sales_officers, null, ['class' => 'search-dropdown form-control', 'id' => 'sale_officer_id', 'required' => 'required', '']) !!}
                </div> --}}
                    <div style=" padding-top: 25px;">
                        <button type="submit" class="btn btn-lg btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @if (isset($date) || isset($sale_officer_name))
            <div class="card">
                <div class="card-body row">
                    <h5>{{ $sale_officer_name ?? '' }}'s Sales on {{ $date ?? '' }}</h5>
                </div>
            </div>
        @endif

        <div class="clearfix"></div>
        @if (isset($sales))
            <div class="card">
                <div class="card-body row">
                    <div class="table-responsive">
                        <table class="table" id="outletwise_product_report" class="display nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Product</th>
                                    <th>Outlets</th>
                                    <th>Quantity</th>
                                    <th>Discount %</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ App\Models\Product::find($sale->product_id)->name ?? '' }}</td>
                                        <td>{{ App\Models\Outlet::find($sale->outlet_id)->name ?? '' }}</td>
                                        <td>{{ $sale->sum }}</td>
                                        <td>{{ $sale->discount }}</td>
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

        {{-- <script type="text/javascript">
            $(document).ready(function() {
                $(".search-dropdown").select2({
                    dropdownCssClass: 'bigdrop'
                });
            });
        </script> --}}

        <script>
            $(document).ready(function() {


                var t = $('#outletwise_product_report').DataTable({
                    "paging": false,
                    "info": false,
                    "sort": false,
                    // "order": [ 2, "asc" ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv',
                        {
                            extend: 'excel',
                            title: 'v Report Of {!! json_encode($date ?? '') !!}',
                            messageTop: 'Name: {!! json_encode($sale_officer_name ?? '') !!}',
                        },
                        {
                            extend: 'pdf',
                            title: 'Order Report of {!! json_encode($date ?? '') !!}',
                            messageTop: ' Name: {!! json_encode($sale_officer_name ?? '') !!}',
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
                t.on('order.dt search.dt', function() {
                    t.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();
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
                        option.value = data.data[i].id;
                        option.text = data.data[i].name;
                        selectBranch.appendChild(option);
                    }
                });
            }
        </script>
    @endsection
