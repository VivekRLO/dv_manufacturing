<style>
    .dataTables_filter{
        display: none;
    }
    </style>
<!-- Sold To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sold_to', 'Sold To:') !!}
    {!! Form::text('sold_to', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Sold At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sold_at', 'Sold At:') !!}
    {!! Form::text('sold_at', null, ['class' => 'form-control','id'=>'sold_at','required'=>'required']) !!}
</div>
@push('page_scripts')
    <script type="text/javascript">
        $('#sold_at').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<div class="table-responsive">
    <table class="table" id="distributor-sales-table">
        <thead>
            <tr>
                <th>Product Id</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Discount</th>
          <th>Scheme</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key=>$product)
            <tr>
                <td>{{$key}}</td>
                <td>{{$product}}</td>
                <td><input type="number" name="quantity[{{$key}}]" class="form-control" value="0"></td>
                <td><input type="number" name="discount[{{$key}}]" class="form-control" value="0"></td>
                <td><input type="text" name="scheme[{{$key}}]" class="form-control"  placeholder="Ex. (10+1)"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@section('third_party_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <script>
 
$(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#distributor-sales-table thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#distributor-sales-table thead');
 
    var table = $('#distributor-sales-table').DataTable({
     
        orderCellsTop: true,
        fixedHeader: true,
        "bPaginate": false,

        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },

    });
});
    </script>

@endsection
{{-- <div class="row"> 
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Product Id</th>
          <th>Product Name</th>
          <th>Quantity</th>
        </tr>
    </thead>
     
       
        <tbody>
            @foreach ($products as $key=>$product)
            <tr>
                <td>{{$key}}</td>
                <td>{{$product}}</td>
                <td><input type="number" name="quantity[{{$key}}]" class="form-control" value="0"></td>
            </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div> --}}
  