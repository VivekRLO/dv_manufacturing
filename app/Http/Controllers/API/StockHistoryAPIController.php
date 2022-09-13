<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStockHistoryAPIRequest;
use App\Http\Requests\API\UpdateStockHistoryAPIRequest;
use App\Models\StockHistory;
use App\Repositories\StockHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class StockHistoryController
 * @package App\Http\Controllers\API
 */

class StockHistoryAPIController extends AppBaseController
{
    /** @var  StockHistoryRepository */
    private $stockHistoryRepository;

    public function __construct(StockHistoryRepository $stockHistoryRepo)
    {
        $this->stockHistoryRepository = $stockHistoryRepo;
    }

    /**
     * Display a listing of the StockHistory.
     * GET|HEAD /stockHistories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $stockHistories = $this->stockHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($stockHistories->toArray(), 'Stock Histories retrieved successfully');
    }

    /**
     * Store a newly created StockHistory in storage.
     * POST /stockHistories
     *
     * @param CreateStockHistoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStockHistoryAPIRequest $request)
    {
        $input = $request->all();

        $stockHistory = $this->stockHistoryRepository->create($input);

        return $this->sendResponse($stockHistory->toArray(), 'Stock History saved successfully');
    }

    /**
     * Display the specified StockHistory.
     * GET|HEAD /stockHistories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var StockHistory $stockHistory */
        $stockHistory = $this->stockHistoryRepository->find($id);

        if (empty($stockHistory)) {
            return $this->sendError('Stock History not found');
        }

        return $this->sendResponse($stockHistory->toArray(), 'Stock History retrieved successfully');
    }

    /**
     * Update the specified StockHistory in storage.
     * PUT/PATCH /stockHistories/{id}
     *
     * @param int $id
     * @param UpdateStockHistoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStockHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var StockHistory $stockHistory */
        $stockHistory = $this->stockHistoryRepository->find($id);

        if (empty($stockHistory)) {
            return $this->sendError('Stock History not found');
        }

        $stockHistory = $this->stockHistoryRepository->update($input, $id);

        return $this->sendResponse($stockHistory->toArray(), 'StockHistory updated successfully');
    }

    /**
     * Remove the specified StockHistory from storage.
     * DELETE /stockHistories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var StockHistory $stockHistory */
        $stockHistory = $this->stockHistoryRepository->find($id);

        if (empty($stockHistory)) {
            return $this->sendError('Stock History not found');
        }

        $stockHistory->delete();

        return $this->sendSuccess('Stock History deleted successfully');
    }
}
