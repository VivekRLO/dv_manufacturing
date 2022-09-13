<div class="table-responsive">
    <table class="table" id="routeNames-table">
        <thead>
            <tr>
                <th>Route ID</th>
                <th>Routename</th>
                <th>Distributor</th>
                <th>DSE</th>
                <th>Outlet Count</th>
                <th >Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($routeNames as $routeName)
            <tr>
                <td>{{ $routeName->id }}</td>
                <td>{{ $routeName->routename }}</td>
                <td>{{ $routeName->distributor->name }}</td>
                <td>
                    @php
                    if($routeName->route_users->count() > 1){
                        foreach($routeName->route_users as $user){
                            echo '<li style="list-style:none !important">'.$user->name.'</li>';
                        }
                    }else{
                        echo $routeName->route_users[0]->name??"";
                    }
                    @endphp
                </td>
                <td>
                    <a href="{{ route('routeNames.outlet_list', $routeName->id) }}">
                        {{$routeName->outlets->where('flag', 0)->count()}}
                    </a>
                </td>
                <td >
                    <div class='btn-group'>
                        {{-- <a href="{{ route('routeName.show', [$routeName->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a> --}}
                        {!! Form::open(['route' => ['routeName.destroy', $routeName->id], 'method' => 'delete']) !!}
                        <a href="{{ route('routeNames.outlet_map_plot', [$routeName->id]) }}" class='btn btn-default btn-xs'>
                            <i class="fas fa-map-marker-alt"></i>
                        </a>
                        @if(Auth::user()->role == 0)
                            <a href="{{ route('routeName.edit', [$routeName->id]) }}" class='btn btn-warning btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                        
                                {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endif
                    </div>
                    {!! Form::close() !!}
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

            $('#routeNames-table').DataTable({
                "paging": true,
                "info": true,
                "sort": true,
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',
                    {
                        extend: 'excel',
                        title: 'RouteName with DSE and Outlet Count',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3, 4]
                        }

                    },
                    {
                        extend: 'pdf',
                        title: 'RouteName with DSE and Outlet Count',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3, 4]
                        }

                    }
                ]
            });
        });
 
    </script>

    

@endsection