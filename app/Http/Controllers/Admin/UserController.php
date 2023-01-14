<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(14);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Con esto podríamos forzar a que todos los usuarios empiecen con el rol de usuarios
        // $user->syncRoles('user');

        return redirect()->route('admin.users.index')->with('alert', [
            'message' => "Se agregó el usuario $user->name"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $request->user()->save();
        $user = $request->user();

        return to_route('admin.users.index')->with('alert', [
            'message' => "Se editó el usuario $user->name"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 403);

        $user->delete();

        return back()->with('alert', [
            'message' => "Se ha eliminado el usuario $user->name "
        ]);
    }

    public function assignRole(Request $request, User $user)
    {
        // Asignarle el rol de admin a un usuario
        $role = Role::findByName($request->role);
        abort_if($role->id == 1, 403);

        $request->validate([
            "role" => "min:0|not_in:0"
        ]);

        if ($user->hasRole($request->role)) {
            return back()
                ->withInput()
                ->withErrors(['role' => 'El usuario ya tiene ese rol']);
        }

        $user->assignRole($request->role);
        return back()->with('alert', ['message' => "Se ha asignado el rol $role a $user"]);
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return back()->with('alert', ['message' => "Se ha removido el rol $role"]);
        }

        return back()
            ->withInput()
            ->withErrors(['role' => 'El usuario no tiene ese rol']);
    }
}
