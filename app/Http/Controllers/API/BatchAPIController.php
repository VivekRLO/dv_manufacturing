<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBatchAPIRequest;
use App\Http\Requests\API\UpdateBatchAPIRequest;
use App\Models\Batch;
use App\Repositories\BatchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class BatchController
 * @package App\Http\Controllers\API
 */

class BatchAPIController extends AppBaseController
{
    /** @var  BatchRepository */
    private $batchRepository;

    public function __construct(BatchRepository $batchRepo)
    {
        $this->batchRepository = $batchRepo;
    }

    /**
     * Display a listing of the Batch.
     * GET|HEAD /batches
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $batches = $this->batchRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($batches->toArray(), 'Batches retrieved successfully');
    }

    /**
     * Store a newly created Batch in storage.
     * POST /batches
     *
     * @param CreateBatchAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateBatchAPIRequest $request)
    {
        $input = $request->all();

        $batch = $this->batchRepository->create($input);

        return $this->sendResponse($batch->toArray(), 'Batch saved successfully');
    }

    /**
     * Display the specified Batch.
     * GET|HEAD /batches/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Batch $batch */
        $batch = $this->batchRepository->find($id);

        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        return $this->sendResponse($batch->toArray(), 'Batch retrieved successfully');
    }

    /**
     * Update the specified Batch in storage.
     * PUT/PATCH /batches/{id}
     *
     * @param int $id
     * @param UpdateBatchAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBatchAPIRequest $request)
    {
        $input = $request->all();

        /** @var Batch $batch */
        $batch = $this->batchRepository->find($id);

        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        $batch = $this->batchRepository->update($input, $id);

        return $this->sendResponse($batch->toArray(), 'Batch updated successfully');
    }

    /**
     * Remove the specified Batch from storage.
     * DELETE /batches/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Batch $batch */
        $batch = $this->batchRepository->find($id);

        if (empty($batch)) {
            return $this->sendError('Batch not found');
        }

        $batch->delete();

        return $this->sendSuccess('Batch deleted successfully');
    }
}
