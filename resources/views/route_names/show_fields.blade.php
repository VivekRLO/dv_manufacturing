<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $routeName->id }}</p>
</div>

<!-- Routename Field -->
<div class="col-sm-12">
    {!! Form::label('routename', 'Routename:') !!}
    <p>{{ $routeName->routename }}</p>
</div>

<!-- Distributor Id Field -->
<div class="col-sm-12">
    {!! Form::label('distributor_id', 'Distributor Id:') !!}
    <p>{{ $routeName->distributor_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $routeName->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $routeName->updated_at }}</p>
</div>

