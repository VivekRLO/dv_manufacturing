<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $stockCount->id }}</p>
</div>

<!-- Stock Field -->
<div class="col-sm-12">
    {!! Form::label('stock', 'Stock:') !!}
    <p>{{ $stockCount->stock }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $stockCount->type }}</p>
</div>

<!-- Date Field -->
<div class="col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $stockCount->date }}</p>
</div>

<!-- Sale Officer Id Field -->
<div class="col-sm-12">
    {!! Form::label('sale_officer_id', 'Sale Officer Id:') !!}
    <p>{{ $stockCount->sale_officer_id }}</p>
</div>

<!-- Distributor Id Field -->
<div class="col-sm-12">
    {!! Form::label('distributor_id', 'Distributor Id:') !!}
    <p>{{ $stockCount->distributor_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $stockCount->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $stockCount->updated_at }}</p>
</div>

