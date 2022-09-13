<!-- Stock Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stock', 'Stock:') !!}
    {!! Form::text('stock', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::text('date', null, ['class' => 'form-control']) !!}
</div>

<!-- Sale Officer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sale_officer_id', 'Sale Officer Id:') !!}
    {!! Form::number('sale_officer_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Distributor Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distributor_id', 'Distributor Id:') !!}
    {!! Form::number('distributor_id', null, ['class' => 'form-control']) !!}
</div>