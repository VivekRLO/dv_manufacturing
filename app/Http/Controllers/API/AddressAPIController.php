<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Address;
use App\Models\Channel;
use App\Models\Category;
use App\Models\Town;
use Illuminate\Support\Facades\DB;



class AddressAPIController extends AppBaseController
{
    public function index(Request $request)
    {
        $input = $request->all();
//        dd($input);
        $locations = '';
        if (array_key_exists('province', $input)) {
            $locations = Address::where('province', $input['province'])->select('district')->orderBy('district')->groupBy('district')->get();
        } elseif (array_key_exists('district', $input)) {
            $locations = Address::where('district', $input['district'])->select('id', 'local_level_en')->orderBy('local_level_en')->get();
        } else {
            $locations = Address::select('province', 'province')->orderBy('province')->groupBy('province')->get();
        }
//        dd(json_encode($locations));
        return $locations->toArray();
//        return $this->response($locations->toArray(), 'Locations retrieved successfully');
    }
    public function getLocations(Request $request)
    {
        $locations = Address::select('id','province','district','local_level_en')->orderby('id')->get();
        // $locations = $locations->groupby(['province','district']);
        return $this->sendResponse($locations->toArray(), 'Locations retrieved successfully');
    }

    public function channel_list(Request $request){
        $channel_list=Channel::select('id','channel')->get();
        return $this->sendResponse($channel_list->toArray(), 'Channel List retrieved successfully');
    }
    public function category_list(Request $request){
        $category_list=Category::select('id','category')->get();
        return $this->sendResponse($category_list->toArray(), 'Category List retrieved successfully');
        
    }
    public function town_list(Request $request){
        // $town_list=Town::select('id','town','zone_id')->with('zone:id,zone')->get();
        $town_list=DB::table('towns') ->join('zones', 'zones.id', '=', 'towns.zone_id')->select('towns.id','towns.town','zones.zone','zones.id as zoneid')->get();
        return $this->sendResponse($town_list->toArray(), 'Town List retrieved successfully');
        
    }
}
