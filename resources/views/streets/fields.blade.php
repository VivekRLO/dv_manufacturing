<!-- Area Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area_id', 'Area Id:') !!}
    {!! Form::select('area_id',$areas, null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required'=>'required']) !!}
</div>