<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDailyLocationRequest;
use App\Http\Requests\UpdateDailyLocationRequest;
use App\Repositories\DailyLocationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class DailyLocationController extends AppBaseController
{
    /** @var  DailyLocationRepository */
    private $dailyLocationRepository;

    public function __construct(DailyLocationRepository $dailyLocationRepo)
    {
        $this->dailyLocationRepository = $dailyLocationRepo;
    }

    /**
     * Display a listing of the DailyLocation.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dailyLocations = $this->dailyLocationRepository->paginate(10);

        return view('daily_locations.index')
            ->with('dailyLocations', $dailyLocations);
    }

    /**
     * Show the form for creating a new DailyLocation.
     *
     * @return Response
     */
    public function create()
    {
        return view('daily_locations.create');
    }

    /**
     * Store a newly created DailyLocation in storage.
     *
     * @param CreateDailyLocationRequest $request
     *
     * @return Response
     */
    public function store(CreateDailyLocationRequest $request)
    {
        $input = $request->all();

        $dailyLocation = $this->dailyLocationRepository->create($input);

        Flash::success('Daily Location saved successfully.');

        return redirect(route('dailyLocations.index'));
    }

    /**
     * Display the specified DailyLocation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dailyLocation = $this->dailyLocationRepository->find($id);

        if (empty($dailyLocation)) {
            Flash::error('Daily Location not found');

            return redirect(route('dailyLocations.index'));
        }

        return view('daily_locations.show')->with('dailyLocation', $dailyLocation);
    }

    /**
     * Show the form for editing the specified DailyLocation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $dailyLocation = $this->dailyLocationRepository->find($id);

        if (empty($dailyLocation)) {
            Flash::error('Daily Location not found');

            return redirect(route('dailyLocations.index'));
        }

        return view('daily_locations.edit')->with('dailyLocation', $dailyLocation);
    }

    /**
     * Update the specified DailyLocation in storage.
     *
     * @param int $id
     * @param UpdateDailyLocationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDailyLocationRequest $request)
    {
        $dailyLocation = $this->dailyLocationRepository->find($id);

        if (empty($dailyLocation)) {
            Flash::error('Daily Location not found');

            return redirect(route('dailyLocations.index'));
        }

        $dailyLocation = $this->dailyLocationRepository->update($request->all(), $id);

        Flash::success('Daily Location updated successfully.');

        return redirect(route('dailyLocations.index'));
    }

    /**
     * Remove the specified DailyLocation from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dailyLocation = $this->dailyLocationRepository->find($id);

        if (empty($dailyLocation)) {
            Flash::error('Daily Location not found');

            return redirect(route('dailyLocations.index'));
        }

        $this->dailyLocationRepository->delete($id);

        Flash::success('Daily Location deleted successfully.');

        return redirect(route('dailyLocations.index'));
    }
}
