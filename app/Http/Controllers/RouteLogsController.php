<?php

namespace App\Http\Controllers;

use App\Models\RouteLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteLogsController extends Controller
{
    //
    public function index(Request $request)
    {
        if(Auth::user()->role == 4 || Auth::user()->role == 3){
            // Regional Manager
            $users = User::orwhere('regionalmanager', Auth::user()->id)->orwhere('sales_supervisor_id', Auth::user()->id)->where('role', 5)->pluck('id');
            $routelogs =RouteLog::whereIn('salesofficer_id', $users)->orderBy('id','asc')->get();
        }else{
            // Admin
            $routelogs =RouteLog::orderBy('id','asc')->get();
        }
        
        // $routelogs = RouteLog::orderBy('id','asc')->get();

        return view('routelogs.index')
            ->with('routelogs', $routelogs);
    }

}
