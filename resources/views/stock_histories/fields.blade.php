<!-- Distributor Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distributor_id', 'Distributor Id:') !!}
    {!! Form::number('distributor_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Batch Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('batch_id', 'Batch Id:') !!}
    {!! Form::number('batch_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product Id:') !!}
    {!! Form::text('product_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Total  Stock Remaining In Distributor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_stock_remaining_in_distributor', 'Total  Stock Remaining In Distributor:') !!}
    {!! Form::number('total_stock_remaining_in_distributor', null, ['class' => 'form-control']) !!}
</div>

<!-- Stock In Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stock_in', 'Stock In:') !!}
    {!! Form::number('stock_in', null, ['class' => 'form-control']) !!}
</div>

<!-- Stock Out Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stock_out', 'Stock Out:') !!}
    {!! Form::number('stock_out', null, ['class' => 'form-control']) !!}
</div>