<?php

namespace App\Http\Controllers\API;

use Response;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DistributorRepository;
use App\Http\Requests\API\CreateDistributorAPIRequest;
use App\Http\Requests\API\UpdateDistributorAPIRequest;
use App\Models\RouteName;
use App\Models\Town;
use Illuminate\Routing\Route;

/**
 * Class DistributorController
 * @package App\Http\Controllers\API
 */

class DistributorAPIController extends AppBaseController
{
    /** @var  DistributorRepository */
    private $distributorRepository;

    public function __construct(DistributorRepository $distributorRepo)
    {
        $this->distributorRepository = $distributorRepo;
    }

    /**
     * Display a listing of the Distributor.
     * GET|HEAD /distributors
     *
     * @param Request $request
     * @return Response
     */

     public function getdistributorList(Request $request){
        $input = $request->all();

        if (array_key_exists('zone_id', $input)) {
            $distributor = Distributor::where('zone_id', $input['zone_id'])->get();
            return $this->sendResponse($distributor->toArray(), 'Distributor retrieved successfully');
        }
     }
     public function gettownlist(Request $request){
        $input = $request->all();
        if(array_key_exists('zone', $input)){
            $town = Town::where('zone_id', $input['zone'])->get();
            return $this->sendResponse($town->toArray(), 'Town retrieved successfully');
        }
     }
     public function getroutelist(Request $request){
        $input = $request->all();
        if(array_key_exists('distributor', $input)){
            $routename = RouteName::where('distributor_id', $input['distributor'])->get();
            return $this->sendResponse($routename->toArray(), 'Route retrieved successfully');
        }
     }
     public function getdselist(Request $request){
        $input = $request->all();
        if(array_key_exists('distributor', $input)){
            $distributor = Distributor::find($input['distributor']);
            return $this->sendResponse($distributor->distributor_salesOfficer->toArray(), 'Route retrieved successfully');
        }
     }
     

     
     
    public function index(Request $request)
    {
        // $distributors = $this->distributorRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // );
        if(Auth::user()->role==4){
            $distributors=Distributor::where('regionalmanager',Auth::user()->id)->where('flag',0)->get();
        }elseif(Auth::user()->role==3){
            $distributors=Distributor::where('sales_supervisor_id',Auth::user()->id)->where('flag',0)->get();
        }elseif(Auth::user()->role==5){
            $distributor_id=DB::table('distributor_user')->where('user_id',Auth::user()->id)->pluck('distributor_id');
            $distributors=Distributor::whereIn('id',$distributor_id)->where('flag',0)->get();
        }
        return $this->sendResponse($distributors->toArray(), 'Distributors retrieved successfully');
    }

    /**
     * Store a newly created Distributor in storage.
     * POST /distributors
     *
     * @param CreateDistributorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDistributorAPIRequest $request)
    {
        $input = $request->all();

        $distributor = $this->distributorRepository->create($input);

        return $this->sendResponse($distributor->toArray(), 'Distributor saved successfully');
    }

    /**
     * Display the specified Distributor.
     * GET|HEAD /distributors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Distributor $distributor */
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            return $this->sendError('Distributor not found');
        }

        return $this->sendResponse($distributor->toArray(), 'Distributor retrieved successfully');
    }

    /**
     * Update the specified Distributor in storage.
     * PUT/PATCH /distributors/{id}
     *
     * @param int $id
     * @param UpdateDistributorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistributorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Distributor $distributor */
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            return $this->sendError('Distributor not found');
        }

        $distributor = $this->distributorRepository->update($input, $id);

        return $this->sendResponse($distributor->toArray(), 'Distributor updated successfully');
    }

    /**
     * Remove the specified Distributor from storage.
     * DELETE /distributors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Distributor $distributor */
        $distributor = $this->distributorRepository->find($id);

        if (empty($distributor)) {
            return $this->sendError('Distributor not found');
        }

        $distributor->delete();

        return $this->sendSuccess('Distributor deleted successfully');
    }  

}
