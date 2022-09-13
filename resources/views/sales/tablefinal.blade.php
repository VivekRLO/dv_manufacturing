<div class="table-responsive">
    <table class="table" >
        <thead>
            <tr>
                <th>S.N</th>
                <th>Sales To</th>
                <th>Sold At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $num=>$sale)
            <tr>
                <td>{{$num+1}}</td>
                <td></td>
                <td>{{ $sale->sold_at }}</td>
                <td width="120"> </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

