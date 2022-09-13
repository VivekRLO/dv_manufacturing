<div class="col-6">
    <div class="card-body">
        <h4>Information</h4>
        <hr>
        <h5 class="title">{{ $user->name }} [ {{ $user->id }} ]</h5>
        <h6 class="subtitle mb-2 text-muted">
            @if ($user->role == 3)
                Sales Officer
            @elseif($user->role == 4)
                Regional Manager
            @else
                DSE
            @endif
        </h6>
        <a href="mailto:{{ $user->email }}" class="card-link">{{ $user->email }}</a>
        <a href="tel:00{{ $user->phone }}" class="card-link">{{ $user->phone }}</a>
    </div>
</div>
@php
    $regional_manager = App\Models\User::find($user->regionalmanager)??null;
    $sales_officer = App\Models\User::find($user->sales_supervisor_id)??null;
@endphp
@if ($user->role != 4)
<div class="col-6">
    <div class="card-body">
        <h4>Under</h4>
        @if ($sales_officer != null)
        <hr>
            <h5 class="title"><a href="{{ route('users.user_filter', [$sales_officer]) }}">{{ $sales_officer->name }}</a></h5>
            <h6 class="subtitle mb-2 text-muted">Sales Officer</h6>
        @endif
        @if ($regional_manager != null)
        <hr>
            <h5 class="title"><a href="{{ route('users.user_filter', [$regional_manager]) }}">{{ $regional_manager->name }}</a></h5>
            <h6 class="subtitle mb-2 text-muted">Regional Manager</h6>
        @endif
    </div>
</div>
@endif

@php
    $dse_users = App\Models\User::where('regionalmanager', $user->id)->orwhere('sales_supervisor_id', $user->id)->where('role', 5)->get();
    $sales_officer_users = App\Models\User::where('regionalmanager', $user->id)->orwhere('sales_supervisor_id', $user->id)->where('role', 4)->get();
@endphp

@if ($user->role != 5)
<div class="col-12">
    <div class="card-body">
        <h4>Assiged Employees</h4>
        <hr>
        <div class="row">
        @foreach ($dse_users as $dse)
            <div class="col-4">
                <div class="card p-3">
                    <h5 class="title"><a href="{{ route('users.user_filter', [$dse->id]) }}">{{ $dse->name }}</a></h5><i ></i>
                    <h6 class="subtitle text-muted">DSE</h6>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
        @foreach ($sales_officer_users as $sales_officer)
        <div class="col-4">
            <div class="card p-3">
                <h5 class="title"><a href="{{ route('users.user_filter', [$sales_officer->id]) }}">{{ $sales_officer->name }}</a></h5>
                <h6 class="subtitle mb-2 text-muted">Sales Officer</h6>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="col-12">
    <div class="card-body">
        @if ($user->role == 5)
        <h4>Routes</h4>
            @foreach ($user->route_users as $route)
                <hr>
                <p class="mb-2">{{ $route->routename }} <a href="{{ route('routeNames.outlet_list', $route->id) }}">[ {{ $route->outlets->count() }} ]</a></p><i ></i>
            @endforeach
        @else
            <h4>Routes of DSE</h4>
            @if (isset($users))
                @foreach ($users as $user)
                    @forelse ($user->route_users as $route)
                        <hr>
                        <p class="mb-2">{{ $route->routename }} <a href="{{ route('routeNames.outlet_list', $route->id) }}">[ {{ $route->outlets->count() }} ]</a></p><i ></i>
                    @empty
                        {{-- <p>No Route Defined</p> --}}
                    @endforelse
                @endforeach                                
            @endif
        @endif
    </div>
</div>