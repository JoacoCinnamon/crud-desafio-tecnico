<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
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
    public function show(Request $request, $id)
    {
        $user = $request->user();

        if (!$user->isAdmin() && $id == 1) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Role $role)
    {
        //$permissions = Permission::all();

        $user = $request->user();

        abort_if(!$user->isAdmin() && $role->id == 1, code: 403);

        return view('admin.roles.edit', compact('role'));
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
        $user = $request->user();

        if (!$user->isAdmin() && $role->id == 1) {
            abort(403);
        }

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
    public function destroy(Request $request, Role $role)
    {
        $user = $request->user();

        if ($role->id == 1) {
            abort(403);
        }

        $role->delete();

        return back()->with('alert', [
            'message' => "Se ha eliminado el rol $role->name "
        ]);
    }
}
