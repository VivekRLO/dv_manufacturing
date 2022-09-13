<?php

declare(strict_types = 1);
namespace App\Http\Controllers;
use App\Charts\UserChart;

use App\Models\Address;
use App\Models\Outlet;
use App\Models\RouteLog;
use App\Models\User;
use App\Models\Quotation;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\OutletDeleteList;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = OutletDeleteList::where('flag', 0)->get();
        $user_rolewise_count=(User::where('flag', 0)->get())->groupBy('role');
        if(Auth::user()->role == 6){
            $users = DB::table('distributor_user')->where('distributor_id', Auth::user()->id)->get();
            if(!$users->IsEmpty()){
                $user_rolewise_count[5] = User::whereIn('id', $users->id)->where('flag', 0)->get()->count(); # DSE
                $user_rolewise_count[3] = User::whereIn('id', $users->sales_supervisor_id)->where('flag', 0)->get()->count(); # SO
                $user_rolewise_count[4] = User::whereIn('id', $users->regionalmanager)->where('flag', 0)->get()->count(); # RM
            }else{
                $user_rolewise_count = [];
            }
        }

        $active_dse = (RouteLog::whereDate('created_at',Carbon::now())->get())->groupby('salesofficer_id')->count();
        $outlets_count = Outlet::all()->count();
        $products = Product::all();
        $order_outlets = (Sale::whereDate('created_at',Carbon::now())->get())->groupby('outlet_id')->count();
        $active_web_user = (User::whereDate('last_login_at',Carbon::now())->get())->groupby('role');
        return view('home',compact('user_rolewise_count','active_dse','order_outlets','outlets_count','active_web_user', 'products'));
    }

    public function getLocations(Request $request)
    {
        $locations = Address::select('id','province','district','local_level_en')->orderby('id')->paginate(100);
        return view('locations.list', compact('locations'));
    }
}
