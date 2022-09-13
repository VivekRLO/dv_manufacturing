
<div class="table-responsive">
    <table class="table" id="quotation-table">
        <thead>
            <tr>
                <th>S.N</th>
                <th>DSE</th>
                <th>Distributor</th>
                <th>Target</th>
                <th>Achieved</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
                @php
                    $i = 1;
                @endphp
            @foreach ($quotations as $quotation)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $quotation->users->name }}</td>
                    @php
                        $distributors = DB::table('distributor_user')->where('user_id', $quotation->user_id)->first();
                        if($distributors){
                            $distributors = App\Models\Distributor::find($distributors->distributor_id)->name;
                        }
                    @endphp
                    <td>{{ $distributors??'-' }}</td>
                    <td>{{ $quotation->value }}</td>
                    <td>{{ $quotation->achieved??'-' }}</td>
                    <td width="120">
                        <div class='btn-group'>
                            {!! Form::open(['route' => ['quotation.destroy', $quotation->id], 'method' => 'delete']) !!}
                                @if (Auth::user()->role == 0)
                                    <a href="{{ route('quotation.edit', [$quotation->id]) }}" class='btn btn-default btn-xs'>
                                        <i class="far fa-edit"></i>
                                    </a>
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                @endif
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@section('third_party_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {


            var table = $('#quotation-table').DataTable({
                "paging": true,
                "info": true,
                "sort": true,
                "pageLength": 50,
                dom: 'Bfrtip',
                order: [[ 0, 'asc' ]],
                buttons: [
                    'copy', 'csv',
                    {
                        extend: 'excel',
                        title: 'Dv Trading (Target Tables)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3, 4]
                        }

                    },
                    {
                        extend: 'pdf',
                        title: 'Dv Trading (Target Tables)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3, 4]
                        }

                    },
                ]
            });
        });
    </script>

@endsection