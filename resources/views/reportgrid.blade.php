@extends('layouts.app')

@section('content')
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

        <div  class="row">
            <div class="column" style="background-color:#aaa;">
                <a href="{{ route('stockCounts.index') }}"
                class="nav-link {{ Request::is('*stockCounts*') ? 'active' : '' }}">
                <i  class="fas fa-history  fa-4x"></i>
                <h2>Stock Report</h2>
             </a>
                
            </div>
            <div class="column" style="background-color:#bbb;">
                <a href="{{ route('report.daily_sale_report') }}"
                class="nav-link {{ Request::is('*report/daily_sale_report*') ? 'active' : '' }}">
                <i class="fa fa-table fa-4x"></i>
                <h2>Daily Order Report</h2>
            </a>
                
            </div>
            <div class="column" style="background-color:#ccc;">
                <a href="{{ route('report.sales_officer_sales') }}"
                class="nav-link {{ Request::is('*report/sales_officer_sales*') ? 'active' : '' }}">
                <i class="fa fa-calendar fa-4x"></i>
                <h2>Monthly Order Report</h2>
            </a>
            </div>

            
            <div class="column" style="background-color:#ddd;">
                
                <a href="{{ route('report.detail_report') }}"
                class="nav-link {{ Request::is('*report/detail_report*') ? 'active' : '' }}">
                <i class="fa fa-info-circle fa-4x"></i>
                <h2>Details Report</h2>
            </a>
            </div>
            
            <div class="column" style="background-color:#eee;">
                
                <a href="{{ route('live_location') }}"
                class="nav-link {{ Request::is('*/live_location*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt fa-4x"></i>
                <h2>Live Locations</h2>
             </a>
            </div>
            <div class="column" style="background-color:#fff;">
               
                <a href="{{ route('collections.index') }}"
                class="nav-link {{ Request::is('*collections*') ? 'active' : '' }}">
                <i class="fas fa-money-check-alt fa-4x"></i>
                <h2>Collections</h2>
            </a>
            </div>

            <div class="column" style="background-color:#aaa;">
              
                <a href="{{ route('checkInOuts.index') }}" class="nav-link {{ Request::is('*checkInOuts*') ? 'active' : '' }}">
                    <i class="far fa-calendar-alt fa-4x"></i>
                    <h2>Check In Outs</h2>
                </a>
            </div>
            <div class="column" style="background-color:#bbb;">
                <a href="{{ route('report.outletwise_report') }}"
                class="nav-link {{ Request::is('*report/outletwise_report*') ? 'active' : '' }}">
                <i class="fa fa-table fa-4x"></i>
                <h2>DSE Outletwise</h2>
            </a>
                
            </div>
            <div class="column" style="background-color:#ccc;">
                <a href="{{ route('report.routewise_outlet_status') }}"
                class="nav-link {{ Request::is('*report/routewise_outlet_status*') ? 'active' : '' }}">
                <i class="fa fa-toggle-on fa-4x"></i>
                <h2>Routewise Outlet status</h2>
            </a>
                
            </div>
           
        </div>
    

    </body>

    </html>

@endsection
