<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $district->id }}</p>
</div>

<!-- Province Id Field -->
<div class="col-sm-12">
    {!! Form::label('province_id', 'Province :') !!}
    <p>{{ $district->province->name }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $district->name }}</p>
</div>

