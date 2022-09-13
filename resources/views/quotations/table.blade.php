
<div class="table-responsive">
    <table class="table" id="quotation-table">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Month</th>
                <th>Total Target</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
                @php
                    $i = 1;
                @endphp
            @foreach ($quotations as $key => $quotation)
                <tr>
                    <td>{{ $i++ }}</td>
                    {{-- <td>{{ $quotation->users->name }}</td>
                    @php
                        $distributors = DB::table('distributor_user')->where('user_id', $quotation->user_id)->first();
                        if($distributors){
                            $distributors = App\Models\Distributor::find($distributors->distributor_id)->name;
                        }
                    @endphp
                    <td>{{ $distributors??'-' }}</td> --}}
                    <td>{{ $key }}</td>
                    @php
                    $tvalue = 0;
                    foreach($quotation as $value){
                        $tvalue = $tvalue + (int) $value->value;
                    }
                    // dd($quotation[0]->month);
                    @endphp
                    <td>{{ $tvalue }}</td>
                    <td width="120">
                        <div class='btn-group'>
                            
                            {{-- {!! Form::open(['route' => ['quotation.destroy', $quotation->id], 'method' => 'delete']) !!} --}}
                                @if (Auth::user()->role == 0)
                                    <a href="{{ route('quotation.dse_view', [$quotation[0]->month]) }}" class='btn btn-default btn-xs'>
                                        <i class="far fa-eye"></i>
                                    </a>
                                @endif
                                @if (Auth::user()->role==0)
                                    {{-- @if($user->flag==0) --}}
                                        {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                                    {{-- @endif --}}
                                @endif
                            {{-- {!! Form::close() !!} --}}
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
                lengthChange: false,
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
            table.buttons().container()
                .appendTo( $('div.eight.column:eq(0)', table.table().container()) );
        });
    </script>

@endsection