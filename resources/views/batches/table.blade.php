<div class="table-responsive">
    <table class="table" id="batches-table">
        <thead>
            <tr>
                <th>Product Id</th>
                <th>Expired At</th>
                <th>Manufactured At</th>
                <th>Stock Remaining</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($batches as $batch)
                <tr>
                    <td>{{ $batch->product->name }}</td>
                    <td>{{ $batch->expired_at }}</td>
                    <td>{{ $batch->manufactured_at }}</td>
                    <td>{{ $batch->stock }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['batches.destroy', $batch->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('batch_stock_history',$batch->id) }}"
                                class='btn btn-default btn-xs'>
                                <i class="fas fa-truck"></i>
                            </a>
                            {{-- <a href="{{ route('batches.show', [$batch->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a> --}}
                        @if(Auth::user()->role == 0)

                            <a href="{{ route('batches.edit', [$batch->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            @endif
                            {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
