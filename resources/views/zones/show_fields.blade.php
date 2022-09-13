<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $zone->id }}</p>
</div>

<!-- Zone Field -->
<div class="col-sm-12">
    {!! Form::label('zone', 'Zone:') !!}
    <p>{{ $zone->zone }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $zone->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $zone->updated_at }}</p>
</div>

