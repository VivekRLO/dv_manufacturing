<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::with('users')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function show($id)
    {
        $role = Role::find($id);
        return view('roles.show', compact('role'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateRolesForm($request);

        $permissions = collect($request->permissions)->keys();

        $role = Role::create([
            'name' => $request->name,
        ]);

        $role->givePermissionTo($permissions);

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, Role $role)
    {
        $this->validateRolesForm($request, $role);

        $role->update([
            'name' => $request->name,
        ]);

        $permissions = collect($request->permissions)->keys();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index');
    }

    private function validateRolesForm(Request $request, Role $role = null)
    {
        $uniqueRole = $role === null ? '' : ',' . $role->id;
        return $request->validate([
            'name' => 'required|string|max:255|unique:roles,name' . $uniqueRole,
            'permissions' => 'required|array',
        ]);
    }
}
