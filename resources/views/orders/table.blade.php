<div class="table-responsive">
    <table class="table" id="orders-table">
        <thead>
            <tr>
                <th>Order Id</th>
                <th>Distributor</th>
                <th>Date</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_id }}</td>
            <td>{{ $order->distributor->name??""}}</td>
            <td>{{ $order->created_at->format('Y-M-d') }}</td>
            <td>{{ $order->status }}</td>
                <td width="120">
                    {{-- {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!} --}}
                    <div class='btn-group'>
                        <a href="{{ route('orders.show', [$order->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        {{-- <a href="{{ route('orders.edit', [$order->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {{-- {!! Form::close() !!} --}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
