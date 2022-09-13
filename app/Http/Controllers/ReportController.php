<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Outlet;
use DateTime;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Product;
use App\Models\RouteLog;
use App\Models\RouteName;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function sales_officer_sales()
    {

        $from = Carbon::now()->firstOfMonth();
        $to = Carbon::now();

        # RegionalManager
        if (Auth::user()->role == 4) {                                         
            $sales_officers = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('role', 5)->pluck('id');
            $sales = DB::table('sales')
            ->where('sales_officer_id', [$sales_officers])
            ->whereDate('sold_at', $to)
            ->whereNotNull('product_id')
            ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
            ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
            ->orderBy('date')
            ->get();
        }
        # Admin
        else {
            $sales_officers = User::where('type', 2)->whereIn('role', [5])->get();
            $sales = DB::table('sales')
            ->whereBetween('sold_at', [$from, $to])
            ->whereNotNull('product_id')
            ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
            ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
            ->orderBy('date')
            ->get();
        }

        $products = [];
        return view('reports.sales_officer_sales', compact('sales', 'products'));
    }

    public function daily_sales_officer_sales()
    {

        $from = Carbon::now()->firstOfMonth();
        $to = Carbon::now();

        # RegionalManager
        if (Auth::user()->role == 4) {
            $sales_officers = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('role', 5)->pluck('id');
            $sales = DB::table('sales')
            ->where('sales_officer_id', [$sales_officers])
            ->whereDate('sold_at', $to)
            // ->whereNotNull('product_id')
            ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
            ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
            ->orderBy('date')
            ->get();
        }
        # Admin
        else {
            $sales_officers = User::where('type', 2)->whereIn('role', [5])->get();
            $sales = DB::table('sales')
            ->whereDate('sold_at', $to)
            // ->whereNotNull('product_id')
            ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
            ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
            ->orderBy('date')
            ->get();
        }

        $products = [];
        return view('reports.daily_sales_officer_sales', compact('sales', 'products'));
    }
    
    public function report_sales_officer(Request $request)
    {
     
        $now = Carbon::now();
        if($request->date_from == null){
            $from = $now->year."-".$now->month."-01". " 00:00:00";
        }else{
            $from = $request->date_from . " 00:00:00";
        }

        if($request->date_to == null){
            $to = $now. " 23:59:59";
        }else{
            $to = $request->date_to . " 23:59:59";

        }
        if ($request->filter_by == "DSE") {
            $sales = DB::table('sales')
                ->where('sales_officer_id', $request->filtername)
                ->whereBetween('sold_at', [$from, $to])
                ->whereNotNull('product_id')
                ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
                ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
                ->orderBy('date')
                ->get();
            return view('reports.sales_officer_sales', compact('sales'));
        } elseif ($request->filter_by == "Sub D") {
            $sales = DB::table('sales')
                ->where('distributor_id', $request->filtername)
                ->whereBetween('sold_at', [$from, $to])
                ->whereNotNull('product_id')
                ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
                ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
                ->orderBy('date')
                ->get();
            return view('reports.sales_officer_sales', compact('sales'));
        } elseif ($request->filter_by == "Routewise") {
            $sales = DB::table('sales')
                ->where('route_id', $request->filtername)
                ->whereBetween('sold_at', [$from, $to])
                ->whereNotNull('product_id')
                ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
                ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
                ->orderBy('date')
                ->get();
            return view('reports.sales_officer_sales', compact('sales'));
        } else {
            $sales = DB::table('sales')
                ->whereBetween('sold_at', [$from, $to])
                ->whereNotNull('product_id')
                ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
                ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
                ->orderBy('date')
                ->get();
            return view('reports.sales_officer_sales', compact('sales'));
        }
        
    }

    public function daily_report_sales_officer(Request $request)
    {
     
        $now = Carbon::now();
        
        if($request->date_to == null){
            $to = $now->format('Y-m-d');
        }else{
            $to = $request->date_to;
        }

        if ($request->filter_by == "DSE") {
            $sales = DB::table('sales')
                ->where('sales_officer_id', $request->filtername)
                ->whereDate('sold_at', 'like','%' .$to.'%')
                ->whereNotNull('product_id')
                ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
                ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
                ->orderBy('date')
                ->get();
            return view('reports.daily_sales_officer_sales', compact('sales'));
        } elseif ($request->filter_by == "Sub D") {
            $sales = DB::table('sales')
                ->where('distributor_id', $request->filtername)
                ->whereDate('sold_at', $to)
                ->whereNotNull('product_id')
                ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
                ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
                ->orderBy('date')
                ->get();
            return view('reports.daily_sales_officer_sales', compact('sales'));
        } elseif ($request->filter_by == "Routewise") {
            $sales = DB::table('sales')
                ->where('route_id', $request->filtername)
                ->whereDate('sold_at', $to)
                ->whereNotNull('product_id')
                ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
                ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
                ->orderBy('date')
                ->get();
            return view('reports.daily_sales_officer_sales', compact('sales'));
        } else {
            $sales = DB::table('sales')
            ->whereDate('sold_at', $to)
            ->whereNotNull('product_id')
            ->groupBy(['product_id','outlet_id', 'date','distributor_id','route_id','sales_officer_id', 'remarks'])
            ->select(DB::raw('DATE(sold_at) as date'), 'product_id', DB::raw('sum(quantity) as sum'),'distributor_id','route_id','sales_officer_id as dse','outlet_id', 'remarks')
            ->orderBy('date')
            ->get();
        return view('reports.daily_sales_officer_sales', compact('sales'));
        }
        
    }



    public function daily_sale_report()
    {
        $products = Product::pluck('name', 'id');

        return view('reports.daily_sales_report', compact('products'));
    }
    public function day_wise_report(Request $request)
    {
        $users = [];

        # Trading

        # RegionalManager
        if (Auth::user()->role == 4) {
            $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('role', 5)->pluck('id');
        }
        # Admin
        else {
            $users = User::where('type', 2)->whereIn('role', [5])->pluck('id');
        }

        $products = Product::pluck('name', 'id');
        $validated = $request->validate([
            'date' => 'required',
        ]);
        $sales = DB::table('sales')
            ->select(DB::raw('DATE(sold_at) as date'), 'sales_officer_id', 'product_id', DB::raw('sum(quantity) as sum'))
            ->where('sold_at', 'like', '%' . $request->date . '%')
            ->whereIn('sales_officer_id', $users)
            ->groupBy(['product_id', 'date', 'sales_officer_id'])
            ->get();
        $datas = $sales->groupBy('sales_officer_id');
        $date = $request->date;
        return view('reports.daily_sales_report', compact('datas', 'products', 'date'));
    }

    public function detail_report()
    {
        $users = [];

        # RegionalManager
        if (Auth::user()->role == 4) {
            $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('role', 5)->pluck('id');
        }
        # Admin
        else {
            $users = User::where('type', 2)->whereIn('role', [5])->pluck('id');
        }

        $products = Product::pluck('name', 'id');
        $sales_officers = User::whereIn('id', $users)->pluck('name', 'id');

        return view('reports.detail_report', compact('products', 'sales_officers'));
    }
    public function single_detail_report(Request $request)
    {
        $users = [];

        # RegionalManager
        if (Auth::user()->role == 4) {
            $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('role', 5)->pluck('id');
        }
        # Admin
        else {
            $users = User::where('type', 2)->whereIn('role', [5])->pluck('id');
        }

        $products = Product::pluck('name', 'id');
        $sales_officers = User::whereIn('id', $users)->pluck('name', 'id');
        $validated = $request->validate([
            'date' => 'required',
            'sale_officer_id' => 'required'
        ]);
        $sales = DB::table('sales')
            ->select(DB::raw('DATE(sold_at) as date'), 'outlet_id', 'distributor_id', 'product_id', DB::raw('sum(quantity) as sum'))
            ->where('sold_at', 'like', '%' . $request->date . '%')
            ->where('sales_officer_id', $request->sale_officer_id)
            ->groupBy(['product_id', 'outlet_id', 'date', 'distributor_id'])
            ->get();

        $datas = $sales->groupBy('outlet_id');
        $date = $request->date;
        $sale_officer_name = User::find($request->sale_officer_id)->name;
        return view('reports.detail_report', compact('datas', 'products', 'date', 'sales_officers', 'sale_officer_name'));
    }
    public function outletwise_report()
    {
        $users = [];

        # RegionalManager
        if (Auth::user()->role == 4) {
            $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('role', 5)->pluck('id');
        }
        # Admin
        else {
            $users = User::where('type', 2)->whereIn('role', [5])->pluck('id');
        }

        $sales_officers = User::whereIn('id', $users)->pluck('name', 'id');

        return view('reports.dse_outletwise_report', compact('sales_officers'));
    }
    public function dse_outlestwise_product_report(Request $request)
    {
        $users = [];

        # RegionalManager
        if (Auth::user()->role == 4) {
            $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('role', 5)->pluck('id');
        }
        # Admin
        else {
            $users = User::where('type', 2)->whereIn('role', [5])->pluck('id');
        }

        $sales_officers = User::whereIn('id', $users)->pluck('name', 'id');
        $validated = $request->validate([
            'date' => 'required',
            'sale_officer_id' => 'required'
        ]);
        $sales = DB::table('sales')
            ->select(DB::raw('DATE(sold_at) as date'), 'outlet_id', 'distributor_id', 'product_id', DB::raw('sum(quantity) as sum'), 'discount')
            ->where('sold_at', 'like', '%' . $request->date . '%')
            ->where('sales_officer_id', $request->sale_officer_id)
            ->orderBy('sold_at', 'asc')
            ->groupBy(['product_id', 'outlet_id', 'date', 'distributor_id', 'discount'])
            ->get();

        $date = $request->date;
        $sale_officer_name = User::find($request->sale_officer_id)->name;
        return view('reports.dse_outletwise_report', compact('sales', 'date', 'sales_officers', 'sale_officer_name'));
    }
    public function routewise_outlet_status(Request $request)
    {
        $users = DB::table('users')->where('role', 5)->leftJoin('routelogs', function ($join) {
            $join->on('users.id', '=', 'routelogs.salesofficer_id')
                ->where('routelogs.id', '=', DB::raw("(SELECT max(id) from routelogs where salesofficer_id= users.id)"));
            })->join('distributor_user', 'distributor_user.user_id', '=', 'users.id')
            ->join('distributors', 'distributors.id', '=', 'distributor_user.distributor_id')
            ->select('users.id', 'users.name', 'routelogs.route', 'routelogs.created_at', 'distributors.name as dsub','routelogs.id as routelogid')
            ->get();
        
        return view('reports.routewise_outlet_status', compact('users'));
    }
    public function detail_routewise_outlet_report($routelogs_id)
    {
        $routelogs=RouteLog::find($routelogs_id);
        $route_id=$routelogs->route;
        $date=$routelogs->created_at->format('Y-m-d');
        $this->date=$routelogs->created_at->format('Y-m-d');

        $outlestdata_array = Outlet::where(['route_id'=> $route_id])->withCount(
            [
                'sales' => function(Builder $q) {
                $q->where('sold_at', 'like', '%' . $this->date . '%');
            }]
        )->with('sales')->get();
        $dse_id=$routelogs->salesofficer_id;
        $route=RouteName::find($route_id)->routename;
        $sale_officer_name=User::find($dse_id)->name;
        return view('reports.detail_routewise_outlet_status', compact('outlestdata_array','date','route','sale_officer_name'));
    }
    public function routewise_outlet_report(Request $request)
    {
        $from = $request->date_from . " 00:00:00";
        $to = $request->date_to . " 23:59:59";
        if ($request->filter_by == "DSE") {
            $users = DB::table('users')->where('users.id', $request->filtername)->leftJoin('routelogs', function ($join) use ($from, $to) {
                $join->on('users.id', '=', 'routelogs.salesofficer_id')
                    // ->where('routelogs.id', '=', DB::raw("(SELECT max(id) from routelogs )"));
                    ->whereBetween('routelogs.created_at', [$from, $to]);
            })->join('distributor_user', 'distributor_user.user_id', '=', 'users.id')
                ->join('distributors', 'distributors.id', '=', 'distributor_user.distributor_id')
                ->select('users.id', 'users.name', 'routelogs.route', 'routelogs.created_at', 'distributors.name as dsub','routelogs.id as routelogid')
                ->get();
            return view('reports.routewise_outlet_status', compact('users'));
        } elseif ($request->filter_by == "Sub D") {
            $users = DB::table('users')->where('role', 5)->leftJoin('routelogs', function ($join) use ($from, $to) {
                $join->on('users.id', '=', 'routelogs.salesofficer_id')
                    // ->where('routelogs.id', '=', DB::raw("(SELECT max(id) from routelogs )"));
                    ->whereBetween('routelogs.created_at', [$from, $to]);
            })->join('distributor_user', 'distributor_user.user_id', '=', 'users.id')
                ->join('distributors', 'distributors.id', '=', 'distributor_user.distributor_id')
                ->where('distributors.id', '=', $request->filtername)
                ->select('users.id', 'users.name', 'routelogs.route', 'routelogs.created_at', 'distributors.name as dsub','routelogs.id as routelogid')
                ->get();
            return view('reports.routewise_outlet_status', compact('users'));
        } elseif ($request->filter_by == "Routewise") {
            $route = $request->filtername;
            $users = DB::table('users')->where('role', 5)->leftJoin('routelogs', function ($join) use ($from, $to, $route) {
                $join->on('users.id', '=', 'routelogs.salesofficer_id')
                    // ->where('routelogs.id', '=', DB::raw("(SELECT max(id) from routelogs )"));
                    ->where('routelogs.route', $route)
                    ->whereBetween('routelogs.created_at', [$from, $to]);
            })->join('distributor_user', 'distributor_user.user_id', '=', 'users.id')
                ->join('distributors', 'distributors.id', '=', 'distributor_user.distributor_id')
                ->select('users.id', 'users.name', 'routelogs.route', 'routelogs.created_at', 'distributors.name as dsub','routelogs.id as routelogid')
                ->get();
            return view('reports.routewise_outlet_status', compact('users'));
        } else {
            $users = DB::table('users')->where('role', 5)->leftJoin('routelogs', function ($join) use ($from, $to) {
                $join->on('users.id', '=', 'routelogs.salesofficer_id')
                    // ->where('routelogs.id', '=', DB::raw("(SELECT max(id) from routelogs )"));
                    ->whereBetween('routelogs.created_at', [$from, $to]);
            })->join('distributor_user', 'distributor_user.user_id', '=', 'users.id')
                ->join('distributors', 'distributors.id', '=', 'distributor_user.distributor_id')
                ->select('users.id', 'users.name', 'routelogs.route', 'routelogs.created_at', 'distributors.name as dsub','routelogs.id as routelogid')
                ->get();
            return view('reports.routewise_outlet_status', compact('users'));
        }
    }

}
