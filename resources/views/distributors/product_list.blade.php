@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products List</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-default float-right" href="{{ route('home') }}">
                    Back
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table" id="products-table">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Brand Name</th>
                            <th>Catalog</th>
                            <th>Unit</th>
                            {{-- <th>Price</th> --}}
                            <th>Stock</th>
                            <th>Manufactured At</th>
                            <th>Expired At</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $key=>$product)
                        <tr>
                            <td>{{$product[sizeof($product)-1]->id}}</td>
                            <td>{{ $product[sizeof($product)-1]->name }}</td>
                            <td>{{ $product[sizeof($product)-1]->brand_name }}</td>
                            <td>
                                @if ($product[sizeof($product)-1]->catalog)
                                <img src="{{asset($product[sizeof($product)-1]->catalog??"")}}" alt="Image not Found" width="200px"
                                    height="100px">
                                @else
                                <p>-</p>
                                @endif
                            </td>
                            <td>{{ $product[sizeof($product)-1]->unit }}</td>
                            {{-- <td>{{ $product[sizeof($product)-1]->price }}</td> --}}
                           <td>{{$product[sizeof($product)-1]->total_stock_remaining_in_distributor}}</td>
                           <td>{{$product[sizeof($product)-1]->expired_at}}</td>
                           <td>{{$product[sizeof($product)-1]->manufactured_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix float-right">
                <div class="float-right">
                    {{-- @include('adminlte-templates::common.paginate', ['records' => $products]) --}}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('third_party_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
   
    <script>
       $(document).ready(function() {
    $('#products-table').DataTable( {
        "pageLength": 100
    } );
} );
    </script>

@endsection