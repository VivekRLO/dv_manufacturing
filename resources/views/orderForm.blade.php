@extends('layouts.app')

@section('content')
    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

  <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order Form</h1>
            </div>
            <div class="col-sm-6">
              <a class="btn btn-default float-right"
                   href="{{ route('orders.distributorwise')}}">
                    Back
                </a>
                
                <button onClick="window.print()" class="btn btn-warning float-right" style="margin-right: 14px;"><i class="fa fa-print"></i> Print</button>
                
            </div>
        </div>
    </div>
</section>
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h4>
           DV Groups of Companies
          <small class="float-right"></small>
        </h4>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>{{$distributor->name}}</strong><br>
          {{$distributor->location}}<br>
          Phone: {{$distributor->contact}}<br>
          Email: {{$distributor->email??''}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Order ID:</b> {{$orderid}}<br>
        <b>Date: </b> {{$date}}
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
<form action="{{route('orders.store')}}" method="POST">
  @csrf
    <!-- Table row -->
    <input type="hidden" name="distributor_id" value="{{$distributor->id}}">
    <input type="hidden" name="order_id" value="{{$orderid}}">
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Quantity</th>
          </tr>
       
          @foreach ($products as $key=>$product)
              <tr>
                  <td>{{$key}}</td>
                  <td>{{$product}}</td>
                  <td><input type="number" name="quantity[{{$key}}]" class="form-control" value="0"></td>
              </tr>
          @endforeach
          </thead>
          <tbody>
          
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>


    <!-- this row will not appear when printing -->
    <div class="row no-print">
      
      <div class="col-12">
       
        <input type="submit" class="btn btn-primary float-right" style="margin-right: 5px;" value="Submit">
      </div>
    </div>
  </div>
</form>


@endsection
