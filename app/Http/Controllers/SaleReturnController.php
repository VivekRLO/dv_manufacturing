<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SaleReturnRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateSaleReturnRequest;
use App\Http\Requests\UpdateSaleReturnRequest;
use App\Models\SaleReturn;

class SaleReturnController extends AppBaseController
{
    /** @var  SaleReturnRepository */
    private $saleReturnRepository;

    public function __construct(SaleReturnRepository $saleReturnRepo)
    {
        $this->saleReturnRepository = $saleReturnRepo;
    }

    /**
     * Display a listing of the SaleReturn.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $saleReturns = SaleReturn::orderBy('created_at','desc')->paginate(100);

        return view('sale_returns.index')
            ->with('saleReturns', $saleReturns);
    }

    /**
     * Show the form for creating a new SaleReturn.
     *
     * @return Response
     */
    public function create()
    {
        $products= Product::where('flag',0)->pluck('name','id');
        return view('sale_returns.create',compact('products'));
    }
    /**
     * Store a newly created SaleReturn in storage.
     *
     * @param CreateSaleReturnRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleReturnRequest $request)
    {
        $distributor_id = Distributor::where('userid', Auth::user()->id)->first()->id;
       
                $data['distributor_id'] = $distributor_id;
                $data['quantity'] = $request->quantity;
                $data['remarks'] =$request->remarks;
                $data['product_id'] = $request->product_id;
                $data['returndate'] = Carbon::now();
        $saleReturn = $this->saleReturnRepository->create($data);

        Flash::success('Sale Return saved successfully.');

        return redirect(route('saleReturns.index'));
    }

    /**
     * Display the specified SaleReturn.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $saleReturn = $this->saleReturnRepository->find($id);

        if (empty($saleReturn)) {
            Flash::error('Sale Return not found');

            return redirect(route('saleReturns.index'));
        }

        return view('sale_returns.show')->with('saleReturn', $saleReturn);
    }

    /**
     * Show the form for editing the specified SaleReturn.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $saleReturn = $this->saleReturnRepository->find($id);

        if (empty($saleReturn)) {
            Flash::error('Sale Return not found');

            return redirect(route('saleReturns.index'));
        }
        $products= Product::where('flag',0)->pluck('name','id');
        return view('sale_returns.edit',compact('products'))->with('saleReturn', $saleReturn);
    }

    /**
     * Update the specified SaleReturn in storage.
     *
     * @param int $id
     * @param UpdateSaleReturnRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleReturnRequest $request)
    {
        $saleReturn = $this->saleReturnRepository->find($id);

        if (empty($saleReturn)) {
            Flash::error('Sale Return not found');

            return redirect(route('saleReturns.index'));
        }
        $distributor_id = Distributor::where('userid', Auth::user()->id)->first()->id;
       
        $data['distributor_id'] = $distributor_id;
        $data['quantity'] = $request->quantity;
        $data['remarks'] =$request->remarks;
        $data['product_id'] = $request->product_id;
        $data['returndate'] = Carbon::now();
        $saleReturn = $this->saleReturnRepository->update($data, $id);

        Flash::success('Sale Return updated successfully.');

        return redirect(route('saleReturns.index'));
    }

    /**
     * Remove the specified SaleReturn from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $saleReturn = $this->saleReturnRepository->find($id);

        if (empty($saleReturn)) {
            Flash::error('Sale Return not found');

            return redirect(route('saleReturns.index'));
        }

        $this->saleReturnRepository->delete($id);

        Flash::success('Sale Return deleted successfully.');

        return redirect(route('saleReturns.index'));
    }

    public function create_bulk_entry(){
        $products= Product::where('flag',0)->pluck('name','id');
        return view('sale_returns.bulkreturn',compact('products'));
    }

    public function store_bulk_entry(Request $request){
        // $input=$request->all();
        // dd($input);
        $distributor_id = Distributor::where('userid', Auth::user()->id)->first()->id;
        $quantity = $request->returnquantity;
        $remarks = $request->remarks;
        $returndate = Carbon::now();
        foreach ($quantity as $product_id => $quant) {
            if ($quant > 0) {
                $data['distributor_id'] = $distributor_id;
                $data['quantity'] = $quantity[$product_id];
                $data['remarks'] = $remarks[$product_id];
                $data['product_id'] = $product_id;
                $data['returndate'] = $returndate;
                $sale = $this->saleReturnRepository->create($data);
            }
        }
        Flash::success('Sale Return Upload successfully.');

        return redirect(route('saleReturns.index'));
    }
}
