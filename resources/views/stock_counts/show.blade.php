@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stock Count Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('stockCounts.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    {{-- @include('stock_counts.show_fields') --}}
                </div>
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
                                <th>Closing Stock</th>
                            </tr>

                            @php
                                $purchases = json_decode($stockCount['Purchases'][0]->stock, true);
                                $closing = json_decode($stockCount['Closing'][0]->stock, true);
                            @endphp
                            @foreach (json_decode($stockCount['Opening'][0]->stock) as $key => $quantity)
                                <tr>
                                    @php
                                        $opening = $quantity;
                                        $purc = $purchases[$key];
                                        $total = (int) $opening + (int) $purc;
                                    @endphp
                                    <td>{{ $key }}</td>
                                    <td>{{ \App\Models\Product::find($key)->name }}</td>
                                    <td>{{ $opening }}</td>
                                    <td>{{ $purc }}</td>
                                    <td>{{ $total }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $closing[$key] }}</td>
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
@endsection
