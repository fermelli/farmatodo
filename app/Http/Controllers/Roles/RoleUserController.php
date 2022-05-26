<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleUserController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size', 10);
        return User::whereNot('id', Auth::user()->id)->with('roles')->paginate($size);
    }

    public function store(User $user, Role $role)
    {
        if ($role->name != 'Guest') {
            $user->roles()->attach($role->id);
            return response()->json([
                'message' => __('Established role') . ': ' . __($role->name),
                'user' => $user,
                'role' => $role
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Role $role)
    {
        if ($role->name != 'Guest') {
            $user->roles()->detach($role->id);
            return response()->json([
                'message' => __('Role removed') . ': ' . __($role->name),
                'user' => $user,
            ], 200);
        }
    }
}
