<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $channel->id }}</p>
</div>

<!-- Channel Field -->
<div class="col-sm-12">
    {!! Form::label('channel', 'Channel:') !!}
    <p>{{ $channel->channel }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $channel->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $channel->updated_at }}</p>
</div>

