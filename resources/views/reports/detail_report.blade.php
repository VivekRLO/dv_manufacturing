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
                <div class="col-sm-12">
                    <h1>Detail Order Report</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')
        <form action="{{ route('report.single_detail_report') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-sm-4">
                    {!! Form::label('date', 'Select Date:') !!}
                    {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date', 'required' => 'required']) !!}
                </div>

                <div class="form-group col-sm-4">
                    {!! Form::label('sale_officer_id', 'DSE:') !!}
                    {!! Form::select('sale_officer_id', $sales_officers, null, ['class' => 'search-dropdown form-control', 'id' => 'sale_officer_id', 'required' => 'required','']) !!}
                </div>
                <div style=" padding-top: 25px;">
                    <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>

        </form>
        @if (isset($date) || isset($sale_officer_name))
            <div class="row">
                <h4>DSE : {{ $sale_officer_name ?? '' }}</h4>
                <hr>

                <h4> Date : {{ $date ?? '' }}</h4>

            </div>

        @endif

        <div class="clearfix"></div>
        @if (isset($datas))
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        {{-- <table  id="sales-table" class="display nowrap" style="width:100%"> --}}
                        <table class="table" id="detail-report-table" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Outlets</th>
                                    <th>Distributors</th>
                                    @foreach ($products as $product)
                                        <th>{{ $product }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    foreach ($datas as $key => $data) {
                                        $temp = [];
                                        echo ' <tr>';
                                        echo '<td>' . App\Models\Outlet::find($key)->name??"" . '</td>';
                                        echo '<td>' . App\Models\Distributor::find($data[0]->distributor_id)->name??"" . '</td>';
                                    
                                        foreach ($data as $item) {
                                            $temp[$item->product_id] = $item->sum;
                                        }
                                        foreach ($products as $key => $product) {
                                            if (isset($temp[$key])) {
                                                echo '<td>' . $temp[$key] . '</td>';
                                            } else {
                                                echo '<td>-</td>';
                                            }
                                        }
                                    
                                        echo '</tr>';
                                    }
                                @endphp
                            </tbody>
                        </table>
                    </div>

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


            $('#detail-report-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel'
                ],
                columnDefs: [{
                        orderable: true,
                        className: 'reorder',
                        targets: [0, 1]
                    },
                    {
                        orderable: false,
                        targets: '_all'
                    }
                ]
            });
        });
    </script>

@endsection
