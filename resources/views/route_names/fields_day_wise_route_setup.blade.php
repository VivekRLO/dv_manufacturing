<!-- User Field -->
<div class="form-group col-sm-12">
    {!! Form::text('user_id', $user->id, ['class' => 'form-control', 'required'=>'required', 'readonly', 'hidden']) !!}
</div>

<!-- Day Field -->
<div class="form-group col-sm-2">
    {!! Form::label('day', 'Day:') !!}
    {!! Form::text('day[0]', $days[0], ['class' => 'form-control', 'required'=>'required', 'readonly']) !!}
</div>

<!-- Routename Field -->
<div class="form-group col-sm-10">
    {!! Form::label('routename', 'Route Name:') !!}       
    <select name="routename[0]" class="form-control">
        <option value=""> No Route for the Day</option>
        @foreach ($routes as $route)
            <option 
            @if(isset($route_data)) @if($route->id == $route_data[0]->route_id) selected @endif @endif
             value = "{{ $route->id }}">{{ $route->routename }}
            </option>
        @endforeach
    </select>
</div>

<!-- Day Field -->
<div class="form-group col-sm-2">
    {!! Form::label('day', 'Day:') !!}
    {!! Form::text('day[1]', $days[1], ['class' => 'form-control', 'required'=>'required', 'readonly']) !!}
</div>

<!-- Routename Field -->
<div class="form-group col-sm-10">
    {!! Form::label('routename', 'Route Name:') !!}
    <select name="routename[1]" class="form-control">
        <option value=""> No Route for the Day</option>
        @foreach ($routes as $route)
            <option 
            @if(isset($route_data)) @if($route->id == $route_data[1]->route_id) selected @endif @endif
             value = "{{ $route->id }}">{{ $route->routename }}
            </option>
        @endforeach
    </select>
</div>

<!-- Day Field -->
<div class="form-group col-sm-2">
    {!! Form::label('day', 'Day:') !!}
    {!! Form::text('day[2]', $days[2], ['class' => 'form-control', 'required'=>'required', 'readonly']) !!}
</div>

<!-- Routename Field -->
<div class="form-group col-sm-10">
    {!! Form::label('routename', 'Route Name:') !!}
    <select name="routename[2]" class="form-control">
        <option value=""> No Route for the Day</option>
        @foreach ($routes as $route)
            <option 
            @if(isset($route_data)) @if($route->id == $route_data[2]->route_id) selected @endif @endif
             value = "{{ $route->id }}">{{ $route->routename }}
            </option>
        @endforeach
    </select>
</div>

<!-- Day Field -->
<div class="form-group col-sm-2">
    {!! Form::label('day', 'Day:') !!}
    {!! Form::text('day[3]', $days[3], ['class' => 'form-control', 'required'=>'required', 'readonly']) !!}
</div>

<!-- Routename Field -->
<div class="form-group col-sm-10">
    {!! Form::label('routename', 'Route Name:') !!}
    <select name="routename[3]" class="form-control">
        <option value=""> No Route for the Day</option>
        @foreach ($routes as $route)
            <option 
            @if(isset($route_data)) @if($route->id == $route_data[3]->route_id) selected @endif @endif
             value = "{{ $route->id }}">{{ $route->routename }}
            </option>
        @endforeach
    </select>
</div>

<!-- Day Field -->
<div class="form-group col-sm-2">
    {!! Form::label('day', 'Day:') !!}
    {!! Form::text('day[4]', $days[4], ['class' => 'form-control', 'required'=>'required', 'readonly']) !!}
</div>

<!-- Routename Field -->
<div class="form-group col-sm-10">
    {!! Form::label('routename', 'Route Name:') !!}
    <select name="routename[4]" class="form-control">
        <option value=""> No Route for the Day</option>
        @foreach ($routes as $route)
            <option 
            @if(isset($route_data)) @if($route->id == $route_data[4]->route_id) selected @endif @endif
             value = "{{ $route->id }}">{{ $route->routename }}
            </option>
        @endforeach
    </select>
</div>

<!-- Day Field -->
<div class="form-group col-sm-2">
    {!! Form::label('day', 'Day:') !!}
    {!! Form::text('day[5]', $days[5], ['class' => 'form-control', 'required'=>'required', 'readonly']) !!}
</div>

<!-- Routename Field -->
<div class="form-group col-sm-10">
    {!! Form::label('routename', 'Route Name:') !!}
    <select name="routename[5]" class="form-control">
        <option value=""> No Route for the Day</option>
        @foreach ($routes as $route)
            <option 
            @if(isset($route_data)) @if($route->id == $route_data[5]->route_id) selected @endif @endif
             value = "{{ $route->id }}">{{ $route->routename }}
            </option>
        @endforeach
    </select>
</div>

<!-- Day Field -->
<div class="form-group col-sm-2">
    {!! Form::label('day', 'Day:') !!}
    {!! Form::text('day[6]', $days[6], ['class' => 'form-control', 'required'=>'required', 'readonly']) !!}
</div>

<!-- Routename Field -->
<div class="form-group col-sm-10">
    {!! Form::label('routename', 'Route Name:') !!}
    <select name="routename[6]" class="form-control">
        <option value=""> No Route for the Day</option>
        @foreach ($routes as $route)
            <option 
            @if(isset($route_data)) @if($route->id == $route_data[6]->route_id) selected @endif @endif
             value = "{{ $route->id }}">{{ $route->routename }}
            </option>
        @endforeach
    </select>
</div>
