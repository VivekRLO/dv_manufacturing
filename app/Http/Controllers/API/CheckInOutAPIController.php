<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCheckInOutAPIRequest;
use App\Http\Requests\API\UpdateCheckInOutAPIRequest;
use App\Models\CheckInOut;
use App\Repositories\CheckInOutRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;
use Carbon\Carbon;

/**
 * Class CheckInOutController
 * @package App\Http\Controllers\API
 */

class CheckInOutAPIController extends AppBaseController
{
    /** @var  CheckInOutRepository */
    private $checkInOutRepository;

    public function __construct(CheckInOutRepository $checkInOutRepo)
    {
        $this->checkInOutRepository = $checkInOutRepo;
    }

    /**
     * Display a listing of the CheckInOut.
     * GET|HEAD /checkInOuts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        // $sales_officer = CheckInOut::where('sales_officer_id', auth()->user()->id)->where('created_at', 'like', '%' . $now()->format('Y-m-d') . '%')->orderBy('id','asc')->get();
        $sales_officer = CheckInOut::where('sales_officer_id', auth()->user()->id)->orderBy('id','desc')->get();
        return $this->sendResponse($sales_officer->toArray(), 'sales_officer retrieved successfully');
        // $checkInOuts = $this->checkInOutRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // );

        // return $this->sendResponse($checkInOuts->toArray(), 'Check In Outs retrieved successfully');
    }

    /**
     * Store a newly created CheckInOut in storage.
     * POST /checkInOuts
     *
     * @param CreateCheckInOutAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCheckInOutAPIRequest $request)
    {
        $input = $request->all();
        $input['sales_officer_id']=Auth::user()->id;


        $checkInOut = $this->checkInOutRepository->create($input);

        return $this->sendResponse($checkInOut->toArray(), 'Check In Out saved successfully');
    }

    /**
     * Display the specified CheckInOut.
     * GET|HEAD /checkInOuts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show()
    {
        /** @var CheckInOut $checkInOut */
        
        $checkInOut = $this->checkInOutRepository->find($id);

        if (empty($checkInOut)) {
            return $this->sendError('Check In Out not found');
        }

        return $this->sendResponse($checkInOut->toArray(), 'Check In Out retrieved successfully');
    }

    /**
     * Update the specified CheckInOut in storage.
     * PUT/PATCH /checkInOuts/{id}
     *
     * @param int $id
     * @param UpdateCheckInOutAPIRequest $request
     *
     * @return Response
     */
    public function checkout(Request $request)
    {
        $input['checkout_latitude'] = $request->checkout_latitude;
        $input['checkout_longitude'] = $request->checkout_longitude;
        $input['checkout_device_time'] = $request->checkout_device_time;
        
        /** @var CheckInOut $checkInOut */
        $checkInOut = $this->checkInOutRepository->find($request->id);

        if (empty($checkInOut)) {
            return $this->sendError('Check In Out not found');
        }

        $checkInOut = $this->checkInOutRepository->update($input, $request->id);

        return $this->sendResponse($checkInOut->toArray(), 'CheckInOut updated successfully');
    }

    /**
     * Remove the specified CheckInOut from storage.
     * DELETE /checkInOuts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CheckInOut $checkInOut */
        $checkInOut = $this->checkInOutRepository->find($id);

        if (empty($checkInOut)) {
            return $this->sendError('Check In Out not found');
        }

        $checkInOut->delete();

        return $this->sendSuccess('Check In Out deleted successfully');
    }
}
