@extends('layouts.app')

@section('content')
<style>
    .dot {
      height: 25px;
      width: 25px;
      
      border-radius: 50%;
      display: inline-block;
    }
    </style>
    
    <div class="content p-3">

        @include('flash::message')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Outlets</h3>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row table-responsive">
                    <table class="table" id="outlets-dash-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Distributor</th>
                                <th>Order Party</th>       
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($outlets as $outlet)
                                <tr>
                                    <td>{{ $outlet->name }}</td>
                                    <td>{{ $outlet->distributor->name??"" }}</td>
                                    <td>
                                        @php
                                        $salesroute=App\Models\Sale::where('outlet_id',$outlet->id)->whereDate('created_at',Carbon\Carbon::now())->get();
                                        if(empty($salesroute->toarray())){
                                            echo '<span class="dot" style="background-color: red;"></span>';
                                        }else{
                                            echo '<span class="dot" style="background-color: green;"></span>';
                                           
                                        }
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $outlets])
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('third_party_scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    var table = $('#outlets-dash-table').DataTable({
        "paging": false,
        "info": false,
        "sort": true,
        "pageLength": 50,
        order: [[ 2, 'asc' ]],
    });
} );
</script>

@endsection
