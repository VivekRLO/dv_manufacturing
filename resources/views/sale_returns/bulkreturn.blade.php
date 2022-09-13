@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Bulk Sale Return</h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('adminlte-templates::common.errors')

    <div class="card">

        {!! Form::open(['route' => 'saleReturns.store_bulksalereturn']) !!}
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Return Quantity</th>
                                <th>Remarks</th>
                            </tr>

                            @foreach ($products as $key=>$product)
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$product}}</td>
                                <td><input type="number" name="returnquantity[{{$key}}]" class="form-control" value="0"></td>
                                <td><input type="text" name="remarks[{{$key}}]" class="form-control"></td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>


        </div>

        <div class="card-footer">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('saleReturns.index') }}" class="btn btn-default">Cancel</a>
        </div>

        {!! Form::close() !!}

    </div>
</div>
@endsection
