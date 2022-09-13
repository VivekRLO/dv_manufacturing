<div class="table-responsive">
    <table class="table" id="banks-table">
        <thead>
            <tr>
                <th>Bank Name</th>
        <th>Bank Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($banks as $bank)
            <tr>
                <td>{{ $bank->bank_name }}</td>
            <td>{{ $bank->bank_code }}</td>
                <td width="120">
                    {{-- {!! Form::open(['route' => ['banks.destroy', $bank->id], 'method' => 'delete']) !!} --}}
                    <div class='btn-group'>
                        <a href="{{ route('banks.show', [$bank->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if(Auth::user()->role == 0)

                        <a href="{{ route('banks.edit', [$bank->id]) }}" class='btn btn-default btn-xs'>
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
