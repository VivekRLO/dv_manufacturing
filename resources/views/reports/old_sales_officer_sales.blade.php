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
                    <h1>MONTHLY SALE REPORT AND SUMMARY OF DAILY SALE REPORT</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <form action="{{ route('report.report_sales_officer') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>DSE:</label>
                                <select class="form-control search-dropdown-salesofficer" required="" name="sales_officer_id">
                                    <option value="" disabled selected>Choose DSE Name</option>
                                    @foreach ($sales_officers as $s_officer)
                                        <option value="{{ $s_officer->id }}">{{ $s_officer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Month:</label>
                                <select class="form-control" required name="month">
                                    @php
                                        $number = Carbon\carbon::now()->format('m');
                                    @endphp
                                    <option value="" disabled selected>Choose Month</option>
                                    <option value="01" @if ($number == '01') selected @endif>January</option>
                                    <option value="02" @if ($number == '02') selected @endif>February</option>
                                    <option value="03" @if ($number == '03') selected @endif>March</option>
                                    <option value="04" @if ($number == '04') selected @endif>April</option>
                                    <option value="05" @if ($number == '05') selected @endif>May</option>
                                    <option value="06" @if ($number == '06') selected @endif>June</option>
                                    <option value="07" @if ($number == '07') selected @endif>July</option>
                                    <option value="08" @if ($number == '08') selected @endif>August</option>
                                    <option value="09" @if ($number == '09') selected @endif>September</option>
                                    <option value="10" @if ($number == '10') selected @endif>October</option>
                                    <option value="11" @if ($number == '11') selected @endif>November</option>
                                    <option value="12" @if ($number == '12') selected @endif>December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <label>Year:</label>
                            <div class="form-group">
                                <select class="form-control" required name="year">
                                    <option value="" disabled selected>Choose Year</option>
                                    <option value="2021" selected>2021</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-1" style=" padding-top: 25px;">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <div class="clearfix"></div>
        @if (isset($data))
            <div class="row">
                <h4>Name of DSE:{{ $data['sales_officer']->name }}</h4>
                <hr>
                <h4>Date:{{ $data['date'] }}</h4>

            </div>

        @endif

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    {{-- <table  id="sales-table" class="display nowrap" style="width:100%"> --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                @for ($i = 1; $i <= Carbon\Carbon::now()->daysInMonth; $i++)
                                    <th>{{ $i }}</th>
                                @endfor
                                <th>Total Qty</th>
                                <th>Unit Price</th>
                                <th>Total Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                foreach ($products as $key => $product) {
                                    $total = 0;
                                    $temp = [];
                                    echo ' <tr>';
                                    echo '<td>' . App\Models\Product::find($key)->name . '</td>';
                                    $y = 1;
                                    foreach ($product as $product_sale) {
                                        for ($i = $y; $i <= Carbon\Carbon::now()->daysInMonth; $i++) {
                                            if ((int) date('d', strtotime($product_sale->date)) == $i) {
                                                $temp[$i] = $product_sale->sum;
                                                $total += $product_sale->sum;
                                                $y = $i + 1;
                                            } else {
                                                // echo '<td>-</td>';
                                            }
                                        }
                                        // echo '<td>' . $product_sale->sum . '</td>';
                                    }
                                    for ($j = 1; $j <= Carbon\Carbon::now()->daysInMonth; $j++) {
                                        if (isset($temp[$j])) {
                                            echo '<td>' . $temp[$j] . '</td>';
                                        } else {
                                            echo '<td>-</td>';
                                        }
                                    }
                                    echo '<td>' . $total . '</td>';
                                    echo '<td>-</td>';
                                    echo '<td>-</td>';
                                    echo '</tr>';
                                }
                            @endphp

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('third_party_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".search-dropdown-salesofficer").select2();
        });
    </script>

    

@endsection