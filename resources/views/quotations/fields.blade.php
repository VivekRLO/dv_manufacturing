
@section('third_party_stylesheets')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

@endsection

<div class="row">
    <!-- Target Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('user_id', 'DSE:') !!}
        @if(isset($quotation))
            {!! Form::select('user_id', $users, $quotation->user_id, ['class' => 'form-control']) !!}
        @else
            {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
        @endif
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('month', 'Month:') !!}
        <input type="text" class="form-control" name="month" id="quote_datepicker" @if(isset($quotation)) value="{{ $quotation->month }}" @endif autocomplete="off" />
    </div>
</div>
<div class="row">
    <!-- quotation Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('value', 'Quotation (monthly):') !!}
         @if(isset($quotation))
            {!! Form::number('value', $quotation->value, ['class' => 'form-control', 'required'=>'required', 'min' => 0]) !!}
        @else
            {!! Form::number('value', null, ['class' => 'form-control', 'required'=>'required', 'min' => 0]) !!}
        @endif
    </div>
</div>

@section('third_party_scripts')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $("#quote_datepicker").datepicker( {
        format: "M-yyyy",
        startView: "months", 
        minViewMode: "months"
    });
</script>
@endsection