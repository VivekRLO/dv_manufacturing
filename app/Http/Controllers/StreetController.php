<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStreetRequest;
use App\Http\Requests\UpdateStreetRequest;
use App\Repositories\StreetRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Area;
use Illuminate\Http\Request;
use Flash;
use Response;

class StreetController extends AppBaseController
{
    /** @var  StreetRepository */
    private $streetRepository;

    public function __construct(StreetRepository $streetRepo)
    {
        $this->streetRepository = $streetRepo;
    }

    /**
     * Display a listing of the Street.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $streets = $this->streetRepository->paginate(10);

        return view('streets.index')
            ->with('streets', $streets);
    }

    /**
     * Show the form for creating a new Street.
     *
     * @return Response
     */
    public function create()
    {
        $areas = Area::pluck('name', 'id');
        return view('streets.create')->with('areas', $areas);
    }

    /**
     * Store a newly created Street in storage.
     *
     * @param CreateStreetRequest $request
     *
     * @return Response
     */
    public function store(CreateStreetRequest $request)
    {
        $input = $request->all();

        $street = $this->streetRepository->create($input);

        Flash::success('Street saved successfully.');

        return redirect(route('streets.index'));
    }

    /**
     * Display the specified Street.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $street = $this->streetRepository->find($id);

        if (empty($street)) {
            Flash::error('Street not found');

            return redirect(route('streets.index'));
        }

        return view('streets.show')->with('street', $street);
    }

    /**
     * Show the form for editing the specified Street.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $street = $this->streetRepository->find($id);

        if (empty($street)) {
            Flash::error('Street not found');

            return redirect(route('streets.index'));
        }
        $areas = Area::pluck('name', 'id');
        return view('streets.edit')->with('street', $street) ->with('areas', $areas);
    }

    /**
     * Update the specified Street in storage.
     *
     * @param int $id
     * @param UpdateStreetRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStreetRequest $request)
    {
        $street = $this->streetRepository->find($id);

        if (empty($street)) {
            Flash::error('Street not found');

            return redirect(route('streets.index'));
        }

        $street = $this->streetRepository->update($request->all(), $id);

        Flash::success('Street updated successfully.');

        return redirect(route('streets.index'));
    }

    /**
     * Remove the specified Street from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $street = $this->streetRepository->find($id);

        if (empty($street)) {
            Flash::error('Street not found');

            return redirect(route('streets.index'));
        }

        $this->streetRepository->delete($id);

        Flash::success('Street deleted successfully.');

        return redirect(route('streets.index'));
    }
}
