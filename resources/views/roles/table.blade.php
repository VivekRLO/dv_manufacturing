<div class="table-responsive">
    <table class="table" id="roles-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Users Count</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{  $role->users->count() }}</td>
                    <td width="120">
                        {{-- {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!} --}}
                        <div class='btn-group'>
                            <a href="{{ route('roles.show', [$role->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            @if(Auth::user()->role == 0)
                            <a href="{{ route('roles.edit', [$role->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            @endif
                            {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                        </div>
                        {{-- {!! Form::close() !!} --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>