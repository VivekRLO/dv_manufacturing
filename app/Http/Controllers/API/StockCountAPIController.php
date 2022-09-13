<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateStockCountAPIRequest;
use App\Http\Requests\API\UpdateStockCountAPIRequest;
use App\Models\StockCount;
use App\Repositories\StockCountRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class StockCountController
 * @package App\Http\Controllers\API
 */

class StockCountAPIController extends AppBaseController
{
    /** @var  StockCountRepository */
    private $stockCountRepository;

    public function __construct(StockCountRepository $stockCountRepo)
    {
        $this->stockCountRepository = $stockCountRepo;
    }

    /**
     * Display a listing of the StockCount.
     * GET|HEAD /stockCounts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        $stockCounts = StockCount::where('distributor_id', $request->distributor_id)->orderBy('id', 'desc')->first();
        $temp="Record Not Found";
        if (isset($stockCounts)) {
            $temp=$stockCounts->type;
        }
        return $this->sendResponse($temp, 'Stock Counts retrieved successfully');
    }

    /**
     * Store a newly created StockCount in storage.
     * POST /stockCounts
     *
     * @param CreateStockCountAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStockCountAPIRequest $request)
    {
        $input['distributor_id'] = $request->distributor_id;
        $input['stock'] = $request->stock;
        $input['type'] = $request->type;
        $input['date'] = $request->date;
        $input['sale_officer_id'] = Auth::user()->id;


        $stockCount = $this->stockCountRepository->create($input);
        if ($input['type'] == 'Closing') {
            $data['distributor_id'] = $request->distributor_id;
            $data['stock'] = $request->stock;
            $data['type'] = "Opening";
            $data['date'] = Carbon::now();
            $data['sale_officer_id'] = Auth::user()->id;
            $stockCount = $this->stockCountRepository->create($data);
        }

        return $this->sendResponse($stockCount->toArray(), 'Stock Count saved successfully');
    }

    /**
     * Display the specified StockCount.
     * GET|HEAD /stockCounts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var StockCount $stockCount */
        $stockCount = $this->stockCountRepository->find($id);

        if (empty($stockCount)) {
            return $this->sendError('Stock Count not found');
        }

        return $this->sendResponse($stockCount->toArray(), 'Stock Count retrieved successfully');
    }

    /**
     * Update the specified StockCount in storage.
     * PUT/PATCH /stockCounts/{id}
     *
     * @param int $id
     * @param UpdateStockCountAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStockCountAPIRequest $request)
    {
        $input = $request->all();

        /** @var StockCount $stockCount */
        $stockCount = $this->stockCountRepository->find($id);

        if (empty($stockCount)) {
            return $this->sendError('Stock Count not found');
        }

        $stockCount = $this->stockCountRepository->update($input, $id);

        return $this->sendResponse($stockCount->toArray(), 'StockCount updated successfully');
    }

    /**
     * Remove the specified StockCount from storage.
     * DELETE /stockCounts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var StockCount $stockCount */
        $stockCount = $this->stockCountRepository->find($id);

        if (empty($stockCount)) {
            return $this->sendError('Stock Count not found');
        }

        $stockCount->delete();

        return $this->sendSuccess('Stock Count deleted successfully');
    }
    public function getdatelist(Request $request)
    {
        $distributor_id = $request->distributor_id;
        $dates = StockCount::where('distributor_id', $distributor_id)->select('id', 'type', 'date')->get();
        $opening = array();
        $closing = array();
        $datearray = [];

        // Redo

        $date_for_to = Carbon::now()->format('Y-m-d H:i:s');


        foreach ($dates as $date) {
            if ($date->type == "Opening") {
                array_push($opening, $date->date);
            }elseif ($date->type == "Closing") {
                array_push($closing, $date->date);
            }
        }
        if(sizeof($closing)<sizeof($opening)){
            array_push($closing, $date_for_to);
        }

        for ($i = 0; $i < sizeof($closing); $i++) {
            $datearray[$opening[$i]] = $closing[$i];
        }
        $datearray = json_encode($datearray);
        return $datearray;

    }
}
