@extends('layouts.app')

@section('content')
@include('flash::message')

@if(Auth::user()->role=="6")

@else
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            margin-left: 5px;
            margin-top: 5px;
            float: left;
            width: 33%;
            padding: 10px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the buttons */
        .btn {
            border: none;
            outline: none;
            padding: 12px 16px;
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #ddd;
        }

        .btn.active {
            background-color: #666;
            color: white;
        }

        a {
            color: black;
        }
    </style>
</head>

<body>
    <br>
    <div style="align: center;" class="row">
        <div class="column" style="background-color:#aaa;">
            <a href="{{ route('outlets.index') }}" class="nav-link {{ Request::is('*outlets*') ? 'active' : '' }}">
                <i class="fas fa-store fa-4x"></i>
                <h2>Outlets</h2>
            </a>
        </div>
        <div class="column" style="background-color:#bbb;">
            <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('*users*') ? 'active' : '' }}">
                <i class="fas fa-users fa-4x"></i>
                <h2>Users</h2>
            </a>
        </div>
        <div class="column" style="background-color:#ccc;">

            <a href="{{ route('distributors.index') }}"
                class="nav-link {{ Request::is('*distributors*') ? 'active' : '' }}">
                <i class="fas fa-warehouse fa-4x"></i>
                <h2>Distributors</h2>
            </a>
        </div>


        <div class="column" style="background-color:#ddd;">

            <a href="{{ route('products.index') }}" class="nav-link {{ Request::is('*products*') ? 'active' : '' }}">
                <i class="fas fa-tags fa-4x"></i>
                <h2>Products</h2>
            </a>
        </div>

        <div class="column" style="background-color:#eee;">
            <a href="{{ route('report_menu') }}" class="nav-link {{ Request::is('orders*') ? 'active' : '' }}">
                <i class="fas fa-file-alt fa-4x"></i>
                <h2>Reports</h2>
            </a>
        </div>
        <div class="column" style="background-color:#fff;">

            <a href="{{ route('orders.index') }}" class="nav-link {{ Request::is('orders*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt fa-4x"></i>
                <h2>Orders</h2>
            </a>
        </div>


        <div class="column" style="background-color:#aaa;">

            <a href="{{ route('routelogs.index') }}"
                class="nav-link {{ Request::is('routelogs*') ? 'active' : '' }}">
                <i class="fas fa-layer-group fa-4x"></i>
                <h2>DSE Route Log</h2>
            </a>
        </div>
        <div class="column" style="background-color:#bbb;">

            <a href="{{ route('banks.index') }}" class="nav-link {{ Request::is('banks*') ? 'active' : '' }}">
                <i class="fas fa-university fa-4x"></i>
                <h2>Banks</h2>
            </a>
        </div>
        <div class="column" style="background-color:#ccc;">

            <a href="{{ route('getlocations') }}" class="nav-link {{ Request::is('get-locations*') ? 'active' : '' }}">
                <i class="fa-4x fas fa-location-arrow"></i>
                <h2>Locations List</h2>
            </a>
        </div>


        <div class="column" style="background-color:#ddd;">

            <a href="{{ route('appVersions.index') }}"
                class="nav-link {{ Request::is('*appVersions*') ? 'active' : '' }}">
                <i class="fab fa-android fa-4x"></i>
                <h2>App Versions</h2>
            </a>
        </div>
    </div>
</body>

</html>

@endif
@endsection