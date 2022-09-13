<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $stockHistory->id }}</p>
</div>

<!-- Distributor Id Field -->
<div class="col-sm-12">
    {!! Form::label('distributor_id', 'Distributor Id:') !!}
    <p>{{ $stockHistory->distributor_id }}</p>
</div>

<!-- Batch Id Field -->
<div class="col-sm-12">
    {!! Form::label('batch_id', 'Batch Id:') !!}
    <p>{{ $stockHistory->batch_id }}</p>
</div>

<!-- Product Id Field -->
<div class="col-sm-12">
    {!! Form::label('product_id', 'Product Id:') !!}
    <p>{{ $stockHistory->product_id }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $stockHistory->price }}</p>
</div>

<!-- Total  Stock Remaining In Distributor Field -->
<div class="col-sm-12">
    {!! Form::label('total_stock_remaining_in_distributor', 'Total  Stock Remaining In Distributor:') !!}
    <p>{{ $stockHistory->total_stock_remaining_in_distributor }}</p>
</div>

<!-- Stock In Field -->
<div class="col-sm-12">
    {!! Form::label('stock_in', 'Stock In:') !!}
    <p>{{ $stockHistory->stock_in }}</p>
</div>

<!-- Stock Out Field -->
<div class="col-sm-12">
    {!! Form::label('stock_out', 'Stock Out:') !!}
    <p>{{ $stockHistory->stock_out }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $stockHistory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $stockHistory->updated_at }}</p>
</div>

