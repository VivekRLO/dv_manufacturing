<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateSaleAPIRequest;
use App\Http\Requests\API\UpdateSaleAPIRequest;
use App\Models\Outlet;
use App\Models\Quotation;
use App\Models\Sale;
use App\Models\Product;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Response;

/**
 * Class SaleController
 * @package App\Http\Controllers\API
 */

class SaleAPIController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sale.
     * GET|HEAD /sales
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sales_officer_id = Auth::user()->id;
        $sales = Sale::where('sales_officer_id', '=', $sales_officer_id)->orderBy('id', 'desc')->get();

        return $this->sendResponse($sales->toArray(), 'Sales Report retrieved successfully');
    }
    public function json_decode_multi($s, $assoc = false, $depth = 512, $options = 0)
    {
        if (substr($s, -1) == ',') {
            $s = substr($s, 0, -1);
        }

        return json_decode("[$s]", $assoc, $depth, $options);
    }

    /**
     * Store a newly created Sale in storage.
     * POST /sales
     *
     * @param CreateSaleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleAPIRequest $request)
    {
        // dd();
        $validator = Validator::make($request->all(), [
            'sold_at' => 'required',
            'outlet_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }
        $user=Auth::user()->salesOfficer_distributor->first();
        $input['distributor_id'] = $user->pivot->distributor_id;
        $input['outlet_id'] = $request->outlet_id;
        if(isset($input['outlet_id'])){
            
            $input['route_id'] =Outlet::find($input['outlet_id'])->route_id;
            $id = Outlet::find($input['outlet_id'])->id;
            
            $input['longitude'] =  $request->longitude;
            $input['latitude'] =  $request->latitude;
            
            // dd($input['outlet_id'], $id);
            Outlet::where('id', $id)->orwhere('outlet_id', $input['outlet_id'])->update([
                'longitude' => $input['longitude'],
                'latitude' => $input['latitude'],
            ]);
        }
        $input['sold_at'] = $request->sold_at;
        $input['sales_officer_id'] = Auth::user()->id;
        $input['remarks'] =$request->remarks;


        $achieved = Quotation::where('user_id', Auth::user()->id)->where('month', Carbon::now()->format('M-Y'))->first();

        if (isset($request->remarks_image)) {
            $file = base64_decode($request->image);
            $folderName = '/storage/sales/remarksimage/';
            $safeName =Auth::user()->id. Carbon::now()->timestamp . '.' . 'jpeg';
            $destinationPath = $folderName . $safeName;
            $success = file_put_contents(storage_path() . '/app/public/sales/remarksimage/' . $safeName, $file);
        }
        $input['remarks_image']=$destinationPath??"";
        $data = $input;
        $quantity = 0;
        $data['orders'] = $request->orders;
        if(isset($request->orders)){
            $decodedArray = json_decode($request->orders, true);
            // dd($decodedArray, count($decodedArray));
            for ($i = 0; $i < count($decodedArray); $i++) {
                $input['product_id'] = (int) $decodedArray[$i]['product_id'];
                $input['quantity'] = (int) $decodedArray[$i]['quantity'];
                if($input['product_id'] != 0){
                    $product = Product::where('id', $input['product_id'])->select('value')->first();
                    $quantity = $quantity + $input['quantity'] * (int) $product->value;
                }
                $input['discount'] = (int) $decodedArray[$i]['discount'];
                if($decodedArray[$i]['batch_id']){
                    $input['batch_id'] = (int) $decodedArray[$i]['batch_id'];
                }
                $sale = $this->saleRepository->create($input);
            }
            if($achieved != null){
                $value = $quantity + $achieved->achieved;
                // dd($achieved->id, $value);
                Quotation::where('id', $achieved->id)->update([
                    'achieved' => $value,
                ]);
            }
        }else{
            $sale = $this->saleRepository->create($input);
        }

        return $this->sendResponse($sale, 'Sales saved successfully');
        // return $this->sendResponse($sale, 'Sales saved successfully product = '. $input['product_id']);
    }

    /**
     * Display the specified Sale.
     * GET|HEAD /sales/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);


        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        return $this->sendResponse($sale->toArray(), 'Sale retrieved successfully');
    }

    /**
     * Update the specified Sale in storage.
     * PUT/PATCH /sales/{id}
     *
     * @param int $id
     * @param UpdateSaleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleAPIRequest $request)
    {
        $input = $request->all();

        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        $sale = $this->saleRepository->update($input, $id);

        return $this->sendResponse($sale->toArray(), 'Sale updated successfully');
    }

    /**
     * Remove the specified Sale from storage.
     * DELETE /sales/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        $sale->delete();

        return $this->sendSuccess('Sale deleted successfully');
    }

}
