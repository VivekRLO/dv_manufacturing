<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use App\Models\AppVersion;
use Illuminate\Http\Request;
use App\Repositories\AppVersionRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateAppVersionRequest;
use App\Http\Requests\UpdateAppVersionRequest;

class AppVersionController extends AppBaseController
{
    /** @var  AppVersionRepository */
    private $appVersionRepository;

    public function __construct(AppVersionRepository $appVersionRepo)
    {
        $this->appVersionRepository = $appVersionRepo;
    }

    /**
     * Display a listing of the AppVersion.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $appVersions =AppVersion::orderBy('id', 'DESC')->paginate(10);

        return view('app_versions.index')
            ->with('appVersions', $appVersions);
    }

    /**
     * Show the form for creating a new AppVersion.
     *
     * @return Response
     */
    public function create()
    {
        return view('app_versions.create');
    }

    /**
     * Store a newly created AppVersion in storage.
     *
     * @param CreateAppVersionRequest $request
     *
     * @return Response
     */
    public function store(CreateAppVersionRequest $request)
    {   
        // dd($request->all());
        
        $input['version'] = $request->version;
        $input['remarks'] = $request->remarks;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameWithExt = $request->file('file')->getClientOriginalName();
            $filename_temp = preg_replace('/[^a-zA-Z0-9_-]+/', '', pathinfo($fileNameWithExt, PATHINFO_FILENAME));
            $filename = $filename_temp . '_' . time() . '.' . $extension;
            $input['link'] = '/public/storage/apk/' . $filename;
            $file->storeAs('apk' , $filename, 'public'); 
        }
        $appVersion = $this->appVersionRepository->create($input);

        Flash::success('App Version saved successfully.');

        return redirect(route('appVersions.index'));
    }

    /**
     * Display the specified AppVersion.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appVersion = $this->appVersionRepository->find($id);

        if (empty($appVersion)) {
            Flash::error('App Version not found');

            return redirect(route('appVersions.index'));
        }

        return view('app_versions.show')->with('appVersion', $appVersion);
    }

    /**
     * Show the form for editing the specified AppVersion.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appVersion = $this->appVersionRepository->find($id);

        if (empty($appVersion)) {
            Flash::error('App Version not found');

            return redirect(route('appVersions.index'));
        }

        return view('app_versions.edit')->with('appVersion', $appVersion);
    }

    /**
     * Update the specified AppVersion in storage.
     *
     * @param int $id
     * @param UpdateAppVersionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppVersionRequest $request)
    {
        $appVersion = $this->appVersionRepository->find($id);

        if (empty($appVersion)) {
            Flash::error('App Version not found');

            return redirect(route('appVersions.index'));
        }

        $appVersion = $this->appVersionRepository->update($request->all(), $id);

        Flash::success('App Version updated successfully.');

        return redirect(route('appVersions.index'));
    }

    /**
     * Remove the specified AppVersion from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appVersion = $this->appVersionRepository->find($id);

        if (empty($appVersion)) {
            Flash::error('App Version not found');

            return redirect(route('appVersions.index'));
        }

        $this->appVersionRepository->delete($id);

        Flash::success('App Version deleted successfully.');

        return redirect(route('appVersions.index'));
    }

   
}
