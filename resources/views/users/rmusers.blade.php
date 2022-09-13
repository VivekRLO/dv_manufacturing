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
                    <h3>Regional Manager</h3>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row table-responsive">
                    <table class="table" id="users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Distributor</th>
                                <th>Login Time</th>
                                <th>Status</th>       
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rmusers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->rm_distributors[0]->name??"" }}</td>
                                        @php
                                            $routename = App\Models\RouteLog::where('salesofficer_id',$user->id)->whereDate('created_at',Carbon\Carbon::now())->get();
                                            $routename = $routename->unique('route');
                                            $route_array = $routename->pluck('route');
                                            $login = explode(' ', $user->last_login_at); 
                                        @endphp
                                    
                                        @if ($login[0] == Carbon\Carbon::now()->format('Y-m-d'))
                                            <td>
                                                {{ $user->last_login_at }}
                                            </td>
                                            <td>
                                                <span class="dot" style="background-color: green;"></span>
                                            </td>
                                        @else
                                            <td>
                                            </td>
                                            <td>
                                                <span class="dot" style="background-color: red;"></span>
                                            </td>
                                        @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

