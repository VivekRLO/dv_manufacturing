<div class="table-responsive">
    <table  class="table" style="width:100%">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Sales To</th>
                <th>Sales Officer</th>
                {{-- <th>Distributor </th>   --}}
                <th>Outlet</th>
                <th>Product </th>
                <th>Quantity</th>
                <th>Discount</th>
                <th>Scheme</th>
                <th>Sold At</th>
                {{-- <th colspan="3">Action</th>  --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $num=>$sale)
                <tr>
                    <td>{{$num+1}}</td>
                    <td>{{$sale->sold_to}}</td>
                    <td>{{ $sale->user->name??''}}</td>
                    {{-- <td>{{ $sale->distributor->name??"" }}</td> --}}
                    <td>{{ $sale->outlet->name??""}}</td>
                    <td>{{ $sale->product->name??"" }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->discount }}</td>
                    <td>{{ $sale->scheme }}</td>
                    <td>{{ $sale->sold_at }}</td>
                    {{-- <td width="120">
                        {!! Form::open(['route' => ['sales.destroy', $sale->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('sales.show', [$sale->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                             @if(Auth::user()->role == 0)
                             <a href="{{ route('sales.edit', [$sale->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@section('third_party_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
       $(document).ready(function() {
    $('#sales-table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        
        "pageLength": 50
        
    } );
} );
    </script>

@endsection