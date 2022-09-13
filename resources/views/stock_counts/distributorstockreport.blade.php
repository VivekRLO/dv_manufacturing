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
                    <h1>Stock Report Of Distributor : {{ $distributor->name }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <form action="{{ route('search-stockreport-distributor') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>Distributor:</label>
                                <select name="distributor" id="distributor" class="form-control search-dropdown-dist" onchange="getdate(value)"
                                    required>
                                    <option value="" disabled selected>Choose Distributor Name</option>
                                    @foreach ($distributors as $key => $distributor)
                                    <option value="{{$key}}">{{$distributor}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                               <input type="hidden" name="distributor" id="distributor" value="{{ $distributor->id }}">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Date from:</label>
                                <select class="form-control" required name="date_from" id='date_from'
                                    onchange="gettodate(value)">
                                    <option value="" disabled selected>Choose Opening Stock date</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label>Date To:</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="date_to" id="date_to" readonly>
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


    </div>
    @isset($stockCount)
        <div class="content px-3">
            <div class="card">
                <div class="row" style="margin:15px;">
                    <!-- Order Id Field -->
                    <div class="col-sm-4">
                        {!! Form::label('distributor', 'Distributor:') !!}
                        <p>{{ $stockCount['Opening'][0]->distributor->name }}</p>
                    </div>

                    <!-- Distributor Id Field -->
                    <div class="col-sm-4">
                        {!! Form::label('from_date', 'Opening Stock Date:') !!}
                        <p>{{ $input['date_from'] }}</p>
                    </div>

                    <!-- Status Field -->
                    <div class="col-sm-4">
                        {!! Form::label('closing', 'Closing Stock Date:') !!}
                        <p>{{ $input['date_to'] }}</p>
                    </div>

                </div>
                <div class="card-body">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Id</th>
                                    <th>Product Name</th>
                                    <th>Opening Stock</th>
                                    <th>Purchase Stock</th>
                                    <th>Total Stock</th>
                                    <th>Sales by SO</th>
                                    <th>Sales by Distributor</th>
                                    <th>Sales return</th>
                                    <th>Closing Stock</th>
                                </tr>

                                @php
                                    if (isset($stockCount['Purchases'])) {
                                        $purchases = json_decode($stockCount['Purchases'][0]->stock, true);
                                    }
                                    $closing = json_decode($stockCount['Closing'][sizeof($stockCount['Closing'])-1]->stock, true);
                                    
                                @endphp
                                @foreach (json_decode($stockCount['Opening'][0]->stock) as $key => $quantity)
                                    <tr>
                                        @php
                                            $opening = $quantity;
                                            $purc = $purchases[$key] ?? 0;
                                            $total = (int) $opening + (int) $purc;
                                        @endphp
                                        <td>{{ $key }}</td>
                                        <td>{{ \App\Models\Product::find($key)->name }}</td>
                                        <td>{{ $opening }}</td>
                                        <td>{{ $purc }}</td>
                                        <td>{{ $total }}</td>
                                        <td>{{ $salesarray[$key] ?? 0 }}</td>
                                        <td>{{ $distributorsalesarray[$key]??0 }}</td>
                                        <td>{{ $salesreturnarray[$key]??0}}</td>
                                        <td>{{ $closing[$key]??0 }}</td>
                                    </tr>
                                @endforeach

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    @endisset


@endsection
@section('third_party_scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script type="text/javascript">
        var myValue;
        (function() {
                $(".search-dropdown-dist").select2();
                var value=document.getElementById('distributor').value;
            select = document.getElementById('date_from');
                    select.options.length = 1;
                    const url = {!! '"' . url('api/get-date?distributor_id=') . '"' !!} + value;
                    $.get(url, function(data, status) {
                        var jsonParsedArray = JSON.parse(data);
                        myValue = jsonParsedArray;
                        for (key in jsonParsedArray) {
                            if (jsonParsedArray.hasOwnProperty(key)) {
                                var option = document.createElement("option");
                                option.value = key;
                                option.text = key;
                                select.appendChild(option);
                            }
                            
                        }
                        if(jsonParsedArray.length === 0){
                            console.log('kali xa ho kehi xaina ...');
                                var option = document.createElement("option");
                                option.value ="No record Found";
                                option.text = "No record Found";
                                select.appendChild(option);
                        }

                    });
            })();

        function gettodate(value) {
            var inputF = document.getElementById("date_to");
            console.log(value);
            if(value=="No record Found"){
                inputF.setAttribute('value', value);
            } else {
                inputF.setAttribute('value', window.myValue[value]);
            }
            
        }
    </script>

@endsection
