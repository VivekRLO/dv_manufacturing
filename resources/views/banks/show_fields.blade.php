<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $bank->id }}</p>
</div>

<!-- Bank Name Field -->
<div class="col-sm-12">
    {!! Form::label('bank_name', 'Bank Name:') !!}
    <p>{{ $bank->bank_name }}</p>
</div>

<!-- Bank Code Field -->
<div class="col-sm-12">
    {!! Form::label('bank_code', 'Bank Code:') !!}
    <p>{{ $bank->bank_code }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $bank->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $bank->updated_at }}</p>
</div>

