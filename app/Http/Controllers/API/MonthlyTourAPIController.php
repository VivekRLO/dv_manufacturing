<?php

namespace App\Http\Controllers\API;

use Response;
use App\Models\MonthlyTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MonthlyTourRepository;
use App\Http\Requests\API\CreateMonthlyTourAPIRequest;
use App\Http\Requests\API\UpdateMonthlyTourAPIRequest;

/**
 * Class MonthlyTourController
 * @package App\Http\Controllers\API
 */

class MonthlyTourAPIController extends AppBaseController
{
    /** @var  MonthlyTourRepository */
    private $monthlyTourRepository;

    public function __construct(MonthlyTourRepository $monthlyTourRepo)
    {
        $this->monthlyTourRepository = $monthlyTourRepo;
    }

    /**
     * Display a listing of the MonthlyTour.
     * GET|HEAD /monthlyTours
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $monthlyTours = $this->monthlyTourRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($monthlyTours->toArray(), 'Monthly Tours retrieved successfully');
    }

    /**
     * Store a newly created MonthlyTour in storage.
     * POST /monthlyTours
     *
     * @param CreateMonthlyTourAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMonthlyTourAPIRequest $request)
    {
        // $input = $request->all();
        $input['user_id']=Auth::user()->id;
        $input['data']=$request->data;
        $input['month']=$request->month;
        $input['year']=$request->year;
        $input['devicetime']=$request->devicetime;
        
        $monthlyTour = $this->monthlyTourRepository->create($input);

        return $this->sendResponse($monthlyTour->toArray(), 'Monthly Tour saved successfully');
    }

    /**
     * Display the specified MonthlyTour.
     * GET|HEAD /monthlyTours/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MonthlyTour $monthlyTour */
        $monthlyTour = $this->monthlyTourRepository->find($id);

        if (empty($monthlyTour)) {
            return $this->sendError('Monthly Tour not found');
        }

        return $this->sendResponse($monthlyTour->toArray(), 'Monthly Tour retrieved successfully');
    }

    /**
     * Update the specified MonthlyTour in storage.
     * PUT/PATCH /monthlyTours/{id}
     *
     * @param int $id
     * @param UpdateMonthlyTourAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMonthlyTourAPIRequest $request)
    {
        $input = $request->all();

        /** @var MonthlyTour $monthlyTour */
        $monthlyTour = $this->monthlyTourRepository->find($id);

        if (empty($monthlyTour)) {
            return $this->sendError('Monthly Tour not found');
        }

        $monthlyTour = $this->monthlyTourRepository->update($input, $id);

        return $this->sendResponse($monthlyTour->toArray(), 'MonthlyTour updated successfully');
    }

    /**
     * Remove the specified MonthlyTour from storage.
     * DELETE /monthlyTours/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MonthlyTour $monthlyTour */
        $monthlyTour = $this->monthlyTourRepository->find($id);

        if (empty($monthlyTour)) {
            return $this->sendError('Monthly Tour not found');
        }

        $monthlyTour->delete();

        return $this->sendSuccess('Monthly Tour deleted successfully');
    }
}
