<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $appVersion->id }}</p>
</div>

<!-- Version Field -->
<div class="col-sm-12">
    {!! Form::label('version', 'Version:') !!}
    <p>{{ $appVersion->version }}</p>
</div>

<!-- Url Field -->
<div class="col-sm-12">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $appVersion->url }}</p>
</div>

<!-- Remarks Field -->
<div class="col-sm-12">
    {!! Form::label('remarks', 'Remarks:') !!}
    <p>{{ $appVersion->remarks }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $appVersion->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $appVersion->updated_at }}</p>
</div>

