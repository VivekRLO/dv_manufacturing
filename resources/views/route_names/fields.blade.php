<!-- Routename Field -->
<div class="form-group col-sm-6">
    {!! Form::label('routename', 'Route Name:') !!}
    {!! Form::text('routename', null, ['class' => 'form-control', 'required'=>'required']) !!}
</div>

<!-- Distributor Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distributor_id', 'Distributor:') !!}
    {!! Form::select('distributor_id',$distributors, null, ['class' => 'form-control', 'required'=>'required']) !!}
</div>

<!-- Outlet Id Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('outlet_id', 'Outlet:') !!}
    
    <select id="framework" name="outlet_id" multiple class="form-control">
        @foreach ($outlets as $key=>$value)
        
        <option value="{{ $value->id }}">
            {{ $value->name }}
        </option>
        @endforeach
    </select>
</div> --}}
{{-- {{ dd(array_keys($outlets->toArray())) }} --}}
{{-- {!! Form::select('outlet_id',$outlets, null, [ 'id' => 'example-getting-started', 'class' => 'form-control', 'required'=>'required', 'multiple'=> true]) !!} --}}

{{-- @section('third_party_scripts')
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <script type="text/javascript">
        $(document).ready(function() {
            $('#framework').multiselect();
        });
    </script>

@endsection --}}