<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Foundation\Application;

class PermissionController extends Controller
{

    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $permissions = Permission::paginate(10);

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // $this->validatePermissionsForm($request);

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->route('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return Response
     */
    public function edit($id)
    {
        $permission = $this->permissionRepository->find($id);
// dd($permission);
        if (empty($permission)) {
            Flash::error('Permissions not found');

            return redirect(route('permissions.index'));
        }

        return view('permissions.edit')->with('permission', $permission);
        // return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Permission $permission
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, Permission $permission)
    {
        // $this->validatePermissionsForm($request, $permission);

        $permission->update([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->route('permissions.index');
    }

    private function validatePermissionsForm(Request $request, Permission $permission = null)
    {
        $uniquePermission = $permission === null ? '' : ',' . $permission->id;
        return $request->validate([
            'permission_name' => 'required|string|max:255|unique:permissions,name' . $uniquePermission,
        ]);
    }
}
