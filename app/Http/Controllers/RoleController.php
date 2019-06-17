<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showAllRoles()
    {

        return response()->json(Role::all());
    }

    public function show($id)
    {

        return response()->json(Role::findOrFail($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $role = Role::create($request->all());

        return response()->json($role, 201);

    }


    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());

        return response()->json($role, 200);
    }

    public function delete($id)
    {
        Role::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
