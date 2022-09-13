<div class="table-responsive">
    <table class="table" id="streets-table">
        <thead>
            <tr>
                <th>Area </th>
        <th>Name</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($streets as $street)
            <tr>
                <td>{{ $street->area->name }}</td>
            <td>{{ $street->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['streets.destroy', $street->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('streets.show', [$street->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if(Auth::user()->role == 0)
                        <a href="{{ route('streets.edit', [$street->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
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
