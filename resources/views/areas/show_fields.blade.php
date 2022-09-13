<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $area->id }}</p>
</div>

<!-- District Id Field -->
<div class="col-sm-12">
    {!! Form::label('district_id', 'District :') !!}
    <p>{{ $area->district->name }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $area->name }}</p>
</div>

