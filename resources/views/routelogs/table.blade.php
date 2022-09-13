<div class="table-responsive">
    <table class="table" id="routelogs-table">
        <thead>
            <tr>
                <th>Staff</th>
                <th>Distributor</th>
                <th>Route</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($routelogs as $routelog)
            <tr>
                <td>{{ $routelog->dse->name ??""}}</td>
                <td>{{ $routelog->distributor->name??"" }}</td>
                <td>{{ $routelog->routename->routename??"" }}</td>
                <td>{{ $routelog->created_at }}</td>
               
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@section('third_party_scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#routelogs-table').DataTable();
    });

</script>

@endsection
