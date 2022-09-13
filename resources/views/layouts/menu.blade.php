@if(Auth::user()->role=="6")

<li class="nav-item">
    <a href="{{ route('orders.distributorwise') }}" class="nav-link {{ Request::is('orders*') ? 'active' : '' }}">
        <i class="fas fa-exchange-alt nav-icon"></i>
        <p>Orders</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('sales.index') }}" class="nav-link {{ Request::is('*outlets*') ? 'active' : '' }}">
        <i class="fa fa-calendar nav-icon"></i>
        <p>Order</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('products.distributorwise_product') }}" class="nav-link {{ Request::is('*outlets*') ? 'active' : '' }}">
        <i class="fas fa-tags nav-icon"></i>
        <p>Product List</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('saleReturns.index') }}" class="nav-link {{ Request::is('saleReturns*') ? 'active' : '' }}">
        <i class="fa fa-undo  nav-icon" aria-hidden="true"></i>
        <p>Order Returns</p>
    </a>
</li>
<li class="nav-item has-treeview menu-open">
    <a href="#" class="nav-link">
        <i class="fas fa-file-alt nav-icon"></i>
        <p>
            Report
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: block;">
        <li class="nav-item">
            <a href="{{ route('stockCounts.distributor_index') }}" class="nav-link {{ Request::is('*stockCounts*') ? 'active' : '' }}">
                <i class="fas fa-history  nav-icon"></i>
                <p>Stock Report</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.daily_sale_report') }}" class="nav-link {{ Request::is('*report/daily_sale_report*') ? 'active' : '' }}">
                <i class="fa fa-table nav-icon"></i>
                <p>Order Report</p>
            </a>
        </li>
       
    </ul>
</li>
@else
<li class="nav-item">
    <a href="{{ route('outlet.outlet_remove') }}" class="nav-link {{ Request::is('*removeOutlet*') ? 'active' : '' }}">
        <i class="fas fa-store-alt nav-icon"></i>
        @php
            $count = \App\Models\OutletDeleteList::all()->count();
        @endphp
        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger" style="left: 30px; top: 2px;">{{ $count }}</span>
        <p>Remove Outlets</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('*user*') ? 'active' : '' }}">
        <i class="fas fa-users nav-icon"></i>
        <p>Users</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('distributors.index') }}" class="nav-link {{ Request::is('*distributors*') ? 'active' : '' }}">
        <i class="fas fa-warehouse nav-icon"></i>
        <p>Distributors</p>
    </a>
</li>
@if(Auth::user()->role == 6 || Auth::user()->role == 0)
<li class="nav-item">
    <a href="{{ route('products.index') }}" class="nav-link {{ Request::is('*products*') ? 'active' : '' }}">
        <i class="fas fa-tags nav-icon"></i>
        <p>Products</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('batches.index')}}" class="nav-link {{Request::is('*batches*')?'active':''}}">
        <i class="fas fa-layer-group nav-icon"></i>
        <p>Batches</p>
    </a>
</li>
@endif
{{-- <li class="nav-item">
    <a href="{{ route('stockHistories.index') }}"
class="nav-link {{ Request::is('*stockHistories*') ? 'active' : '' }}">
<i class="fas fa-history  nav-icon"></i>
<p>Stock Histories</p>
</a>
</li> --}}


{{-- <li class="nav-item">
    <a href="{{ route('sales.index') }}" class="nav-link {{ Request::is('*sales*') ? 'active' : '' }}">
<i class="fas fa-exchange-alt nav-icon"></i>
<p>Order</p>
</a>
</li> --}}
<li class="nav-item has-treeview menu-open">
    <a href="#" class="nav-link">
        <i class="fas fa-file-alt nav-icon"></i>
        <p>
            Report
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: block;">
        @if(Auth::user()->role == 6 || Auth::user()->role == 0)
            <li class="nav-item">
                <a href="{{ route('stockCounts.index') }}" class="nav-link {{ Request::is('*stockCounts*') ? 'active' : '' }}">
                    <i class="fas fa-history nav-icon"></i>
                    <p>Stock Report</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('collections.index') }}" class="nav-link {{ Request::is('*collections*') ? 'active' : '' }}">
                    <i class="fas fa-money-check-alt nav-icon"></i>
                    <p>Collections</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link {{ Request::is('orders*') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt nav-icon"></i>
                    <p>Orders</p>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a href="{{ route('report.daily_sales_officer_sales') }}" class="nav-link {{ Request::is('*report/daily_sales_officer_sales*') ? 'active' : '' }}">
                <i class="fa fa-table nav-icon"></i>
                <p>Daily Order Report</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.sales_officer_sales') }}" class="nav-link {{ Request::is('*report/sales_officer_sales*') ? 'active' : '' }}">
                <i class="fa fa-calendar nav-icon"></i>
                <p>Monthly Order Report</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('report.detail_report') }}" class="nav-link {{ Request::is('*report/detail_report*') ? 'active' : '' }}">
                <i class="fa fa-info-circle nav-icon"></i>
                <p>Detail Report</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('quotation.index') }}" class="nav-link {{ Request::is('*/quotation*') ? 'active' : '' }}">
                <i class="fa fa-calendar-plus nav-icon"></i>
                <p>Target</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('live_location') }}" class="nav-link {{ Request::is('*/live_location*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt nav-icon"></i>
                <p>Live Locations</p>
            </a>
        </li>
        

        <li class="nav-item">
            <a href="{{ route('checkInOuts.index') }}" class="nav-link {{ Request::is('*checkInOuts*') ? 'active' : '' }}">
                <i class="far fa-calendar-alt nav-icon"></i>
                <p>Check In Outs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.outletwise_report') }}" class="nav-link {{ Request::is('*report/outletwise_report*') ? 'active' : '' }}">
                <i class="fa fa-table nav-icon"></i>
                <p>DSE Outletwise</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.routewise_outlet_status') }}"
            class="nav-link {{ Request::is('*report/routewise_outlet_status*') ? 'active' : '' }}">
            <i class="fa fa-toggle-on nav-icon"></i>
            <p>Routewise Outlets</p>
        </a>
        </li>
    </ul>
</li>

{{-- <li class="nav-item">
    <a href="{{ route('monthlyTours.index') }}" class="nav-link {{ Request::is('monthlyTours*') ? 'active' : '' }}">
        <i class="fas fa-layer-group nav-icon"></i>
        <p>Monthly Tours</p>
    </a>
</li> --}}
<li class="nav-item">
    <a href="{{ route('routelogs.index') }}" class="nav-link {{ Request::is('routelogs*') ? 'active' : '' }}">
        <i class="fas fa-layer-group nav-icon"></i>
        <p>DSE Route Logs</p>
    </a>
</li>

{{-- <li class="nav-item">
    <a href="{{ route('dailyLocations.index') }}" class="nav-link {{ Request::is('dailyLocations*') ? 'active' : '' }}">
<p>Daily Locations</p>
</a>
</li> --}}
{{-- <li class="nav-item">
    <a href="{{ route('getlocations') }}" class="nav-link {{ Request::is('get-locations*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-location-arrow"></i>
        <p>Locations List</p>
    </a>
</li> --}}
@endif
@if (Auth::user()->role == 0)
<li class="nav-item">
    <a href="{{ route('banks.index') }}" class="nav-link {{ Request::is('banks*') ? 'active' : '' }}">
        <i class="fas fa-university nav-icon"></i>
        <p>Banks</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('appVersions.index') }}" class="nav-link {{ Request::is('*appVersions*') ? 'active' : '' }}">
        <i class="fab fa-android nav-icon"></i>
        <p>App Versions</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('channels.index') }}"
       class="nav-link {{ Request::is('channels*') ? 'active' : '' }}">
       <i class="fa fa-link nav-icon" aria-hidden="true"></i> <p>Channels</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('categories.index') }}"
       class="nav-link {{ Request::is('categories*') ? 'active' : '' }}">
       <i class="fa fa-sitemap nav-icon" aria-hidden="true"></i><p>Categories</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('zones.index') }}"
       class="nav-link {{ Request::is('zones*') ? 'active' : '' }}">
       <i class="fa fa-server nav-icon" aria-hidden="true"></i> <p>Zones</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('towns.index') }}"
       class="nav-link {{ Request::is('towns*') ? 'active' : '' }}">
       <i class="fa fa-building nav-icon" aria-hidden="true"></i><p>Towns</p>
    </a>
</li>
@endif




<li class="nav-item">
    <a href="{{ route('routeName.index') }}"
       class="nav-link {{ Request::is('routeName*') ? 'active' : '' }}">
       <i class="fa fa-road nav-icon" aria-hidden="true"></i> <p>Routes</p>
    </a>
</li>

@if (Auth::user()->role == 0)    
    <li class="nav-item">
        <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
            <i class="fa fa-lock nav-icon" aria-hidden="true"></i> <p>Roles</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
            <i class="fa fa-key nav-icon" aria-hidden="true"></i>  <p>Permissions</p>
        </a>
    </li>
@endif
