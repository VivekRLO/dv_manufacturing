<div class="table-responsive">
    <table class="table" id="saleReturns-table">
        <thead>
            <tr>
                {{-- <th>Distributor Id</th>
                <th>Batch Id</th> --}}
                <th>S.N</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Return Date</th>
                <th>Remarks</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
         @php
            $i= ($saleReturns->perPage() * ($saleReturns->currentPage() - 1)) + 1;
         @endphp
            @foreach($saleReturns as $saleReturn)
            <tr>
                {{-- <td>{{ $saleReturn->distributor_id }}</td>
                <td>{{ $saleReturn->batch_id }}</td> --}}
                <td>{{ $i}}</td>
                <td>{{ $saleReturn->product->name }}</td>
                <td>{{ $saleReturn->quantity }}</td>
                <td>{{ $saleReturn->returndate }}</td>
                <td>{{ $saleReturn->remarks }}</td>
                <td width="120">
                    {{-- {!! Form::open(['route' => ['saleReturns.destroy', $saleReturn->id], 'method' => 'delete']) !!} --}}
                    <div class='btn-group'>
                        <a href="{{ route('saleReturns.show', [$saleReturn->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if(Auth::user()->role == 0)
                        <a href="{{ route('saleReturns.edit', [$saleReturn->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                        @endif
                    </div>
                    {{-- {!! Form::close() !!} --}}
                </td>
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
