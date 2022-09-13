<div class="table-responsive">
    <table class="table" id="stockHistories-table">
        <thead>
            <tr>
                <th>Distributor </th>
                <th>Batch Id</th>
                <th>Product </th>
                <th>Price</th>
                <th>Dist Stock</th>
                <th>Stock In</th>
                <th>Stock Out</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($stockHistories as $stockHistory)
                <tr>
                    <td>{{ $stockHistory->distributor->name }}</td>
                    <td>{{ $stockHistory->batch_id }}</td>
                    <td>{{ $stockHistory->product->name }}</td>
                    <td>{{ $stockHistory->price }}</td>
                    <td>{{ $stockHistory->total_stock_remaining_in_distributor}}</td>
                    <td>{{ $stockHistory->stock_in }}</td>
                    <td>{{ $stockHistory->stock_out }}</td>
                    <td width="120">
                        {{-- {!! Form::open(['route' => ['stockHistories.destroy', $stockHistory->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('stockHistories.show', [$stockHistory->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                             @if(Auth::user()->role == 0)
                             <a href="{{ route('stockHistories.edit', [$stockHistory->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                            {{-- @endif --}}
                        </div>
                        {{-- {!! Form::close() !!} --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
