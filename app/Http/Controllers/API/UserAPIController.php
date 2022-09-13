<?php

namespace App\Http\Controllers\API;

use Str;
use Carbon\Carbon;
use Response;
use App\Models\User;
use App\Models\OutletDeleteList;
use App\Models\Sale;
use App\Models\Outlet;
use App\Models\DayWiseRouteSetup;
use App\Models\Quotation;
use App\Models\RouteLog;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\RouteName;
use Illuminate\Support\Facades\DB;
use App\Models\Distributor;




/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }
        $user = User::where('phone', $request->phone)->whereIn('role', [3,4,5])->where('flag',0)->first();

        if (empty($user)) {
            return $this->sendError("User not found");
        }
        if($user->api_token==null){

            $token = Str::random(80);
            $user->api_token = $token;
        }
        $user->save();
        return $this->sendResponse($user->toArray(), 'Users login successfully');
    }
    public function getLocationList(Request $request)
    {
        $input = $request->all();

        if (array_key_exists('admin_id', $input)) {
            $md = User::where('admin_id', $input['admin_id'])->where('role', 2)->get();
            return $this->sendResponse($md->toArray(), 'md retrieved successfully');
        } elseif (array_key_exists('marketing_director_id', $input)) {
            $mm = User::where('marketing_director_id', $input['marketing_director_id'])->where('role', 3)->get();
            return $this->sendResponse($mm->toArray(), 'mm retrieved successfully');
        } elseif (array_key_exists('regionalmanager', $input)) {
            $db_users=Distributor::where('regionalmanager',$input['regionalmanager'])->pluck('sales_supervisor_id');
            $ss = User::whereIn('id', $db_users)->where('role', 3)->get();
            // $ss = User::where('regionalmanager', $input['regionalmanager'])->where('role', 3)->get();
            return $this->sendResponse($ss->toArray(), 'ss retrieved successfully');
        }elseif(array_key_exists('sales_supervisor_id', $input)){
            $distributor=Distributor::where('sales_supervisor_id',$input['sales_supervisor_id'])->first();
            $db_users=DB::table('distributor_user')->where('distributor_id',$distributor->id)->pluck('user_id');
            $dse = User::whereIn('id', $db_users)->where('role', 5)->get();
            return $this->sendResponse($dse->toArray(), 'DSE retrieved successfully');
        }elseif(array_key_exists('distributor', $input)){
            $routelist = RouteName::where('distributor_id', $input['distributor'])->get();
            return $this->sendResponse($routelist->toArray(), 'RouteList retrieved successfully');
        }elseif(array_key_exists('route_user', $input)){
            $user=User::where('name',$input['route_user'])->first();
            $user_route = DB::table('routename_user')->where('user_id', $user->id)->get();
            return $this->sendResponse($user_route->toArray(), 'User Route retrieved successfully');
        }elseif(array_key_exists('route_user_api', $input)){
            $user=User::where('name',$input['route_user_api'])->first();
            $user_route = DB::table('routename_user')->where('user_id', $user->id)->pluck('route_id');
            $route_list = DB::table('route_names')->whereIn('id', $user_route)->get();
            return $this->sendResponse($route_list->toArray(), 'User Route retrieved successfully');
        }elseif(array_key_exists('filterby', $input)){
           if(!empty($input['filterby'])){
                if($input['filterby']=="DSE"){
                    $data=User::where('role',5)->select('name','id')->get();
                }elseif($input['filterby']=="Sub D"){
                    $data=Distributor::select('name','id')->get();
                }elseif($input['filterby']=="Routewise"){
                    $data=Routename::select('routename as name','id')->get();
                }
                return $this->sendResponse($data->toarray(), 'User Route retrieved successfully');
           }else{
            return $this->sendResponse([], 'User Route retrieved successfully');
           }
        }
    }
    // public function getregionalmanager(Request $request)
    // {
    //     $regionalmanagers=User::where('role',4)->get();
    //     return $this->sendResponse($regionalmanagers->toArray(), 'regionalmanagers retrieved successfully');
    // }
    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        return $this->sendResponse($user->toArray(), 'User saved successfully');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendSuccess('User deleted successfully');
    }
    public function routelist(Request $request)
    {
            // $user=Auth::user()->salesOfficer_distributor->first();
            $assign_route_ids=DB::table('routename_user')->where('user_id',Auth::user()->id)->pluck('route_id');
            $routelist=RouteName::select('id','routename')->whereIn('id',$assign_route_ids)->get();

        return $this->sendResponse($routelist->toArray(), 'User updated successfully');
    }

    public function userReport($id)
    {
        $id = Auth::user()->id;
        $alltotalcall = 0;
        $allproductivity_call = 0;
        $allunsuccess_call = 0;
        $allremainingcall = 0;
        $allorderRecevied = 0;
        $month = 0;
        $value = 0;
        $allachivement = 0;

        if(Auth::user()->role == 3){

            $under_so_users = User::where('sales_supervisor_id', $id)->get();

            foreach ($under_so_users as $user) {
                $catch = $this->dse_users_find($user->id);

                $alltotalcall = $alltotalcall + $catch[0]['totalcall'];
                $allproductivity_call = $allproductivity_call + $catch[0]['productivity_call'];
                $allunsuccess_call = $allunsuccess_call + $catch[0]['unsuccess_call'];
                $allremainingcall = $allremainingcall + $catch[0]['remainingcall'];
                $allorderRecevied = $allorderRecevied + $catch[0]['orderRecevied'];
                $month = $month;
                $value = $value;
                $allachivement = $allachivement + $catch[0]['achivement'];

            }
            $arr = [
                [
                    'totalcall' => $alltotalcall, 
                    'productivity_call' => $allproductivity_call, 
                    'unsuccess_call' => $allunsuccess_call, 
                    'remainingcall' => $allremainingcall,
                    'orderRecevied' => $allorderRecevied, 
                    'month' => $month, 
                    'value' => $value, 
                    'achivement' => $allachivement
                ]
            ];
        }elseif(Auth::user()->role == 4){

            $under_rm_users = User::where('regionalmanager', $id)->get();

            foreach ($under_rm_users as $user) {
                $catch = $this->dse_users_find($user->id);

                $alltotalcall = $alltotalcall + $catch[0]['totalcall'];
                $allproductivity_call = $allproductivity_call + $catch[0]['productivity_call'];
                $allunsuccess_call = $allunsuccess_call + $catch[0]['unsuccess_call'];
                $allremainingcall = $allremainingcall + $catch[0]['remainingcall'];
                $allorderRecevied = $allorderRecevied + $catch[0]['orderRecevied'];
                $month = $month;
                $value = $value;
                $allachivement = $allachivement + $catch[0]['achivement'];
            }
            $arr = [
                [
                    'totalcall' => $alltotalcall, 
                    'productivity_call' => $allproductivity_call, 
                    'unsuccess_call' => $allunsuccess_call, 
                    'remainingcall' => $allremainingcall, 
                    'orderRecevied' => $allorderRecevied, 
                    'month' => $month, 
                    'value' => $value, 
                    'achivement' => $allachivement
                ]
            ];

        }else{

            $arr = $this->dse_users_find($id);

        }

        return $this->sendResponse($arr, 'Dashboard Report');
        
    }

    public function dse_users_find($id)
    {
        $routename = RouteLog::where('salesofficer_id', $id)->whereDate('created_at', 'like', '%' . Carbon::now()->format('Y-m-d') . '%')->get();
        $routename = $routename->unique('route');
        $route_array = $routename->pluck('route');

        $sales = Sale::where('sales_officer_id',$id)->whereDate('created_at', 'like', '%' . Carbon::now()->format('Y-m-d') . '%')->get();
        $totalcall = Outlet::whereIn('route_id',$route_array)->where('flag', 0)->get()->count();

        $productivity_call = $sales->where('product_id', '>', 0)->where('quantity', '>', 0)->unique('outlet_id')->count();
        $unsuccess_call = $sales->where('product_id', '=', 0)->where('quantity', '=', 0)->unique('outlet_id')->count();

        $outlets = Outlet::whereIn('route_id',$route_array)->get();

        $remainingcall = $outlets->where('flag', 0)->count()-$productivity_call-$unsuccess_call;

        $data = Sale::whereDate('sales.created_at', 'like', '%' . Carbon::now()->format('Y-m-d') . '%')
            ->where('sales_officer_id', $id)
            ->whereNotNull('product_id')
            ->groupBy(['product_id','products.value'])->join('products','products.id','=','sales.product_id')
            ->select('product_id','products.value', DB::raw('sum(quantity) as totalquantity'))
            ->get();
        $orderRecevied=0;

        foreach ($data as $value) {
            $orderRecevied+=$value->totalquantity*$value->value;
        }

        $target = Quotation::where(['user_id'=> $id, 'month' => \Carbon\Carbon::now()->format('M-Y')])->first();

        if(!isset($target)){
            $achivement = 0;
        }else{
            $achivement = $target->achieved;
        }


        if($achivement == null){
            $achivement = 0;
        }

        if(is_null($target)){
            $target['month'] = null;
            $target['value'] = null;
            $arr = [
                [
                'totalcall' => $totalcall, 
                'productivity_call' => $productivity_call, 
                'unsuccess_call' => $unsuccess_call, 
                'remainingcall' => $remainingcall, 
                'orderRecevied' => $orderRecevied, 
                'month' => $target['month'], 
                'value' => $target['value'], 
                'achivement' => $achivement
                ]
            ];
        }else{
            $arr = [
                [
                'totalcall' => $totalcall, 
                'productivity_call' => $productivity_call, 
                'unsuccess_call' => $unsuccess_call, 
                'remainingcall' => $remainingcall, 
                'orderRecevied' => $orderRecevied, 
                'month' => $target->month, 
                'value' => $target->value, 
                'achivement' => $achivement
                ]
            ];
        }

        return $arr;
    }

    public function outlet_delete_request(Request $request)
    {
        
        $nop = OutletDeleteList::where('outlet_id', $request->outlet_id)->first();
        
        if(!empty($nop)){
            return $this->sendError("Request Already Sent");
        }else{
            $outletDelete = OutletDeleteList::create($request->all()); 
            return $this->sendResponse($outletDelete->toArray(), 'Outlet Delete Request Send Successfully');
        }

    }

    public function day_wise_route()
    {
        $day = Carbon::now()->format('D');
        // dd($day);
        $data = DayWiseRouteSetup::where('user_id', Auth::user()->id)->where('day', 'like', '%' . $day .'%')->first();

        // dd($data);
        if(!empty($data)){
            $routename = RouteName::where('id', $data->route_id)->where('flag', 0)->select('id', 'routename')->first();
        }
        
        // dd($data->isEmpty());
        if(empty($routename)){
            return $this->sendError("No route Selected Assigned Now");
        }else{
            $route_data = [
                'id' =>  $routename->id,
                'routename' =>  $routename->routename,
                'day' =>  $data->day,
            ];
            return $this->sendResponse([$route_data], 'Day Wise Route Send Successfully');
        }
    }
}
