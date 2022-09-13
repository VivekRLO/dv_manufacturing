<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $role->id }}</p>
</div>

<!-- Role Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'Role Name:') !!}
    <p>{{ $role->name }}</p>
</div>

<div class="col-sm-12">
    {!! Form::label('permission_name', 'Permission List:') !!}
    @foreach ($role->permissions as $permission)
        <p>{{ $permission->name }}</p>
    @endforeach
</div>
