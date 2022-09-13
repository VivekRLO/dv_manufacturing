<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<!-- brand name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('brand_name', 'Brand Name:') !!}
    {!! Form::text('brand_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit', 'Unit:') !!}
    {!! Form::text('unit', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::number('value', null, ['class' => 'form-control', 'min' => '0']) !!}
</div>

<!-- Mrp Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('mrp', 'MRP:') !!}
    {!! Form::number('mrp', null, ['class' => 'form-control', 'min' => '0']) !!}
</div> --}}

<!-- Qty Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control', 'min' => '0']) !!}
</div> --}}

<!-- PC Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('product_code', 'Product Code:') !!}
    {!! Form::number('product_code', null, ['class' => 'form-control', 'min' => '0']) !!}
</div> --}}

<!-- Rlp Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('rlp', 'RLP:') !!}
    {!! Form::number('rlp', null, ['class' => 'form-control', 'min' => '0']) !!}
</div> --}}

<!-- Dlp Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('dlp', 'DLP:') !!}
    {!! Form::number('dlp', null, ['class' => 'form-control', 'min' => '0']) !!}
</div> --}}

<!-- Catalog Field -->
<div class="form-group col-sm-6">
    {!! Form::label('catalog', 'Catalog:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('catalog', ['class' => 'custom-file-input']) !!}
            {!! Form::label('catalog', 'Choose file', ['class' => 'custom-file-label', 'required' => 'required']) !!}
        </div>
    </div>
</div>