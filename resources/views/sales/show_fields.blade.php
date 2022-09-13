<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $sale->id }}</p>
</div>

<!-- Sales Officer Id Field -->
<div class="col-sm-12">
    {!! Form::label('sales_officer_id', 'Sales Officer Id:') !!}
    <p>{{ $sale->users->name}}</p>
</div>

<!-- Distributor Id Field -->
<div class="col-sm-12">
    {!! Form::label('distributor_id', 'Distributor Id:') !!}
    <p>{{ $sale->distributor->name}}</p>
</div>

<!-- Batch Id Field -->
<div class="col-sm-12">
    {!! Form::label('batch_id', 'Batch Id:') !!}
    <p>{{ $sale->batch_id }}</p>
</div>

<!-- Product Id Field -->
<div class="col-sm-12">
    {!! Form::label('product_id', 'Product Id:') !!}
    <p>{{ $sale->product->name }}</p>
</div>

<!-- Quantity Field -->
<div class="col-sm-12">
    {!! Form::label('quantity', 'Quantity:') !!}
    <p>{{ $sale->quantity }}</p>
</div>

<!-- Sold At Field -->
<div class="col-sm-12">
    {!! Form::label('sold_at', 'Sold At:') !!}
    <p>{{ $sale->sold_at }}</p>
</div>

