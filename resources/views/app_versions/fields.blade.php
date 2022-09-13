<!-- Version Field -->
<div class="form-group col-sm-6">
    {!! Form::label('version', 'Version:') !!}
    {!! Form::number('version', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file', 'File:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('file', ['class' => 'custom-file-input','accept'=>'.apk', 'required' => 'required']) !!}
            {!! Form::label('file', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>

<!-- Remarks Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remarks', 'Remarks:') !!}
    {!! Form::text('remarks', null, ['class' => 'form-control']) !!}
</div>