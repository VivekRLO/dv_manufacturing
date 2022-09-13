
<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
            <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Sub D</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    @php
                        $distributors = DB::table('distributor_user')->where('user_id', $user->id)->first();
                        if($distributors){
                            $distributors = App\Models\Distributor::find($distributors->distributor_id)->name;
                        }
                    @endphp
                    <td>{{ $distributors??'-' }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @if($user->role==5)
                           DSE
                        @elseif($user->role==3)
                            Sales Officer
                        @elseif($user->role==4)
                            Regional Manager
                        @else
                            Distributor
                        @endif
                    </td>
                    <td width="120">
                        <div class='btn-group'>
                            {!! Form::open(['route' => ['user.destroy', $user->id], 'method' => 'delete']) !!}
                            <a href="{{ route('user.show', [$user->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                                @if (Auth::user()->role==0)
                                    <a href="{{ route('user.edit', [$user->id]) }}" class='btn btn-default btn-xs'>
                                        <i class="far fa-edit"></i>
                                    </a>
                                    @if ($user->role == 5)
                                        <a href="{{ route('user.day_wise_route_setup', [$user->id]) }}" class='btn btn-default btn-xs'>
                                            <i class="fa fa-route"></i>
                                        </a>
                                    @endif
                                @endif
                                {{-- @if (Auth::user()->role==0)
                                    @if($user->flag==0)
                                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                    @endif
                                @endif --}}
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

            var events = $('#events');

            var table = $('#users-table').DataTable({
                "paging": true,
                "info": true,
                "sort": true,
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',
                    {
                        extend: 'excel',
                        title: 'Dv Trading (User Tables)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3, 4]
                        }

                    },
                    {
                        extend: 'pdf',
                        title: 'Dv Trading (User Tables)',
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