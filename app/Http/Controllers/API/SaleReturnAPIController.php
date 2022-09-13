<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSaleReturnAPIRequest;
use App\Http\Requests\API\UpdateSaleReturnAPIRequest;
use App\Models\SaleReturn;
use App\Repositories\SaleReturnRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SaleReturnController
 * @package App\Http\Controllers\API
 */

class SaleReturnAPIController extends AppBaseController
{
    /** @var  SaleReturnRepository */
    private $saleReturnRepository;

    public function __construct(SaleReturnRepository $saleReturnRepo)
    {
        $this->saleReturnRepository = $saleReturnRepo;
    }

    /**
     * Display a listing of the SaleReturn.
     * GET|HEAD /saleReturns
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $saleReturns = $this->saleReturnRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($saleReturns->toArray(), 'Sale Returns retrieved successfully');
    }

    /**
     * Store a newly created SaleReturn in storage.
     * POST /saleReturns
     *
     * @param CreateSaleReturnAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleReturnAPIRequest $request)
    {
        $input = $request->all();

        $saleReturn = $this->saleReturnRepository->create($input);

        return $this->sendResponse($saleReturn->toArray(), 'Sale Return saved successfully');
    }

    /**
     * Display the specified SaleReturn.
     * GET|HEAD /saleReturns/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SaleReturn $saleReturn */
        $saleReturn = $this->saleReturnRepository->find($id);

        if (empty($saleReturn)) {
            return $this->sendError('Sale Return not found');
        }

        return $this->sendResponse($saleReturn->toArray(), 'Sale Return retrieved successfully');
    }

    /**
     * Update the specified SaleReturn in storage.
     * PUT/PATCH /saleReturns/{id}
     *
     * @param int $id
     * @param UpdateSaleReturnAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleReturnAPIRequest $request)
    {
        $input = $request->all();

        /** @var SaleReturn $saleReturn */
        $saleReturn = $this->saleReturnRepository->find($id);

        if (empty($saleReturn)) {
            return $this->sendError('Sale Return not found');
        }

        $saleReturn = $this->saleReturnRepository->update($input, $id);

        return $this->sendResponse($saleReturn->toArray(), 'SaleReturn updated successfully');
    }

    /**
     * Remove the specified SaleReturn from storage.
     * DELETE /saleReturns/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SaleReturn $saleReturn */
        $saleReturn = $this->saleReturnRepository->find($id);

        if (empty($saleReturn)) {
            return $this->sendError('Sale Return not found');
        }

        $saleReturn->delete();

        return $this->sendSuccess('Sale Return deleted successfully');
    }
}
