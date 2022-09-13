<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\StockCount;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\StockCountRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateStockCountRequest;
use App\Http\Requests\UpdateStockCountRequest;
use App\Models\SaleReturn;

class StockCountController extends AppBaseController
{
    /** @var  StockCountRepository */
    private $stockCountRepository;

    public function __construct(StockCountRepository $stockCountRepo)
    {
        $this->stockCountRepository = $stockCountRepo;
    }

    /**
     * Display a listing of the StockCount.
     *
     * @param Request $request
     *
     * @return Response
     */

    
    public function distributor_index(Request $request){
        $distributor=Distributor::where('userid',Auth::user()->id)->first();

        return view('stock_counts.distributorstockreport',compact('distributor'));
    } 
    public function index(Request $request)
    {
        $users = [];
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $distributors = Distributor::where('regionalmanager', Auth::user()->id)->where('flag', 0)->pluck('name', 'id');
            }
            //Admin
            else {
                $distributors = Distributor::where('manufacturer_trading_type', 1)->where('flag', 0)->pluck('name', 'id');
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $distributors = Distributor::where('regionalmanager', Auth::user()->id)->where('flag', 0)->pluck('name', 'id');
            }
            //Admin
            else {
                $distributors = Distributor::where('manufacturer_trading_type', 2)->where('flag', 0)->pluck('name', 'id');
            }
        }
        return view('stock_counts.stockcountreport', compact('distributors'));
    }

    /**
     * Show the form for creating a new StockCount.
     *
     * @return Response
     */
    public function create()
    {
        return view('stock_counts.create');
    }

    /**
     * Store a newly created StockCount in storage.
     *
     * @param CreateStockCountRequest $request
     *
     * @return Response
     */
    public function store(CreateStockCountRequest $request)
    {
        // $input = $request->all();
        $input['distributor_id'] = $request->distributor_id;
        $input['stock'] = $request->stock;
        $input['type'] = $request->type;
        $input['date'] = $request->date;
        $input['sale_officer_id'] = Auth::user()->id;

        // dd($input);

        $stockCount = $this->stockCountRepository->create($input);

        Flash::success('Stock Count saved successfully.');

        return redirect(route('stockCounts.index'));
    }

    /**
     * Display the specified StockCount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        // $stockCount = $this->stockCountRepository->find($id);

        $stockCount = StockCount::where('distributor_id', 1)->whereBetween('date', ['2021-09-01', '2021-09-03'])->get();
        $stockCount = $stockCount->groupby('type');

        $sales = Sale::where('distributor_id', 1)->whereBetween('date', ['2021-09-01', '2021-09-03'])->get();

        // foreach($stockCounts as $stockCount){

        // }
        if (empty($stockCount)) {
            Flash::error('Stock Count not found');

            return redirect(route('stockCounts.index'));
        }

        return view('stock_counts.show')->with('stockCount', $stockCount);
    }

    public function showreport(Request $request)
    {
        // dd($request->all());
        if ($request->date_from == "No record Found") {
            Flash::error('Please choice date in "Date from" field. Try Again with the valid input.');
            return redirect(route('stockCounts.index'));
        }
        $users = [];
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $distributors = Distributor::where('regionalmanager', Auth::user()->id)->where('flag', 0)->pluck('name', 'id');
            }
            //Admin
            else {
                $distributors = Distributor::where('manufacturer_trading_type', 1)->where('flag', 0)->pluck('name', 'id');
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $distributors = Distributor::where('regionalmanager', Auth::user()->id)->where('flag', 0)->pluck('name', 'id');
            }
            //Admin
            else {
                $distributors = Distributor::where('manufacturer_trading_type', 2)->where('flag', 0)->pluck('name', 'id');
            }
        }

        $input['date_to'] = $request->date_to;
        if($input['date_to'] == null){
            $input['date_to'] == Carbon::now()->format('Y-m-d');
        }
        $input['date_from'] = $request->date_from;
        $input['distributor_id'] = $request->distributor;
        $stockCount = StockCount::where('distributor_id', $input['distributor_id'])->whereBetween('date', [$input['date_from'], $input['date_to']])->get();
        $stockCount = $stockCount->groupby('type');
        // dd($stockCount);
        $sales = Sale::where('distributor_id', $input['distributor_id'])->whereBetween('sold_at', [$input['date_from'], $input['date_to']])->get();
        $sales = $sales->groupby('product_id');
        $salesarray = [];
        foreach ($sales as $key => $sale) {
            $product_quantity = 0;
            foreach ($sale as $temp) {
                $product_quantity += $temp->quantity;
            }
            $salesarray[$key] = $product_quantity;
        }

        $salesdistributor = Sale::where('distributor_id', $input['distributor_id'])->whereBetween('sold_at', [$input['date_from'], $input['date_to']])->whereNull('sales_officer_id')->get();
        $salesdistributor = $salesdistributor->groupby('product_id');

        $distributorsalesarray = [];
        foreach ($salesdistributor as $key => $sale) {
            $product_quantity = 0;
            foreach ($sale as $temp) {
                $product_quantity += $temp->quantity;
            }
            $distributorsalesarray[$key] = $product_quantity;
        }

        $salesreturn=SaleReturn::where('distributor_id', $input['distributor_id'])->whereBetween('returndate', [$input['date_from'], $input['date_to']])->get();
        $salesreturn = $salesreturn->groupby('product_id');
        $salesreturnarray = [];
        foreach ($salesreturn as $key => $sale) {
            $product_quantity = 0;
            foreach ($sale as $temp) {
                $product_quantity += $temp->quantity;
            }
            $salesreturnarray[$key] = $product_quantity;
        }

        
        // if(isset($stockCount['Purchase'])){
        //     return view('stock_counts.stockcountreport',compact('salesarray'))->with('stockCount', $stockCount);
        // }
        // else{
        //     return redirect(route('stockreport'));
        // }
        return view('stock_counts.stockcountreport', compact('salesarray', 'input', 'distributors','distributorsalesarray','salesreturnarray'))->with('stockCount', $stockCount);

    }

    public function search_stockreport_distributor(Request $request)
    {
        if ($request->date_from == "No record Found") {
            Flash::error('Please choice date in "Date from" field. Try Again with the valid input.');
            return redirect(route('stockCounts.distributor_index'));
        }
        $input['date_to'] = $request->date_to;
        $input['date_from'] = $request->date_from;
        $input['distributor_id'] = $request->distributor;
        $stockCount = StockCount::where('distributor_id', $input['distributor_id'])->whereBetween('date', [$input['date_from'], $input['date_to']])->get();
        $stockCount = $stockCount->groupby('type');
        $sales = Sale::where('distributor_id', $input['distributor_id'])->whereBetween('sold_at', [$input['date_from'] . " 00:00:00", $input['date_to'] . " 23:59:59"])->get();
        $sales = $sales->groupby('product_id');
        $salesarray = [];
        foreach ($sales as $key => $sale) {
            $product_quantity = 0;
            foreach ($sale as $temp) {
                $product_quantity += $temp->quantity;
            }
            $salesarray[$key] = $product_quantity;
        }
        $salesdistributor = Sale::where('distributor_id', $input['distributor_id'])->whereBetween('sold_at', [$input['date_from'] . " 00:00:00", $input['date_to'] . " 23:59:59"])->whereNull('sales_officer_id')->get();
        $salesdistributor = $salesdistributor->groupby('product_id');

        $distributorsalesarray = [];
        foreach ($salesdistributor as $key => $sale) {
            $product_quantity = 0;
            foreach ($sale as $temp) {
                $product_quantity += $temp->quantity;
            }
            $distributorsalesarray[$key] = $product_quantity;
        }

        $salesreturn=SaleReturn::where('distributor_id', $input['distributor_id'])->whereBetween('returndate', [$input['date_from'] . " 00:00:00", $input['date_to'] . " 23:59:59"])->get();
        $salesreturn = $salesreturn->groupby('product_id');
        $salesreturnarray = [];
        foreach ($salesreturn as $key => $sale) {
            $product_quantity = 0;
            foreach ($sale as $temp) {
                $product_quantity += $temp->quantity;
            }
            $salesreturnarray[$key] = $product_quantity;
        }
        $distributor=Distributor::where('userid',Auth::user()->id)->first();
        return view('stock_counts.distributorstockreport', compact('salesarray', 'input', 'distributor','distributorsalesarray','salesreturnarray'))->with('stockCount', $stockCount);

    }
    /**
     * Show the form for editing the specified StockCount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $stockCount = $this->stockCountRepository->find($id);

        if (empty($stockCount)) {
            Flash::error('Stock Count not found');

            return redirect(route('stockCounts.index'));
        }

        return view('stock_counts.edit')->with('stockCount', $stockCount);
    }

    /**
     * Update the specified StockCount in storage.
     *
     * @param int $id
     * @param UpdateStockCountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStockCountRequest $request)
    {
        $stockCount = $this->stockCountRepository->find($id);

        if (empty($stockCount)) {
            Flash::error('Stock Count not found');

            return redirect(route('stockCounts.index'));
        }

        $stockCount = $this->stockCountRepository->update($request->all(), $id);

        Flash::success('Stock Count updated successfully.');

        return redirect(route('stockCounts.index'));
    }

    /**
     * Remove the specified StockCount from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $stockCount = $this->stockCountRepository->find($id);

        if (empty($stockCount)) {
            Flash::error('Stock Count not found');

            return redirect(route('stockCounts.index'));
        }

        $this->stockCountRepository->delete($id);

        Flash::success('Stock Count deleted successfully.');

        return redirect(route('stockCounts.index'));
    }
}
