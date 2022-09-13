<div class="table-responsive">
    <table class="table" id="checkInOuts-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Sales Officer</th>
                <th>Check In Time</th>
                <th>Check Out Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($checkInOuts as $checkInOut)
                <tr>
                    <td>{{Illuminate\Support\Str::substr($checkInOut->checkin_device_time,0,10) }}</td>
                    <td>{{ $checkInOut->salesOfficer->name }}</td>
                    {{-- <td>@if(isset($checkInOut->checkin_device_time)) IN @endif @if(isset($checkInOut->checkout_device_time)) / OUT @endif</td> --}}
                    {{-- <td><a target="blank"
                        href="https://maps.google.com/?q={{ $checkInOut->latitude }},{{ $checkInOut->longitude }}">
                        {{ $checkInOut->latitude }},{{ $checkInOut->longitude }}</a></td> --}}
                    <td>{{Illuminate\Support\Str::substr($checkInOut->checkin_device_time,10) }}</td>
                    <td>{{ Illuminate\Support\Str::substr($checkInOut->checkout_device_time,10) }}</td>
                    <td>
                        <div class='btn-group'>
                            <a href="{{ route('checkinout.map_report', [$checkInOut->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="fas fa-map-marker-alt"></i>
                            </a>
                            
                        </div>
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

            $('#checkInOuts-table').DataTable({
                "paging": false,
                "info": true,
                "sort": true,
                "order": [[0, "desc"]],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',
                    {
                        extend: 'excel',
                        title: 'Dv Trading (Check In Outs Tables)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3]
                        }

                    },
                    {
                        extend: 'pdf',
                        title: 'Dv Trading (Check In Outs Tables)',
                        messageTop: 'Report Generate on {!! json_encode(Carbon\CArbon::now()->format('Y-m-d H:i:s')) !!}',
                        exportOptions: {
                         columns: [0, 1, 2, 3]
                        }

                    }
                ]
            });
        });
    </script>

@endsection
