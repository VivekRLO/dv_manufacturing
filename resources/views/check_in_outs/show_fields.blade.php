<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $checkInOut->id }}</p>
</div>

<!-- Sales Officer Id Field -->
<div class="col-sm-12">
    {!! Form::label('sales_officer_id', 'Sales Officer Id:') !!}
    <p>{{ $checkInOut->sales_officer_id }}</p>
</div>

<!-- Check Type Field -->
<div class="col-sm-12">
    {!! Form::label('check_type', 'Check Type:') !!}
    <p>{{ $checkInOut->check_type }}</p>
</div>

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{{ $checkInOut->latitude }}</p>
</div>

<!-- Longitude Field -->
<div class="col-sm-12">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{{ $checkInOut->longitude }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $checkInOut->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $checkInOut->updated_at }}</p>
</div>

