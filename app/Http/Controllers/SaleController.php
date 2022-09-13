<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Distributor;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Repositories\SaleRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class SaleController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sale.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == "6") {
            $distributor = Distributor::where('userid', Auth::user()->id)->first();
            $sales = Sale::where('distributor_id', $daily->id)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $sales = Sale::orderBy('created_at', 'desc')->paginate(10);

        }
        return view('sales.index')
            ->with('sales', $sales);

    }

    /**
     * Show the form for creating a new Sale.
     *
     * @return Response
     */
    public function create()
    {
        $products = Product::where('flag', 0)->pluck('name', 'id');
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created Sale in storage.
     *
     * @param CreateSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleRequest $request)
    {
        $distributor_id = Distributor::where('userid', Auth::user()->id)->first()->id;
        $quantity = $request->quantity;
        $scheme = $request->scheme;
        $discount = $request->discount;

        foreach ($quantity as $product_id => $quant) {
            if ($quant > 0) {
                $data['distributor_id'] = $distributor_id;
                $data['quantity'] = $quantity[$product_id];
                $data['discount'] = $discount[$product_id];
                $data['scheme'] = $scheme[$product_id];
                $data['product_id'] = $product_id;
                $data['sold_at'] = $request->sold_at;
                $data['sold_to'] = $request->sold_to;
                $sale = $this->saleRepository->create($data);
            }
        }
        Flash::success('Sale saved successfully.');
        return redirect(route('sales.index'));
    }

    /**
     * Display the specified Sale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('sales.index'));
        }

        return view('sales.show')->with('sale', $sale);
    }

    /**
     * Show the form for editing the specified Sale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('sales.index'));
        }

        return view('sales.edit')->with('sale', $sale);
    }

    /**
     * Update the specified Sale in storage.
     *
     * @param int $id
     * @param UpdateSaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleRequest $request)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('sales.index'));
        }

        $sale = $this->saleRepository->update($request->all(), $id);

        Flash::success('Sale updated successfully.');

        return redirect(route('sales.index'));
    }

    /**
     * Remove the specified Sale from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('sales.index'));
        }

        $this->saleRepository->delete($id);

        Flash::success('Sale deleted successfully.');

        return redirect(route('sales.index'));
    }
}
