<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $dailyLocation->id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $dailyLocation->user_id }}</p>
</div>

<!-- Longitude Field -->
<div class="col-sm-12">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{{ $dailyLocation->longitude }}</p>
</div>

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{{ $dailyLocation->latitude }}</p>
</div>
<!-- outlet Field -->
<div class="col-sm-12">
    {!! Form::label('outlet', 'outlet:') !!}
    <p>{{ $dailyLocation->outlet_id }}</p>
</div>
<!-- Date Field -->
<div class="col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $dailyLocation->date }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $dailyLocation->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $dailyLocation->updated_at }}</p>
</div>

