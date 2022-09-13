<div class="col-6">
    <div class="card-body">
        <h4>Information</h4>
        <hr>
        <h5 class="title mb-3">{{ $outlet->name }} [ {{ $outlet->id }} ]</h5>
        <h6 class="subtitle mb-2 text-muted">
            @if ($outlet->address)
                {{ $outlet->address->province }}
                {{ $outlet->address->district }}
                {{ $outlet->address->local_level_en }}
                {{ $outlet->address->street }}
            @endif
        </h6>
        <h6 class="subtitle mb-2 text-muted">
            Location: <a href="https://maps.google.com/?q={{ $outlet->latitude??'' }},{{ $outlet->longitude??'' }}" class="card-link">{{ $outlet->latitude??'' }}, {{ $outlet->longitude??'' }}</a>
        </h6> 
        <h6 class="subtitle mb-2 text-muted">Phone: <a href="tel:00{{ $outlet->contact??'' }}" class="card-link">{{ $outlet->contact??'' }}</a></h6>
    </div>
</div>

<div class="col-6">
    <div class="card-body">
        <h4>Distibutor</h4>
        <hr>
        <h5 class="title"><a href="">{{ $outlet->distributor->name ?? '' }}</a></h5>
    </div>
    <div class="card-body">
        <h4>DSE</h4>
        <hr>
        <h5 class="title"><a href="">{{ App\Models\User::where('id', $outlet->sales_officer_id)->where('role', 5)->first()->name??'' }}</a></h5>
    </div>
</div>
<div class="col-12">
<hr>
    <div class="card-body">
        <h4>Orders of Month [{{ \Carbon\Carbon::now()->format('M Y') }}]</h4>
        <br>
        <table class="table">
            <tr>
                <th>S.N</th>
                <th>Date</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Discount</th>
                <th>Rate (Rs.)</th>
                <th>Total</th>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ($order_of_the_month as $order)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $order->sold_at }}</td>
                    @php
                        $product = App\Models\Product::find($order->product_id);
                    @endphp
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->brand_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->discount }}</td>
                    <td>{{ $product->value }}</td>
                    <td>{{ ((int) $product->value - (int) $order->discount) * (int) $order->quantity }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>