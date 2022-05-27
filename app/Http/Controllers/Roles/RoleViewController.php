<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;

class RoleViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('roles');
    }
}
