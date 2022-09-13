@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"> 
                    <h1>{{$batch->product->name}}</h1>
                </div>
                <div class="col-sm-8">

                    <div class="card-body">
                        {!! Form::open(['route' => 'stockHistories.store']) !!}
                        <div class="row">

                            <!-- Distributor Id Field -->
                            <div class="form-group col-sm-3">
                                {!! Form::label('distributor_id', 'Distributor:') !!}
                                {!! Form::select('distributor_id', App\Models\Distributor::pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="price">Price:</label>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="quantity">Quantity:</label>
                                <input type="number" class="form-control" name="quantity" max="{{$batch->stock}}" required>
                            </div>
                            <input type="hidden" class="form-control" name="batch_id" value="{{ $batch->id }}"
                                required>
                            <input type="hidden" class="form-control" name="product_id" value="{{ $batch->product_id }}"
                                required>
                            <div class="form-group col-sm-3">
                                {!! Form::submit('Disptach', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>


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
                    <table class="table" id="stockHistories-table">
                        <thead>
                            <tr>
                                <th>Distributor Id</th>
                                {{-- <th>Batch Id</th>
                                <th>Product Id</th> --}}
                                <th>Price</th>
                                <th>Stock Remaining In Dist</th>
                                <th>Dispatch Date</th>
                                {{-- <>Stock In</>
                                <th>Stock Out</th> --}}
                                {{-- <th colspan="3">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockHistories as $stockHistory)
                                <tr>
                                    <td>{{ $stockHistory->distributor->name }}</td>
                                    {{-- <td>{{ $stockHistory->batch_id }}</td>
                                    <td>{{ $stockHistory->product_id }}</td> --}}
                                    <td>{{ $stockHistory->price }}</td>
                                    <td>{{ $stockHistory->total_stock_remaining_in_distributor }}</td>
                                    <td>{{ $stockHistory->created_at }}</td>
                                    {{-- <td>{{ $stockHistory->stock_in }}</td>
                                    <td>{{ $stockHistory->stock_out }}</td> --}}
                                    {{-- <td width="120">
                                        {!! Form::open(['route' => ['stockHistories.destroy', $stockHistory->id], 'method' => 'delete']) !!}
                                        <div class='btn-group'>
                                            <a href="{{ route('stockHistories.show', [$stockHistory->id]) }}"
                                                class='btn btn-default btn-xs'>
                                                <i class="far fa-eye"></i>
                                            </a>
                                            @if(Auth::user()->role == 0)
                                             <a href="{{ route('stockHistories.edit', [$stockHistory->id]) }}"
                                                class='btn btn-default btn-xs'>
                                                <i class="far fa-edit"></i>
                                            </a>
                                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                            @endif
                                        </div>
                                        {!! Form::close() !!}
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $stockHistories])
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
