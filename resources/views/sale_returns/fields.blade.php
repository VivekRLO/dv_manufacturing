{{-- <!-- Distributor Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distributor_id', 'Distributor Id:') !!}
    {!! Form::text('distributor_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Batch Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('batch_id', 'Batch Id:') !!}
    {!! Form::text('batch_id', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product Name:') !!}
    {!! Form::select('product_id',$products, null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::text('quantity', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Returndate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('returndate', 'Return Date:') !!}
    {!! Form::text('returndate', null, ['class' => 'form-control','id'=>'returndate','required'=>'required']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#returndate').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Remarks Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remarks', 'Remarks:') !!}
    {!! Form::text('remarks', null, ['class' => 'form-control','required'=>'required']) !!}
</div>