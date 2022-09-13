<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\StockHistoryRepository;
use App\Http\Requests\CreateStockHistoryRequest;
use App\Http\Requests\UpdateStockHistoryRequest;
use App\Models\Batch;

class StockHistoryController extends AppBaseController
{
    /** @var  StockHistoryRepository */
    private $stockHistoryRepository;

    public function __construct(StockHistoryRepository $stockHistoryRepo)
    {
        $this->stockHistoryRepository = $stockHistoryRepo;
    }

    /**
     * Display a listing of the StockHistory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $stockHistories = StockHistory::orderBy('id', 'desc')->paginate(10);

        return view('stock_histories.index')
            ->with('stockHistories', $stockHistories);
    }

    /**
     * Show the form for creating a new StockHistory.
     *
     * @return Response
     */
    public function create()
    {
        return view('stock_histories.create');
    }

    /**
     * Store a newly created StockHistory in storage.
     *
     * @param CreateStockHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateStockHistoryRequest $request)
    {
        $previous_stock_history = StockHistory::where('batch_id', $request->batch_id)->where('distributor_id', $request->distributor_id)->latest()->first();
        //    dd($previous_stock_history);
        if($previous_stock_history==null){
            $total_stock_remaining_in_distributor=0;
        }else{              
            $total_stock_remaining_in_distributor= $previous_stock_history->total_stock_remaining_in_distributor;
        }
        $input['product_id'] = $request->product_id;
        $input['batch_id'] = $request->batch_id;
        $input['distributor_id'] = $request->distributor_id;
        $input['price'] = $request->price;
        $input['stock_in'] = $request->quantity;
        $input['total_stock_remaining_in_distributor'] = $total_stock_remaining_in_distributor + (int)$request->quantity;
        $stockHistory = $this->stockHistoryRepository->create($input);
        if ($stockHistory) {
            $batch = Batch::find($request->batch_id);
            $batch->stock = $batch->stock - $request->quantity;
            $batch->save();
        }


        Flash::success('Stock History saved successfully.');

        return redirect(route('batch_stock_history', $request->batch_id));
    }

    /**
     * Display the specified StockHistory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $stockHistory = $this->stockHistoryRepository->find($id);

        if (empty($stockHistory)) {
            Flash::error('Stock History not found');

            return redirect(route('stockHistories.index'));
        }

        return view('stock_histories.show')->with('stockHistory', $stockHistory);
    }

    /**
     * Show the form for editing the specified StockHistory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $stockHistory = $this->stockHistoryRepository->find($id);

        if (empty($stockHistory)) {
            Flash::error('Stock History not found');

            return redirect(route('stockHistories.index'));
        }

        return view('stock_histories.edit')->with('stockHistory', $stockHistory);
    }

    /**
     * Update the specified StockHistory in storage.
     *
     * @param int $id
     * @param UpdateStockHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStockHistoryRequest $request)
    {
        $stockHistory = $this->stockHistoryRepository->find($id);

        if (empty($stockHistory)) {
            Flash::error('Stock History not found');

            return redirect(route('stockHistories.index'));
        }

        $stockHistory = $this->stockHistoryRepository->update($request->all(), $id);

        Flash::success('Stock History updated successfully.');

        return redirect(route('stockHistories.index'));
    }

    /**
     * Remove the specified StockHistory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $stockHistory = $this->stockHistoryRepository->find($id);

        if (empty($stockHistory)) {
            Flash::error('Stock History not found');

            return redirect(route('stockHistories.index'));
        }

        $this->stockHistoryRepository->delete($id);

        Flash::success('Stock History deleted successfully.');

        return redirect(route('stockHistories.index'));
    }
    public function batch_stock_history($batch_id)
    {
        $batch = Batch::find($batch_id);
        $stockHistories = StockHistory::where('batch_id', $batch_id)->orderBy('id', 'desc')->paginate(10);
        return view('stock_histories.batch_stock_history', compact('batch'))->with('stockHistories', $stockHistories);
    }
}
