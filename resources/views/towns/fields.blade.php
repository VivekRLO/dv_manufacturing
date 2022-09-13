<!-- Town Field -->
<div class="form-group col-sm-6">
    {!! Form::label('town', 'Town:') !!}
    {!! Form::text('town', null, ['class' => 'form-control']) !!}
</div>

<!-- Zone Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone_id', 'Zone:') !!}
    {!! Form::select('zone_id',$zones, null, ['class' => 'form-control']) !!}
</div>