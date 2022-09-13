<?php

namespace App\Http\Controllers\API;

use Response;
use Carbon\Carbon;
use App\Models\Area;
use App\Models\Outlet;
use App\Models\Street;
use GuzzleHttp\Client;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OutletRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateOutletAPIRequest;
use App\Http\Requests\API\UpdateOutletAPIRequest;
use App\Models\RouteLog;


/**
 * Class OutletController
 * @package App\Http\Controllers\API
 */

class OutletAPIController extends AppBaseController
{
    /** @var  OutletRepository */
    private $outletRepository;

    public function __construct(OutletRepository $outletRepo)
    {
        $this->outletRepository = $outletRepo;
    }

    /**
     * Display a listing of the Outlet.
     * GET|HEAD /outlets
     *
     * @param Request $request
     * @return Response
     */
    public function route_wise_outlet(Request $request){
        $outlets = Outlet::select('id','outlet_id','name','owner_name','contact','address_id','latitude','longitude','sales_officer_id','distributor_id','image','town_id','route_id','channel_id','category_id','visit_frequency')->orderBy('name')->where('route_id',$request->route_id)->where('flag',0) ->get();
        $user=Auth::user()->salesOfficer_distributor->first();
        $routelog = RouteLog::create([
            'distributor_id' =>$user->pivot->distributor_id,
            'salesofficer_id' =>Auth::user()->id,
            'route' =>$request->route_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return $this->sendResponse($outlets->toArray(), 'Outlets retrieved successfully');
    }

    public function index(Request $request)
    {
        // dd($request->distributor_id);
        $outlets = Outlet::select('id','outlet_id','name','owner_name','contact','address_id','latitude','longitude','sales_officer_id','distributor_id','image','town_id','route_id','channel_id','category_id','visit_frequency')->orderBy('name')->where('distributor_id',$request->distributor_id)->where('flag',0)->with('routenames:id,routename','categories:id,category','channels:id,channel','towns:id,town,zone_id','towns.zone:id,zone')->get()->makeHidden(['image']);
        // $outlets = Outlet::orderBy('name')->where('distributor_id',$request->distributor_id)->where('flag',0)->with('routenames:id,routename','categories:id,category','channels:id,channel','towns:id,town,zone_id','towns.zone:id,zone','distributor:id,name')->get();
        // dd($outlets);
        return $this->sendResponse($outlets->toArray(), 'Outlets retrieved successfully');
    }
    public function distributor_route(Request $request){
        $dis_outlets = Outlet::where('distributor_id', $request->distributor_id)->distinct('route')->with('')->get('route');
        return $this->sendResponse($dis_outlets->toArray(), 'Distributors Outlets retrieved successfully');
    }
    
    public function getAddressList(Request $request)
    {
        $input = $request->all();

        if (array_key_exists('province_id', $input)) {
            $district = District::where('province_id', $input['province_id'])->get();
            return $this->sendResponse($district->toArray(), 'district retrieved successfully');
        } elseif (array_key_exists('district_id', $input)) {
            $area = Area::where('district_id', $input['district_id'])->get();
            return $this->sendResponse($area->toArray(), 'area retrieved successfully');
        } elseif (array_key_exists('area_id', $input)) {
            $street = Street::where('area_id', $input['area_id'])->get();
            return $this->sendResponse($street->toArray(), 'street retrieved successfully');
        }
    }
    /**
     * Store a newly created Outlet in storage.
     * POST /outlets
     *
     * @param CreateOutletAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // return 'f';

        $validator = Validator::make($request->all(), [
            
            'name' => 'required',
            'contact' => 'required',
            'owner_name' => 'required',
            'outlet_id'=>'required',
            'town_id'=>'required',
            'route_id'=>'required',
            'channel_id'=>'required',
            'category_id'=>'required',
            'visit_frequency'=>'required',
        ]);
         
        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }
        // $input['sales_officer_id'] = Auth::user()->id;
        if (isset($request->image)) {
            $file = base64_decode($request->image);
            // $file = $request->image;

            
            $folderName = '/dv_trading/public/storage/outlets/image/';
            $safeName =$request->ownername??"". Carbon::now()->timestamp . '.' . 'jpg';
            $destinationPath = $folderName . $safeName;
            // dd($safeName, $request->owner_name);
            $success = file_put_contents(storage_path() . '/app/public/outlets/image/' . $safeName, $file);
        }
        $outlet_data="";
        if(isset($request->id)){
            $outlet_data= Outlet::where('id',$request->id)->first();
        }
        $input=$request->all();
        $input['image']=$destinationPath??"";
        // dd($outlet_data);
        if(!empty($outlet_data))
        {
         //to create id for update
            $value=$outlet_data->id;
            $outlet_update= $this->outletRepository->update($input, $value);
            return $this->sendResponse($outlet_update->toArray(), 'Outlet updated successfully');
               
        }else{
            $outlet = $this->outletRepository->create($input);
            return $this->sendResponse($outlet->toArray(), 'Outlet saved successfully');
        }
        
    }

    /**
     * Display the specified Outlet.
     * GET|HEAD /outlets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Outlet $outlet */
        $outlet = $this->outletRepository->find($id);

        if (empty($outlet)) {
            return $this->sendError('Outlet not found');
        }

        return $this->sendResponse($outlet->toArray(), 'Outlet retrieved successfully');
    }

    /**
     * Update the specified Outlet in storage.
     * PUT/PATCH /outlets/{id}
     *
     * @param int $id
     * @param UpdateOutletAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOutletAPIRequest $request)
    {
        $input = $request->all();

        /** @var Outlet $outlet */
        $outlet = $this->outletRepository->find($id);

        if (empty($outlet)) {
            return $this->sendError('Outlet not found');
        }

        $outlet = $this->outletRepository->update($input, $id);

        return $this->sendResponse($outlet->toArray(), 'Outlet updated successfully');
    }

    /**
     * Remove the specified Outlet from storage.
     * DELETE /outlets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Outlet $outlet */
        $outlet = $this->outletRepository->find($id);

        if (empty($outlet)) {
            return $this->sendError('Outlet not found');
        }

        Sale::where('outlet_id', $id)->update([
            'outlet_id' => null
        ]);

        $outlet->delete();

        return $this->sendSuccess('Outlet deleted successfully');
    }
    public function getalloutlets(Request $request){
        $user=Auth::user()->salesOfficer_distributor->first();
        $outlet_list=Outlet::select('id','outlet_id','name', 'contact', 'latitude', 'longitude')->where('sales_officer_id',Auth::user()->id)->get();
        return $this->sendResponse($outlet_list->toArray(), 'User updated successfully');
    }
}
