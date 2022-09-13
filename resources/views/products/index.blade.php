@extends('layouts.app')

@section('content')
    <div class="content p-3">

        

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Products</h3>
                </div>
                @if (Auth::user()->role == 0)
                    <a class="btn btn-primary" href="{{ route('products.bulk_create') }}">
                        Bulk Add
                    </a>
                    <a class="btn btn-primary ml-2" href="{{ route('products.create') }}">
                        Add New
                    </a>
                @endif
            </div>
        </div>
        @include('flash::message')

        {{-- Filter Option Start --}}
        <ul class="navbar-nav ml-auto mb-1">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="btn btn-primary nav-link dropdown-toggle text-white" style="width: 135px;" data-toggle="dropdown">
                    <i class="fa fa-filter" aria-hidden="true">Filter Option</i>
                </a>
                <ul class="dropdown-menu dropdown-menu-left" style="width: 25% !important; padding:5px">
                    <form action="{{ route('product.product_filter') }}" method="POST">
                        @csrf
                        <li class="user-header" style="text-align: left!important; ">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    {!! Form::label('mrp_from', 'MRP From:') !!}
                                    {!! Form::number('mrp_from', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-sm-6">
                                    {!! Form::label('mrp_to', 'MRP To:') !!}
                                    {!! Form::number('mrp_to', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-12">
                                    {!! Form::label('name', 'Name:') !!}
                                    {{-- {!! Form::select('name',[], null, ['class' => 'form-control','id'=>'filtername']) !!} --}}
                                    <select name="filtername" id="filtername" class="form-control">
                                        <option value="" disabled selected>Choose Option</option>
                                        @foreach ($brands_name as $brand)
                                            <option value="{{ $brand }}">{{ $brand }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success"><i class="fa fa-filter"
                                    aria-hidden="true">Filter</i> </button>

                    </form>
                </ul>
            </li>
        </ul>


        {{-- Filter option END --}}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('products.table')
                    <div class="card-footer clearfix float-right">
                        <div class="float-right">
                            @include('adminlte-templates::common.paginate', ['records' => $products])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
