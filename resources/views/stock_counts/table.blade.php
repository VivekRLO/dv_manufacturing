<div class="table-responsive">
    <table class="table" id="stockCounts-table">
        <thead>
            <tr>
                <th>S.n</th>
        <th>Type</th>
        <th>Date</th>
        <th>Sale Officer Id</th>
        <th>Distributor Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $sn=1;    
            @endphp
        @foreach($stockCounts as $stockCount)
            <tr>
                <td>{{$sn}}</td>
            <td>{{ $stockCount->type }}</td>
            <td>{{ $stockCount->date }}</td>
            <td>{{ $stockCount->sale_officer_id }}</td>
            <td>{{ $stockCount->distributor_id }}</td>
                <td width="120">
                    {{-- {!! Form::open(['route' => ['stockCounts.destroy', $stockCount->id], 'method' => 'delete']) !!} --}}
                    <div class='btn-group'>
                        <a href="{{ route('stockCounts.show', [$stockCount->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if(Auth::user()->role == 0)
                        <a href="{{ route('stockCounts.edit', [$stockCount->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endif
                        {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {{-- {!! Form::close() !!} --}}
                </td>
            </tr>
            @php
             $sn++;   
            @endphp
        @endforeach
        </tbody>
    </table>
</div>
