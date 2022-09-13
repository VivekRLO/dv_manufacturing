<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $town->id }}</p>
</div>

<!-- Town Field -->
<div class="col-sm-12">
    {!! Form::label('town', 'Town:') !!}
    <p>{{ $town->town }}</p>
</div>

<!-- Zone Id Field -->
<div class="col-sm-12">
    {!! Form::label('zone_id', 'Zone Id:') !!}
    <p>{{ $town->zone_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $town->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $town->updated_at }}</p>
</div>

