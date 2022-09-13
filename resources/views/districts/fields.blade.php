<!-- Province Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('province_id', 'Province Id:') !!}
    {!! Form::select('province_id',$provinces, null, ['class' => 'form-control' ,'required'=>'required']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required'=>'required']) !!}
</div>