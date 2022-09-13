<div class="table-responsive">
    <table class="table" id="collections-table">
        <thead>
            <tr>
                <th>Distributor</th>
                <th>Mode</th>
                <th>Bank Name</th>
                <th>Cheque No</th>
                <th>Cheque Photo</th>
                <th>Amount</th>
                <th>Sales Officer</th>
                <th>Account Of</th>
                <th>Remarks</th>
                <th>Device Time</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($collections as $collection)
                <tr>
                    <td>{{ $collection->distributor->name }}</td>
                    <td>{{ $collection->mode }}</td>
                    <td>{{ $collection->bank_name }}</td>
                    <td>{{ $collection->cheque_no }}</td>
                    <td>
                          @if($collection->cheque_photo)
                    <a href="{{asset("public/".$collection->cheque_photo)}}" target="popup" onclick="window.open('{{asset("public/".$collection->cheque_photo)}}','popup','width=600,height=600'); return false;">
                        Show image
                    </a>
                    @else
                            Not found
                        @endif
                    </td>
                    <td>{{ $collection->amount }}</td>
                    <td>{{ $collection->salesOfficer->name ?? '' }}</td>
                    <td>{{ $collection->account_of }}</td>
                    <td>{{ $collection->remarks }}</td>
                    <td>{{ $collection->device_time ?? ''}}</td>
                    {{-- <td width="120">
                        {!! Form::open(['route' => ['collections.destroy', $collection->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('collections.show', [$collection->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                        @if(Auth::user()->role == 0)

                             <a href="{{ route('collections.edit', [$collection->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a> 
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            @endif
                        </div>
                        {!! Form::close() !!}
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
