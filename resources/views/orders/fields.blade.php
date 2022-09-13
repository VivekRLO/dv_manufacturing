
<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status',['Pending'=>'Pending','Accept'=>'Accept','Reject'=>'Reject'], null, ['class' => 'form-control']) !!}
</div>