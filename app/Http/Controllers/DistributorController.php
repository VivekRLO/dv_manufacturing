<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\User;
use App\Models\Zone;
use App\Models\Town;
use App\Models\Distributor;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\DistributorsImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DistributorRepository;
use App\Http\Requests\CreateDistributorRequest;
use App\Http\Requests\UpdateDistributorRequest;

class DistributorController extends AppBaseController
{
    /** @var  DistributorRepository */
    private $distributorRepository;

    public function __construct(DistributorRepository $distributorRepo)
    {
        $this->distributorRepository = $distributorRepo;
    }

    /**
     * Display a listing of the Distributor.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = [];
        
        //RegionalManager
        if (Auth::user()->role == 4) {
            $distributors = Distributor::where('regionalmanager', Auth::user()->id)->where('flag', 0)->with('distributor_salesOfficer')->paginate(20);
        }
        //Admin
        else {
            $distributors = Distributor::where('manufacturer_trading_type', 1)->where('flag', 0)->with('distributor_salesOfficer')->paginate(20);
        }

        return view('distributors.index')
            ->with('distributors', $distributors);
    }

    /**
     * Show the form for creating a new Distributor.
     *
     * @return Response
     */
    public function create()
    {
        $regionalmanager = User::where('role', 4)->where('flag', 0)->pluck('name', 'id');
        $sales_supervisor = User::where('role', 3)->where('flag', 0)->pluck('name', 'id');
        $sales_officer_id = User::where('role', 5)->where('flag', 0)->pluck('name', 'id');
        $zones=Zone::pluck('zone','id');
        $towns=Town::pluck('town','id');
        return view('distributors.create', compact('sales_officer_id', 'regionalmanager', 'sales_supervisor','zones','towns'));
    }

    /**
     * Store a newly created Distributor in storage.
     *
     * @param CreateDistributorRequest $request
     *
     * @return Response
     */
    public function store(CreateDistributorRequest $request)
    {
        // $input = $request->all();
        $input['name'] = $request->name;
        $input['owner_name'] = $request->owner_name;
        $input['pan_no'] = $request->pan_no;
        $input['email'] = $request->email;
        $input['contact'] = $request->contact;
        $input['location'] = $request->location;
        $input['zone_id'] = $request->zone_id;
        $input['town_id'] = $request->town_id;

        $input['regionalmanager'] = $request->regionalmanager;
        $input['sales_supervisor_id'] = $request->sales_supervisor_id;
        $input['manufacturer_trading_type'] = Auth::user()->type;

        // dd($request->all());
        $distributor = $this->distributorRepository->create($input);

        if (!empty($request->sales_officer_id)) {
            $salesOfficer = array_values($request->sales_officer_id);
            $distributor->distributor_salesOfficer()->sync($salesOfficer);
        }

        Flash::success('Distributor saved successfully.');

        return redirect(route('distributors.index'));
    }

    /**
     * Display the specified Distributor.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('distributors.index'));
        }

        return view('distributors.show')->with('distributor', $distributor);
    }

    /**
     * Show the form for editing the specified Distributor.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('distributors.index'));
        }
        $regionalmanager = User::where('role', 4)->where('flag', 0)->pluck('name', 'id');
        $sales_supervisor = User::where('role', 3)->where('flag', 0)->pluck('name', 'id');
        $sales_officer_id = User::where('role', 5)->where('flag', 0)->pluck('name', 'id');
        $zones=Zone::pluck('zone','id');
        $towns=Town::pluck('town','id');


        $existing_sales_officer=$distributor->distributor_salesOfficer()->pluck('user_id');
        return view('distributors.edit', compact('sales_officer_id', 'regionalmanager', 'sales_supervisor','existing_sales_officer','zones','towns'))->with('distributor', $distributor);
    }

    /**
     * Update the specified Distributor in storage.
     *
     * @param int $id
     * @param UpdateDistributorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistributorRequest $request)
    {
        // dd($request->all());
        $distributor = $this->distributorRepository->find($id);
        //  dd($request->all());
        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('distributors.index'));
        }

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['contact'] = $request->contact;
        $input['location'] = $request->location;
        $input['owner_name'] = $request->owner_name;
        $input['pan_no'] = $request->pan_no;
        $input['zone_id'] = $request->zone_id;
        $input['town_id'] = $request->town_id;

        $input['regionalmanager'] = $request->regionalmanager;
        $input['sales_supervisor_id'] = $request->sales_supervisor_id;
        
// dd("check");
        $distributor = $this->distributorRepository->update($input, $id);

        if (empty($request->sales_officer_id)) {
            $distributor->distributor_salesOfficer()->detach();
        } else {
            $salesOfficer = array_values($request->sales_officer_id);
            $distributor->distributor_salesOfficer()->sync($salesOfficer);
            User::whereIn('id', $request->sales_officer_id)->update([
                'regionalmanager' => $input['regionalmanager'],
                'sales_supervisor_id' => $input['sales_supervisor_id'],
            ]);
        }
        Flash::success('Distributor updated successfully.');

        return redirect(route('distributors.index'));
    }

    /**
     * Remove the specified Distributor from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            Flash::error('Distributor not found');

            return redirect(route('distributors.index'));
        }
        $input['flag'] = 1;
        $this->distributorRepository->update($input, $id);

        Flash::success('Distributor deleted successfully.');

        return redirect(route('distributors.index'));
    }
    public function fileImportExport()
    {
        return view('distributors.bulk_create');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImport(Request $request)
    {
        $validated = $request->validate([
            'distributorExcel' => 'required|mimes:csv,xlsx',
        ]);
        Excel::import(new DistributorsImport, $request->file('distributorExcel')->store('temp'));
        Flash::success('Distributor import successfully.');

        return redirect(route('distributors.index'));
    }

    public function product_list()
    {
        // $distributor_id= Distributor::where('userid', Auth::user()->id)->first()->id;
        // dd($distributor_id);
        $products = DB::table('stock_histories')
            ->rightJoin('products AS pro', function ($join) {
                $join->on('pro.id', '=', 'stock_histories.product_id')
                    ->where('stock_histories.distributor_id', Distributor::where('userid', Auth::user()->id)->first()->id)
                    ->where('pro.flag',0);
            })
            ->leftJoin('batches','batches.id','stock_histories.batch_id')
            ->select('pro.id','pro.name','pro.brand_name','pro.catalog','pro.unit','stock_histories.total_stock_remaining_in_distributor','batches.expired_at','batches.manufactured_at','stock_histories.price')
            ->get();
            // dd($products);
            $result=collect($products)->groupBy('id');
// dd($result);
            return view('distributors.product_list',compact('result'));

    }
    public function dse_assign_route(Request $request){

        $user=User::where('name',$request->dse_name)->first();
        $routelist = array_values($request->routelist);
        $user->route_users()->sync($routelist);
        Flash::success('Route Assign successfully.');

        return redirect(route('distributors.index'));
    }

    public function distributors_filter($id)
    {
        $users = [];
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $distributors = Distributor::where('regionalmanager', Auth::user()->id)->where('flag', 0)->where('id', $id)->with('distributor_salesOfficer')->paginate(20);
            }
            //Admin
            else {
                $distributors = Distributor::where('manufacturer_trading_type', 1)->where('flag', 0)->where('id', $id)->with('distributor_salesOfficer')->paginate(20);
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $distributors = Distributor::where('regionalmanager', Auth::user()->id)->where('id', $id)->where('flag', 0)->with('distributor_salesOfficer')->paginate(20);
            }
            //Admin
            else {
                $distributors = Distributor::where('manufacturer_trading_type', 2)->where('id', $id)->where('flag', 0)->with('distributor_salesOfficer')->paginate(20);
            }
        }

        return view('distributors.index')
            ->with('distributors', $distributors);
    }
}
