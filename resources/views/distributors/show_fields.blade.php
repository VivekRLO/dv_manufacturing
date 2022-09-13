<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $distributor->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $distributor->name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $distributor->email }}</p>
</div>

<!-- Contact Field -->
<div class="col-sm-12">
    {!! Form::label('contact', 'Contact:') !!}
    <p>{{ $distributor->contact }}</p>
</div>

<!-- Pan Field -->
<div class="col-sm-12">
    {!! Form::label('pan_no', 'Pan Number:') !!}
    <p>{{ $distributor->pan_no }}</p>
</div>

<!-- Contact Field -->
{{-- <div class="col-sm-12">
    {!! Form::label('contact', 'Contact:') !!}
    <p>{{ $distributor->contact }}</p>
</div> --}}

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $distributor->location }}</p>
</div>

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{{ $distributor->latitude }}</p>
</div>

<!-- Longitude Field -->
<div class="col-sm-12">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{{ $distributor->longitude }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $distributor->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $distributor->updated_at }}</p>
</div>

