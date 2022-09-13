<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $batch->id }}</p>
</div>

<!-- Product Id Field -->
<div class="col-sm-12">
    {!! Form::label('product_id', 'Product Id:') !!}
    <p>{{ $batch->product_id }}</p>
</div>

<!-- Expired At Field -->
<div class="col-sm-12">
    {!! Form::label('expired_at', 'Expired At:') !!}
    <p>{{ $batch->expired_at }}</p>
</div>

<!-- Manufactured At Field -->
<div class="col-sm-12">
    {!! Form::label('manufactured_at', 'Manufactured At:') !!}
    <p>{{ $batch->manufactured_at }}</p>
</div>

<!-- Stock Field -->
<div class="col-sm-12">
    {!! Form::label('stock', 'Stock:') !!}
    <p>{{ $batch->stock }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $batch->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $batch->updated_at }}</p>
</div>

