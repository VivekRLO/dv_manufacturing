<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\User;
use App\Models\Collection;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CollectionRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;

class CollectionController extends AppBaseController
{
    /** @var  CollectionRepository */
    private $collectionRepository;

    public function __construct(CollectionRepository $collectionRepo)
    {
        $this->collectionRepository = $collectionRepo;
    }

    /**
     * Display a listing of the Collection.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = [];
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users =User::where('type',1)->where('regionalmanager',Auth::user()->id)->where('role',5)->pluck('id');
            }
            //Admin
            else {
                $users =User::where('type',1)->whereIn('role',[4,5])->pluck('id');
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users =User::where('type',2)->where('regionalmanager',Auth::user()->id)->where('role',5)->pluck('id');
            }
            //Admin
            else {
                $users =User::where('type',2)->whereIn('role',[4,5])->pluck('id');
            }
        } 
        $collections =Collection::whereIn('sales_officer_id',$users)->orderBy('id','desc')->paginate(100);

        return view('collections.index')
            ->with('collections', $collections);
    }

    /**
     * Show the form for creating a new Collection.
     *
     * @return Response
     */
    public function create()
    {
        return view('collections.create');
    }

    /**
     * Store a newly created Collection in storage.
     *
     * @param CreateCollectionRequest $request
     *
     * @return Response
     */
    public function store(CreateCollectionRequest $request)
    {
        $input = $request->all();

        $collection = $this->collectionRepository->create($input);

        Flash::success('Collection saved successfully.');

        return redirect(route('collections.index'));
    }

    /**
     * Display the specified Collection.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $collection = $this->collectionRepository->find($id);

        if (empty($collection)) {
            Flash::error('Collection not found');

            return redirect(route('collections.index'));
        }

        return view('collections.show')->with('collection', $collection);
    }

    /**
     * Show the form for editing the specified Collection.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $collection = $this->collectionRepository->find($id);

        if (empty($collection)) {
            Flash::error('Collection not found');

            return redirect(route('collections.index'));
        }

        return view('collections.edit')->with('collection', $collection);
    }

    /**
     * Update the specified Collection in storage.
     *
     * @param int $id
     * @param UpdateCollectionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCollectionRequest $request)
    {
        $collection = $this->collectionRepository->find($id);

        if (empty($collection)) {
            Flash::error('Collection not found');

            return redirect(route('collections.index'));
        }

        $collection = $this->collectionRepository->update($request->all(), $id);

        Flash::success('Collection updated successfully.');

        return redirect(route('collections.index'));
    }

    /**
     * Remove the specified Collection from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $collection = $this->collectionRepository->find($id);

        if (empty($collection)) {
            Flash::error('Collection not found');

            return redirect(route('collections.index'));
        }

        $this->collectionRepository->delete($id);

        Flash::success('Collection deleted successfully.');

        return redirect(route('collections.index'));
    }
}
