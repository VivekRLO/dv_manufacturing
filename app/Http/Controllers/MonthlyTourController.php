<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\MonthlyTour;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MonthlyTourRepository;
use App\Http\Requests\CreateMonthlyTourRequest;
use App\Http\Requests\UpdateMonthlyTourRequest;

class MonthlyTourController extends AppBaseController
{
    /** @var  MonthlyTourRepository */
    private $monthlyTourRepository;

    public function __construct(MonthlyTourRepository $monthlyTourRepo)
    {
        $this->monthlyTourRepository = $monthlyTourRepo;
    }

    /**
     * Display a listing of the MonthlyTour.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $monthlyTours = MonthlyTour::orderBy('id','desc')->get();

        return view('monthly_tours.index')
            ->with('monthlyTours', $monthlyTours);
    }

    /**
     * Show the form for creating a new MonthlyTour.
     *
     * @return Response
     */
    public function create()
    {
        return view('monthly_tours.create');
    }

    /**
     * Store a newly created MonthlyTour in storage.
     *
     * @param CreateMonthlyTourRequest $request
     *
     * @return Response
     */
    public function store(CreateMonthlyTourRequest $request)
    {
        $input = $request->all();

        $monthlyTour = $this->monthlyTourRepository->create($input);

        Flash::success('Monthly Tour saved successfully.');

        return redirect(route('monthlyTours.index'));
    }

    /**
     * Display the specified MonthlyTour.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $monthlyTour = $this->monthlyTourRepository->find($id);

        if (empty($monthlyTour)) {
            Flash::error('Monthly Tour not found');

            return redirect(route('monthlyTours.index'));
        }

        return view('monthly_tours.show')->with('monthlyTour', $monthlyTour);
    }

    /**
     * Show the form for editing the specified MonthlyTour.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $monthlyTour = $this->monthlyTourRepository->find($id);

        if (empty($monthlyTour)) {
            Flash::error('Monthly Tour not found');

            return redirect(route('monthlyTours.index'));
        }

        return view('monthly_tours.edit')->with('monthlyTour', $monthlyTour);
    }

    /**
     * Update the specified MonthlyTour in storage.
     *
     * @param int $id
     * @param UpdateMonthlyTourRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMonthlyTourRequest $request)
    {
        $monthlyTour = $this->monthlyTourRepository->find($id);

        if (empty($monthlyTour)) {
            Flash::error('Monthly Tour not found');

            return redirect(route('monthlyTours.index'));
        }

        $monthlyTour = $this->monthlyTourRepository->update($request->all(), $id);

        Flash::success('Monthly Tour updated successfully.');

        return redirect(route('monthlyTours.index'));
    }

    /**
     * Remove the specified MonthlyTour from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $monthlyTour = $this->monthlyTourRepository->find($id);

        if (empty($monthlyTour)) {
            Flash::error('Monthly Tour not found');

            return redirect(route('monthlyTours.index'));
        }

        $this->monthlyTourRepository->delete($id);

        Flash::success('Monthly Tour deleted successfully.');

        return redirect(route('monthlyTours.index'));
    }
}
