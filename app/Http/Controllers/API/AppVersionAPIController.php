<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppVersionAPIRequest;
use App\Http\Requests\API\UpdateAppVersionAPIRequest;
use App\Models\AppVersion;
use App\Repositories\AppVersionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AppVersionController
 * @package App\Http\Controllers\API
 */

class AppVersionAPIController extends AppBaseController
{
    /** @var  AppVersionRepository */
    private $appVersionRepository;

    public function __construct(AppVersionRepository $appVersionRepo)
    {
        $this->appVersionRepository = $appVersionRepo;
    }

    /**
     * Display a listing of the AppVersion.
     * GET|HEAD /appVersions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $appVersions = $this->appVersionRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // );
        $appVersions = AppVersion::latest()->first();
        return $this->sendResponse($appVersions->toArray(), 'App Versions retrieved successfully');
    }

    /**
     * Store a newly created AppVersion in storage.
     * POST /appVersions
     *
     * @param CreateAppVersionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppVersionAPIRequest $request)
    {
        $input = $request->all();

        $appVersion = $this->appVersionRepository->create($input);

        return $this->sendResponse($appVersion->toArray(), 'App Version saved successfully');
    }

    /**
     * Display the specified AppVersion.
     * GET|HEAD /appVersions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AppVersion $appVersion */
        $appVersion = $this->appVersionRepository->find($id);

        if (empty($appVersion)) {
            return $this->sendError('App Version not found');
        }

        return $this->sendResponse($appVersion->toArray(), 'App Version retrieved successfully');
    }

    /**
     * Update the specified AppVersion in storage.
     * PUT/PATCH /appVersions/{id}
     *
     * @param int $id
     * @param UpdateAppVersionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppVersionAPIRequest $request)
    {
        $input = $request->all();

        /** @var AppVersion $appVersion */
        $appVersion = $this->appVersionRepository->find($id);

        if (empty($appVersion)) {
            return $this->sendError('App Version not found');
        }

        $appVersion = $this->appVersionRepository->update($input, $id);

        return $this->sendResponse($appVersion->toArray(), 'AppVersion updated successfully');
    }

    /**
     * Remove the specified AppVersion from storage.
     * DELETE /appVersions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AppVersion $appVersion */
        $appVersion = $this->appVersionRepository->find($id);

        if (empty($appVersion)) {
            return $this->sendError('App Version not found');
        }

        $appVersion->delete();

        return $this->sendSuccess('App Version deleted successfully');
    }
}
