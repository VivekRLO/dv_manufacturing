<div class="table-responsive">
    <table class="table" id="monthlyTours-table">
        <thead>
            <tr>
                <th>Staff</th>
                <th>Distributor</th>
                <th>Route</th>
                <th>Timestamp</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($monthlyTours as $monthlyTour)
            <tr>
                <td>{{ $monthlyTour->user->name }}</td>
                <td>{{ $monthlyTour->year }}</td>
                <td>{{ $monthlyTour->month }}</td>
                <td>{{ $monthlyTour->created_at }}</td>
                {{-- <td width="120">
                    {!! Form::open(['route' => ['monthlyTours.destroy', $monthlyTour->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('monthlyTours.show', [$monthlyTour->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('monthlyTours.edit', [$monthlyTour->id]) }}" class='btn btn-default btn-xs'>
                        <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                     {!! Form::close() !!} 
                </td>--}}
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
        $('#monthlyTours-table').DataTable();
    });

</script>

@endsection
