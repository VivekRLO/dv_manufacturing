{{-- {{dd($permission)}} --}}
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Permission Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required'=>'required']) !!}
</div>

<!-- Guard Name Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('guard_name', 'Guard Name:') !!}
    {!! Form::text('guard_name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div> --}}