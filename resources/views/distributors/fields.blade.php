<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Contact Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contact', 'Contact:') !!}
    {!! Form::number('contact', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location', 'Address:') !!}
    {!! Form::text('location', null, ['class' => 'form-control']) !!}
</div>

<!-- Owner Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('owner_name', 'Owner Name:') !!}
    {!! Form::text('owner_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Pan No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pan_no', 'Pan No:') !!}
    {!! Form::text('pan_no', null, ['class' => 'form-control']) !!}
</div>

<!-- Zone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone', 'Zone:') !!}
    {!! Form::select('zone_id',$zones, null, ['class' => 'form-control']) !!}
</div>
<!-- Zone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('town', 'Town:') !!}
    {!! Form::select('town_id',$towns, null, ['class' => 'form-control']) !!}
</div>
<!-- regionalmanager Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regionalmanager', 'Regional Manager :') !!}
    {!! Form::select('regionalmanager',$regionalmanager, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('sales_supervisor_id', 'Sales Officer :') !!}
    {!! Form::select('sales_supervisor_id',$sales_supervisor, null, ['class' => 'form-control']) !!}
</div>

<!-- sales_officer_id Field -->
<div class="form-group col-sm-6" >
    {!! Form::label('sales_officer_id', 'DSE:') !!}
    {{-- {!! Form::select('sales_officer_id[]',$sales_officer_id, null, ['class' => 'form-control','id'=>'framework','multiple']) !!} --}}
    <select id="framework" name="sales_officer_id[]" multiple class="form-control">
        @foreach ($sales_officer_id as $key=>$value)
            {{-- {{ dd($value) }} --}}

            <option value="{{ $key }}" @if (isset($existing_sales_officer)) <?php echo in_array($key, $existing_sales_officer->toarray()) ? 'selected' : ''; ?> @endif>
                {{ $value }}</option>
        @endforeach
    </select>
</div>

{{-- <!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
</div> --}}
@section('third_party_scripts')
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <script>
        $(document).ready(function() {

            $('#framework').multiselect({
                nonSelectedText: 'Select DSE',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonWidth: '100%',
               
            });
        });
    </script>
@endsection
