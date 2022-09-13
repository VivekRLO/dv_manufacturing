<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCollectionAPIRequest;
use App\Http\Requests\API\UpdateCollectionAPIRequest;
use App\Models\Collection;
use App\Repositories\CollectionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class CollectionController
 * @package App\Http\Controllers\API
 */

class CollectionAPIController extends AppBaseController
{
    /** @var  CollectionRepository */
    private $collectionRepository;

    public function __construct(CollectionRepository $collectionRepo)
    {
        $this->collectionRepository = $collectionRepo;
    }

    /**
     * Display a listing of the Collection.
     * GET|HEAD /collections
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $collections = $this->collectionRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // );
        $collections =Collection::where('sales_officer_id', auth()->user()->id)->orderBy('id','desc')->get();
        return $this->sendResponse($collections->toArray(), 'Collections retrieved successfully');
    }

    /**
     * Store a newly created Collection in storage.
     * POST /collections
     *
     * @param CreateCollectionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCollectionAPIRequest $request)
    {
        $input = $request->all();
// dd(Auth::user()->id);
        if($request->cheque_photo){
            $file = base64_decode($request['cheque_photo']);
            $folderName = '/storage/cheque_photo/';
            $safeName =  time().'.'.'png';
            $destinationPath =$folderName .$safeName;
            $success = file_put_contents(storage_path().'/app/public/cheque_photo/'.$safeName, $file);
            $input['cheque_photo']=$destinationPath;
        }
        // $file = base64_decode($request['cheque_photo']);
        // $folderName = '/public/storage/';
        // $safeName =  time().'.'.'png';
        // $destinationPath =$folderName .$safeName;
        // $success = file_put_contents(storage_path().'/app/public/cheque_photo/'.$safeName, $file);
        // dd($destinationPath);
        $input['sales_officer_id']=Auth::user()->id;
        // dd($input);
        $collection = $this->collectionRepository->create($input);

        return $this->sendResponse($collection->toArray(), 'Collection saved successfully');
    }

    /**
     * Display the specified Collection.
     * GET|HEAD /collections/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Collection $collection */
        $collection = $this->collectionRepository->find($id);

        if (empty($collection)) {
            return $this->sendError('Collection not found');
        }

        return $this->sendResponse($collection->toArray(), 'Collection retrieved successfully');
    }

    /**
     * Update the specified Collection in storage.
     * PUT/PATCH /collections/{id}
     *
     * @param int $id
     * @param UpdateCollectionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCollectionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Collection $collection */
        $collection = $this->collectionRepository->find($id);

        if (empty($collection)) {
            return $this->sendError('Collection not found');
        }

        $collection = $this->collectionRepository->update($input, $id);

        return $this->sendResponse($collection->toArray(), 'Collection updated successfully');
    }

    /**
     * Remove the specified Collection from storage.
     * DELETE /collections/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Collection $collection */
        $collection = $this->collectionRepository->find($id);

        if (empty($collection)) {
            return $this->sendError('Collection not found');
        }

        $collection->delete();

        return $this->sendSuccess('Collection deleted successfully');
    }
}
