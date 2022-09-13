<?php

namespace App\Http\Controllers\API;

use Response;
use Illuminate\Http\Request;
use App\Models\DailyLocation;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DailyLocationRepository;
use App\Http\Requests\API\CreateDailyLocationAPIRequest;
use App\Http\Requests\API\UpdateDailyLocationAPIRequest;

/**
 * Class DailyLocationController
 * @package App\Http\Controllers\API
 */

class DailyLocationAPIController extends AppBaseController
{
    /** @var  DailyLocationRepository */
    private $dailyLocationRepository;

    public function __construct(DailyLocationRepository $dailyLocationRepo)
    {
        $this->dailyLocationRepository = $dailyLocationRepo;
    }

    /**
     * Display a listing of the DailyLocation.
     * GET|HEAD /dailyLocations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $dailyLocations = $this->dailyLocationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($dailyLocations->toArray(), 'Daily Locations retrieved successfully');
    }

    /**
     * Store a newly created DailyLocation in storage.
     * POST /dailyLocations
     *
     * @param CreateDailyLocationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDailyLocationAPIRequest $request)
    {
        $input = $request->all();
        // dd($input);
        $input['user_id']=Auth::User()->id;
        $input['longitude']=$request->longitude;
        $input['latitude']=$request->latitude;
        $input['date']=$request->date;
        $input['checkinout_id']=$request->checkinout_id;
        $input['outlet_id']=$request->outlet_id;

        $dailyLocation = $this->dailyLocationRepository->create($input);

        return $this->sendResponse($dailyLocation->toArray(), 'Daily Location saved successfully');
    }

    /**
     * Display the specified DailyLocation.
     * GET|HEAD /dailyLocations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DailyLocation $dailyLocation */
        $dailyLocation = $this->dailyLocationRepository->find($id);

        if (empty($dailyLocation)) {
            return $this->sendError('Daily Location not found');
        }

        return $this->sendResponse($dailyLocation->toArray(), 'Daily Location retrieved successfully');
    }

    /**
     * Update the specified DailyLocation in storage.
     * PUT/PATCH /dailyLocations/{id}
     *
     * @param int $id
     * @param UpdateDailyLocationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDailyLocationAPIRequest $request)
    {
        $input = $request->all();

        /** @var DailyLocation $dailyLocation */
        $dailyLocation = $this->dailyLocationRepository->find($id);

        if (empty($dailyLocation)) {
            return $this->sendError('Daily Location not found');
        }

        $dailyLocation = $this->dailyLocationRepository->update($input, $id);

        return $this->sendResponse($dailyLocation->toArray(), 'DailyLocation updated successfully');
    }

    /**
     * Remove the specified DailyLocation from storage.
     * DELETE /dailyLocations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DailyLocation $dailyLocation */
        $dailyLocation = $this->dailyLocationRepository->find($id);

        if (empty($dailyLocation)) {
            return $this->sendError('Daily Location not found');
        }

        $dailyLocation->delete();

        return $this->sendSuccess('Daily Location deleted successfully');
    }
}
