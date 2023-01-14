<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected const ADMIN = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->paginate(14);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|min:3|unique:roles,name"
        ]);

        $role = Role::create($data);

        return redirect()->route('admin.roles.index')->with('alert', [
            'message' => "Se agregó el rol $role->name"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Role $role)
    {
        // Si quieren ver el rol de admin
        abort_if($role->id == self::ADMIN && $user->isAdmin(), 404);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // Si quieren editar el rol de admin
        abort_if($role->id == self::ADMIN, 404);

        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        // Si quieren editar el rol de admin
        abort_if($role->id == self::ADMIN, 404);

        $data = $request->validate([
            "name" => [
                "required",
                "string",
                "min:3",
                Rule::unique('roles', 'name')->ignore($role)
            ]
        ]);

        $role->update($data);

        return redirect()->route('admin.roles.index')->with('alert', [
            'message' => "Se ha editado el rol $role->name "
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // Si quieren borrar el rol de admin
        abort_if($role->id == self::ADMIN, 404);


        $role->delete();

        return back()->with('alert', [
            'message' => "Se ha eliminado el rol $role->name "
        ]);
    }

    public function assignPermission(Request $request, Role $role)
    {
        $request->validate([
            "permission" => "min:0|not_in:0"
        ]);

        $permission = $request->permission;

        if ($role->hasPermissionTo($permission)) {
            return back()
                ->withInput()
                ->withErrors(['permission' => 'El rol ya tiene ese permiso']);
        }

        $role->givePermissionTo($permission);

        return back()->with('alert', ['message' => "Se agregó el permiso $permission al rol"]);
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return back()->with('alert', ['message' => "Se ha eliminado el permiso $permission->name del rol"]);
        }
        return back()
            ->withInput()
            ->withErrors(['permission' => 'El rol no tiene ese permiso']);
    }
}
