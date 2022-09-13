<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $street->id }}</p>
</div>

<!-- Area Id Field -->
<div class="col-sm-12">
    {!! Form::label('area_id', 'Area :') !!}
    <p>{{ $street->area->name }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $street->name }}</p>
</div>

