<div class="table-responsive">
    <table class="table" id="">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Brand Name</th>
                <th>Catalogue</th>
                <th>Unit</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $products->firstItem() + $loop->index }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->brand_name }}</td>
                <td>
                    @if($product->catalog)
                    <a href="{{asset($product->catalog)}}" target="popup" onclick="window.open('{{asset($product->catalog)}}','popup','width=600,height=600'); return false;">
                        Show image
                    </a>
                    {{-- <img src="{{asset($product->catalog)}}" alt="Image not Found" width="200px" height="100px"> --}}
                    @endif
                </td> 
                <td>{{ $product->unit }}</td>
                <td>{{ $product->value }}</td>  
                <td width="120">
                    {{-- {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!} --}}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('products.show', [$product->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a> --}}
                        @if(Auth::user()->role == 0)

                        <a href="{{ route('products.edit', [$product->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endif
                        {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn
                        btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {{-- {!! Form::close() !!} --}}
                </td>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#my-products').DataTable({
                "paging": true,
                "info": true,
                "sort": true,
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',
                    {
                        extend: 'excel',
                        title: 'DV Trading (Product List)',
                        messageTop: 'Product List Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3, 4, 5]
                        }

                    },
                    {
                        extend: 'pdf',
                        title: 'DV Trading (Product List)',
                        messageTop: 'Product List Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3, 4, 5]
                        }

                    }
                ]
            });
        });
    </script>

@endsection