@section('third_party_stylesheets')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<div class="table-responsive">
    <table class="table" id="outlets-table">
        <thead>
            <tr>

                {{-- <th>Image</th>
                <th>Location </th>
                <th>Contact</th>
                <th>Type</th> --}}
                <th></th>
                <th>Outlet Id</th>
                <th>Name</th>
                <th>Zone</th>
                <th>Town</th>
                <th>Route</th>
                <th>Distributor</th>
                {{-- <th>Channel</th> --}}
                {{-- <th>Category</th> --}}
                <th>DSE</th>
                {{-- <th>Sales Supervisor</th> --}}
                {{-- <th>Regional Manager</th> --}}
                <th>Visit Frequency</th>
                <th>Created At</th>
                <th>Location</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($outlets as $outlet)
                <tr>
                    <td></td>
                    <td>{{ $outlet->id }}</td>
                    <td>{{ $outlet->name }}</td>
                    <td>{{ $outlet->towns->zone->zone??"" }}</td>
                    <td>{{ $outlet->towns->town??"" }}</td>
                    <td>{{ $outlet->routenames->routename??""}}</td>
                    <td>{{ $outlet->distributor->name??"" }}</td>
                    <td>{{ $outlet->user->name ?? '' }}</td>
                    <td>{{ $outlet->visit_frequency ?? '' }}</td>
                    <td>{{ $outlet->created_at ?? '' }}</td>
                    <td><a target="_blank" href="https://www.google.com/search?q={{ $outlet->latitude?? '' }},{{ $outlet->longitude ?? '' }}">{{ $outlet->latitude?? '' }} {{ $outlet->longitude ?? '' }}</a></td>
                    <td>

                      @if($outlet->image)
                        <a target="_blank" href="{{ $outlet->image }}">
                            <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                        </a> 
                       {{-- <img src="data:image/png/jpeg;base64,{{ $outlet->image }}"alt="" srcset="" width="100px" height="auto"> --}}
                      
                        {{-- <a href="data:image/png/jpeg;base64, {{ $outlet->image }}" target="popup" onclick="window.open('popup','width=600,height=600').document.write(new image(this.href)); return false;">
                            Show image
                        </a> --}}
                        @else
                            Not found
                        @endif
                    </td>
                    <td>
                        {!! Form::open(['route' => ['outlets.destroy', $outlet->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('outlets.show', [$outlet->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            @if(Auth::user()->role == 0)
                            <a href="{{ route('outlets.edit', [$outlet->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>

                            {{-- <a href="{{ route('outlets.destroy', [$outlet->id]) }}" class='btn btn-danger btn-xs'>
                                <i class="far fa-trash-alt"></i>
                            </a> --}}
                            {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
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
    var table = $('#outlets-table').DataTable({
        "paging": false,
        "info": false,
        "sort": true,
        "pageLength": 50,
        columnDefs: [ {
            "orderable": false,
            "className": 'select-checkbox',
            "targets": 0
        } ],
        select: {
            "style":    'os',
            "selector": 'td:first-child'
        },
        order: [[ 1, 'asc' ]],
        dom: 'Bfrtip',
        buttons: [
            {
                text: '<i class="far fa-copy"></i>',
                extend: 'copy',
            },
            {
                text: '<i class="fas fa-file-csv"></i>',
                extend: 'csv',
            },
            {
                text: '<i class="far fa-file-excel"></i>',
                extend: 'excel',
                title: 'DV Trading (Outlets Details)',
                messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                exportOptions: {
                columns: [0, 1, 2, 3, 4,5, 6, 7, 8, 9, 10, 11 ]
                }

            },
            {
                text: '<i class="far fa-file-pdf"></i>',
                extend: 'pdf',
                title: 'DV Trading (Outlets Details)',
                messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                exportOptions: {
                columns: [0, 1, 2, 3, 4,5, 6, 7, 8, 9, 10, 11 ]
                }

            },
            {
                text: '<i class="fa fa-trash-alt"></i>',
                class: 'btn btn-danger',
                action: function ( e, dt, type, indexes ) {
                    e.preventDefault();
                    var rowData = table.rows( { selected: true } ).data().toArray();
                    var count = table.rows( { selected: true } ).count();
                    var erase = confirm("Do you want to delete all?");
                    if(erase){
                        for (let i = 0; i < count; i++) {
                            console.log(rowData[i][1]);
                            var url = "{{ route('outlets.flagupdate', 'id') }}";
                            url = url.replace('id', rowData[i][1]);
                            console.log(url);
                            // $.ajaxSetup({
                            //     headers: {
                            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            //         'Content-Type': 'application/json',
                            //     }
                            // });
                            $.ajax({
                                    url: url,
                                    type: 'GET',
                                    cache: false,
                                    
                                    success: function(dataResult){
                                        dataResult = JSON.parse(dataResult);
                                        if(dataResult.statusCode)
                                        {
                                            // window.location = "/users";
                                            location.reload();
                                        }
                                        else{
                                            console.log(dataResult.statusCode);
                                            location.reload();
                                        }
                                    }
                            });
                        }
                    }
                }
            }
        ],
    });

    table
        .on( 'select', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            var rowData = table.rows( indexes ).data().toArray();
        } );
} );
</script>
    
@endsection