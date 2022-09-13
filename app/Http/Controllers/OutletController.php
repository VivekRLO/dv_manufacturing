<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\User;
use App\Models\Zone;
use App\Models\Outlet;
use App\Models\OutletDeleteList;
use App\Models\Address;
use App\Models\Channel;
use App\Models\Category;
use App\Models\Sale;
use App\Models\Distributor;
use Illuminate\Http\Request;
use App\Imports\OutletsImport;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\OutletRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateOutletRequest;
use App\Http\Requests\UpdateOutletRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Town;

use Carbon\Carbon;

class OutletController extends AppBaseController
{
    /** @var  OutletRepository */
    private $outletRepository;

    public function __construct(OutletRepository $outletRepo)
    {
        $this->outletRepository = $outletRepo;
    }

    /**
     * Display a listing of the Outlet.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
    
        //Trading
            //RegionalManager
            if (Auth::user()->role == 4) {
                $distributor=Distributor::where('regionalmanager',Auth::user()->id)->pluck('id');
                // $outlets = Outlet::whereIn('distributor_id', $distributor)->where('flag', 0)->get();
                $outlets = Outlet::whereIn('distributor_id', $distributor)->where('flag', 0)->paginate(50);
            }
            //Admin
            else {
                // $outlets = Outlet::where('flag', 0)->get();
                $outlets = Outlet::where('flag', 0)->paginate(50);
            }
            
            $towns = Town::all();
            $channels = Channel::all();
            $dses = User::where('role', 5)->get();

            $route_id = null;
       
            return view('outlets.index', compact('outlets', 'towns', 'channels', 'dses', 'route_id'));
    }

    /**
     * Show the form for creating a new Outlet.
     *
     * @return Response
     */
    public function create()
    {
        // dd('hey');
        $provinces = Address::groupBy('province')->pluck('province', 'province');
        $zones=Zone::pluck('zone','id');
        $channels=Channel::pluck('channel','id');
        $categories=Category::pluck('category','id');
        return view('outlets.create', compact('provinces','zones','categories','channels'));
    }

    /**
     * Store a newly created Outlet in storage.
     *
     * @param CreateOutletRequest $request
     *
     * @return Response
     */
    public function store(CreateOutletRequest $request)
    {
        $input = $request->all();

        // dd($input);

        $outlet = $this->outletRepository->create($input);

        Flash::success('Outlet saved successfully.');

        return redirect()->back();
    }

    /**
     * Display the specified Outlet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $outlet = $this->outletRepository->find($id);

        $order_of_the_month = Sale::where('outlet_id', $id)->where('product_id', '>', 0)->whereBetween('sold_at', [Carbon::now()->firstOfMonth(), Carbon::now()])->orderBy('sold_at', 'desc')->get();

        if (empty($outlet)) {
            Flash::error('Outlet not found');

            return redirect(route('outlets.index'));
        }

        return view('outlets.show', compact('order_of_the_month', 'outlet'));
    }

    /**
     * Show the form for editing the specified Outlet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $outlet = $this->outletRepository->find($id);
        if (empty($outlet)) {
            Flash::error('Outlet not found');
            return redirect(route('outlets.index'));
        }
        $provinces = Address::groupBy('province')->pluck('province', 'province');
        $zones=Zone::pluck('zone','id');
        $channels=Channel::pluck('channel','id');
        $categories=Category::pluck('category','id');
        return view('outlets.edit', compact('provinces','zones','categories','channels'))->with('outlet', $outlet);
    }

    /**
     * Update the specified Outlet in storage.
     *
     * @param int $id
     * @param UpdateOutletRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOutletRequest $request)
    {
        //  dd($request->all());
        // $address_id=Address::where('local_level_en',$request->address_id)->first()->id;
        // dd($address_id);
        $outlet = $this->outletRepository->find($id);
        $input['name'] = $request->name;
        $input['owner_name'] = $request->owner_name;
        $input['address_id'] = $request->address_id;
        $input['street'] = $request->street;
        $input['contact'] = $request->contact;
        $input['latitude'] = $request->latitude;
        $input['longitude'] = $request->longitude;
        $input['distributor_id'] = $request->distributor_id;
        $input['town_id'] = $request->town_id;
        $input['route_id'] = $request->route_id;
        $input['channel_id'] = $request->channel_id;
        $input['category_id'] = $request->category_id;
        $input['sales_officer_id'] = $request->sales_officer_id;
        $input['visit_frequency'] = $request->visit_frequency;
        // $input['type'] = $request->type;
        if (empty($outlet)) {
            Flash::error('Outlet not found');

            return redirect(route('outlets.index'));
        }

        $outlet = $this->outletRepository->update($input, $id);

        Flash::success('Outlet updated successfully.');

        return redirect(route('outlets.index'));
    }

    /**
     * Remove the specified Outlet from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $outlet = $this->outletRepository->find($id);

        if (empty($outlet)) {
            Flash::error('Outlet not found');

            return redirect(route('outlets.index'));
        }
        $input['flag'] = 1;
        $this->outletRepository->delete($id);

        $deleteRequest = OutletDeleteList::where('outlet_id', $id)->where('flag', 0)->first();
        
        if(!isset($deleteRequest) || !empty($deleteRequest)){
            // dd($id, $deleteRequest);
            OutletDeleteList::where('outlet_id', $deleteRequest->outlet_id)->delete();
        }

        Flash::success('Outlet deleted successfully.');

        return redirect()->back();
    }

    public function getoutlets($long, $lat)
    {

        $outlet = Outlet::where('longitude', $long)->where('latitude', $lat)->first();
        if (empty($outlet)) {
            return 'Outlet Name Not Found';
        }
        return $outlet->name;
    }


    public function fileImportExport()
    {
        return view('outlets.bulk_create');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImport(Request $request)
    {
        $validated = $request->validate([
            'outletsExcel' => 'required|mimes:csv,xlsx',
        ]);
        Excel::import(new OutletsImport, $request->file('outletsExcel')->store('temp'));
        Flash::success('Outlets import successfully.');

        return redirect(route('outlets.index'));
    }

    public function outlet_filter(Request $request)
    {

        $town = $request->town_id;
        $channel = $request->channel_id;
        $dse = $request->dse_id;
        $route_id = $request->route_id;

        $outlets = Outlet::where('route_id', $route_id)->where('town_id', 'LIKE', $town)->where('channel_id', 'LIKE', $channel)->where('sales_officer_id', 'LIKE', $dse)->paginate(50);

        $towns = Town::all();
        $channels = Channel::all();
        $dses = User::where('role', 5)->get();
       
        return view('outlets.index', compact('outlets', 'towns', 'channels', 'dses', 'route_id'));
    }

    public function outlet_filter_by_id($id)
    {
        // dd($id);

        $outlets = Outlet::where('id', $id)->paginate(50);

        $towns = Town::all();
        $channels = Channel::all();
        $dses = User::where('role', 5)->get();

        $route_id = 0;
       
        return view('outlets.index', compact('outlets', 'towns', 'channels', 'dses', 'route_id'));
    }

    public function flagUpdate($id)
    {
        $data = Outlet::where('id', $id)->update([
            'flag' => 1,
        ]);
        return response()->json($data, 200);
    }

    public function changeRoute($id, $to)
    {
        $data = Outlet::where('id', $id)->update([
            'route_id' => $to,
        ]);
        return response()->json($data, 200);
    }

    public function outlet_remove()
    {
        $data = OutletDeleteList::where('flag', 0)->get();

        return view('outlets.outlet_delete_request', compact('data'));
    }

    public function outlet_destroy($id)
    {
        $deleteRequest = OutletDeleteList::where('outlet_id', $id)->where('flag', 0)->first();
        
        if(!isset($deleteRequest) || !empty($deleteRequest)){
            OutletDeleteList::where('outlet_id', $deleteRequest->outlet_id)->delete();
        }

        Flash::success('Request Ignored');

        return redirect()->back();
    }

    public function outlet_filter_by_order($id)
    {
        # code...
    }

}
