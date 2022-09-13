<div class="table-responsive">
    <table class="table" id="towns-table">
        <thead>
            <tr>
                <th>Town Id</th>
                <th>Town</th>
        <th>Zone </th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($towns as $town)
            <tr>
                <td>{{ $town->id }}</td>
                <td>{{ $town->town }}</td>
            <td>{{ $town->zone->zone }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['towns.destroy', $town->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('towns.show', [$town->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if(Auth::user()->role == 0)
                        <a href="{{ route('towns.edit', [$town->id]) }}" class='btn btn-default btn-xs'>
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
