<!-- Bank Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_name', 'Bank Name:') !!}
    {!! Form::text('bank_name', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Bank Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bank_code', 'Bank Code:') !!}
    {!! Form::text('bank_code', null, ['class' => 'form-control']) !!}
</div>