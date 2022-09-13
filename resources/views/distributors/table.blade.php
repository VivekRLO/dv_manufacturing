<div class="table-responsive">
    <table class="table" id="distributors-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Owner Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Location</th>
                <th>Zone</th>
                <th>Town</th>
                {{-- <th>Latitude</th>
                <th>Longitude</th> --}}
                <th>Regional Manager</th>
                <th>Sales Officer</th>
                <th>DSE</th>

                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($distributors as $distributor)
                <tr>
                    <td>{{ $distributor->name }}</td>
                    <td>{{ $distributor->owner_name??'-' }}</td>
                    <td>{{ $distributor->email }}</td>
                    <td>{{ $distributor->contact }}</td>
                    <td>{{ $distributor->location }}</td>
                    <td>{{ $distributor->zones->zone??"" }}</td>
                    <td>{{ $distributor->towns->town??"" }}</td>
                    {{-- <td>{{ $distributor->latitude }}</td>
                    <td>{{ $distributor->longitude }}</td> --}}
                    <td>{{$distributor->rm->name ?? ''}}</td>
                    <td>{{$distributor->ss->name ?? ''}}</td>
                    <td>
                     {{-- @php
                    $sale_officers= \App\Models\Outlet::where('distributor_id',$distributor->id)->distinct('sales_officer_id')->pluck('sales_officer_id')->toarray();

                    if(!empty($sale_officers)){
                    foreach ($sale_officers as $dse){
                        $username=\App\Models\User::find($dse)->name;
                    echo "<li><div class='btn-group'>". $username ."</div></li>";
                    }

                    }
                    @endphp --}}
                    @foreach ($distributor->distributor_salesOfficer as $ans)
                            <li>
                                <div class='btn-group'>
                                    {{-- {{ $ans->name }}  --}}
                                    <a  class="btn btn-link" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ $ans->name }}" data-distributor="{{ $distributor->id }}">{{ $ans->name }}</a>
                                </div>
                            </li>
                        @endforeach
                    </td>
                    <td width="120">
                        {{-- {!! Form::open(['route' => ['distributors.destroy', $distributor->id], 'method' => 'delete']) !!} --}}
                        <div class='btn-group'>
                            <a href="{{ route('distributors.show', [$distributor->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                        @if(Auth::user()->role == 0)
                            
                            <a href="{{ route('distributors.edit', [$distributor->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="{{ route('distributors.destroy', [$distributor->id]) }}"
                                class='btn btn-danger btn-xs'>
                                <i class="far fa-trash-alt"></i>
                            </a>
                            {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                        @endif
                        </div>
                        {{-- {!! Form::close() !!} --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Route Assign</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="dse_assign_form" action={{ route('dse_assign_route') }} method="POST">
            @csrf
        <div class="modal-body">
            
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">DSE:</label>
              <input type="text" class="form-control" id="recipient-name" name="dse_name" readonly>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Route Name:</label>
              <select class=" form-control" id="framework12" name="routelist[]"  multiple required>
                </select>
              
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" value="Assign" class="btn btn-primary" >
          </div>
        </form>

      </div>
    </div>
</div>



@section('third_party_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      var distributor = button.data('distributor') // Extract info from data-* attributes

      
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('Route Assign to ' + recipient)
      modal.find('.modal-body input').val(recipient)
      

        selectBranch12 = document.getElementById('framework12');
        selectBranch12.options.length = 0;
        const url = {!! '"' . url('api/get-data?distributor=') . '"' !!} + distributor;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var htm = '';
                htm += '<option value="'+data.data[i].id+'">' + data.data[i].routename + '</option>';
                $('#framework12').append(htm);
            }
        $('#framework12').multiselect('rebuild');  

        });
        const url2 = {!! '"' . url('api/get-data?route_user=') . '"' !!} + recipient;
        $.get(url2, function(data, status) {
            console.log(data.data.length);
            for (var i = 0; i < data.data.length; i++) {
                $('#framework12').multiselect('select', data.data[i].route_id); 
                console.log(data.data[i].route_id);
            }
        });
        
        $('#framework12').multiselect({
            nonSelectedText: 'Select Routes',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth: '100%',
            maxHeight: 450      
        });

    })
    </script>

@endsection