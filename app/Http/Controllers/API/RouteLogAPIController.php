<?php

namespace App\Http\Controllers\API;
use App\Models\RouteLog;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;


class RouteLogAPIController extends AppBaseController
{
    public function store(Request $request){
        $routelog = RouteLog::create([
            'distributor_id' => $request->distributor_id,
            'salesofficer_id' => $request->user_id,
            'route' => $request->route,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return $this->sendResponse($routelog->toArray(), 'RouteLogs Store successfully');
    }
}
