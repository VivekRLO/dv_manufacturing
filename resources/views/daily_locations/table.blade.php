<div class="table-responsive">
    <table class="table" id="dailyLocations-table">
        <thead>
            <tr>
                <th>User Id</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Date</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyLocations as $dailyLocation)
                <tr>
                    <td>{{ $dailyLocation->user_id }}</td>
                    <td>{{ $dailyLocation->longitude }}</td>
                    <td>{{ $dailyLocation->latitude }}</td>
                    <td>{{ $dailyLocation->date }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['dailyLocations.destroy', $dailyLocation->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('dailyLocations.show', [$dailyLocation->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                        @if(Auth::user()->role == 0)

                            <a href="{{ route('dailyLocations.edit', [$dailyLocation->id]) }}"
                                class='btn btn-default btn-xs'>
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
