<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Repositories\TownRepository;
use App\Http\Requests\CreateTownRequest;
use App\Http\Requests\UpdateTownRequest;
use App\Http\Controllers\AppBaseController;

class TownController extends AppBaseController
{
    /** @var TownRepository $townRepository*/
    private $townRepository;

    public function __construct(TownRepository $townRepo)
    {
        $this->townRepository = $townRepo;
    }

    /**
     * Display a listing of the Town.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $towns = $this->townRepository->paginate(10);

        return view('towns.index')
            ->with('towns', $towns);
    }

    /**
     * Show the form for creating a new Town.
     *
     * @return Response
     */
    public function create()
    {
        $zones=Zone::pluck('zone','id');
        return view('towns.create',compact('zones'));
    }

    /**
     * Store a newly created Town in storage.
     *
     * @param CreateTownRequest $request
     *
     * @return Response
     */
    public function store(CreateTownRequest $request)
    {
        $input = $request->all();

        $town = $this->townRepository->create($input);

        Flash::success('Town saved successfully.');

        return redirect(route('towns.index'));
    }

    /**
     * Display the specified Town.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $town = $this->townRepository->find($id);

        if (empty($town)) {
            Flash::error('Town not found');

            return redirect(route('towns.index'));
        }

        return view('towns.show')->with('town', $town);
    }

    /**
     * Show the form for editing the specified Town.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $town = $this->townRepository->find($id);

        if (empty($town)) {
            Flash::error('Town not found');

            return redirect(route('towns.index'));
        }
        $zones=Zone::pluck('zone','id');

        return view('towns.edit',compact('zones'))->with('town', $town);
    }

    /**
     * Update the specified Town in storage.
     *
     * @param int $id
     * @param UpdateTownRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTownRequest $request)
    {
        $town = $this->townRepository->find($id);

        if (empty($town)) {
            Flash::error('Town not found');

            return redirect(route('towns.index'));
        }

        $town = $this->townRepository->update($request->all(), $id);

        Flash::success('Town updated successfully.');

        return redirect(route('towns.index'));
    }

    /**
     * Remove the specified Town from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $town = $this->townRepository->find($id);

        if (empty($town)) {
            Flash::error('Town not found');

            return redirect(route('towns.index'));
        }

        $this->townRepository->delete($id);

        Flash::success('Town deleted successfully.');

        return redirect(route('towns.index'));
    }
}
