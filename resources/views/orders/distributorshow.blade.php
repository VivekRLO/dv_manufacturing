@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('orders.distributorwise') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
       <!-- Id Field -->
       <div class="row">
        <!-- Order Id Field -->
        <div class="col-sm-6">
            {!! Form::label('order_id', 'Order Id:') !!}
            <p>{{ $order->order_id }}</p>
        </div>
        
        <!-- Distributor Id Field -->
        <div class="col-sm-6">
            {!! Form::label('distributor_id', 'Distributor:') !!}
            <p>{{ $order->distributor->name }}</p>
        </div>
        
        <!-- Status Field -->
        <div class="col-sm-6">
            {!! Form::label('status', 'Status:') !!}
            <p>{{ $order->status }}</p>
        </div>
        
        <!-- Created At Field -->
        <div class="col-sm-6">
            {!! Form::label('created_at', 'Applied Date:') !!}
            <p>{{ $order->created_at }}</p>
        </div>

       </div>



        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                          <thead>
                          <tr>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                          </tr>
                          @foreach (json_decode($order->quantity) as $key=>$quantity)
                              <tr>
                                  <td>{{$key}}</td>
                                  <td>{{\App\Models\Product::find($key)->name}}</td>
                                  <td>{{$quantity}}</td>
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
        
    </div>
@endsection
