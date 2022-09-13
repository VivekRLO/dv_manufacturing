<div class="table-responsive">
    <table class="table" id="appVersions-table">
        <thead>
            <tr>
                <th>Version</th>
        <th>Url</th>
        <th>Remarks</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($appVersions as $appVersion)
            <tr>
                <td>{{ $appVersion->version }}</td>
            <td>{{ $appVersion->link }}</td>
            <td>{{ $appVersion->remarks }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['appVersions.destroy', $appVersion->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('appVersions.show', [$appVersion->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if(Auth::user()->role == 0)
                        <a href="{{ route('appVersions.edit', [$appVersion->id]) }}" class='btn btn-default btn-xs'>
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
