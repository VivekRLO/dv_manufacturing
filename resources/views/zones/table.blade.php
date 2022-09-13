<div class="table-responsive">
    <table class="table" id="zones-table">
        <thead>
            <tr>
                <th>Zone ID</th>
                <th>Zone</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($zones as $zone)
            <tr>
                <td>{{ $zone->id }}</td>
                <td>{{ $zone->zone }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['zones.destroy', $zone->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('zones.show', [$zone->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if(Auth::user()->role == 0)
                        <a href="{{ route('zones.edit', [$zone->id]) }}" class='btn btn-default btn-xs'>
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
