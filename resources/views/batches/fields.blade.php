<!-- Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_id', 'Product Id:') !!}
    {!! Form::select('product_id',App\Models\Product::where('flag',0)->pluck('name','id'),null, ['class' => 'form-control']) !!}
</div>

<!-- Expired At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('expired_at', 'Expired At:') !!}
    {!! Form::text('expired_at', null, ['class' => 'form-control','id'=>'expired_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#expired_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Manufactured At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('manufactured_at', 'Manufactured At:') !!}
    {!! Form::text('manufactured_at', null, ['class' => 'form-control','id'=>'manufactured_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#manufactured_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Stock Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stock', 'Stock:') !!}
    {!! Form::number('stock', null, ['class' => 'form-control']) !!}
</div>