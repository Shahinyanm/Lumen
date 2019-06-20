<?php

namespace App\Http\Controllers;

use App\Interfaces\RoleInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	protected $role;

	public function __construct(RoleInterface $role)
	{
		$this->role = $role;
	}

	public function showAllRoles()
	{

		return response()->json($this->role->showAllRoles());
	}

	public function show($id)
	{

		return response()->json($this->role->show($id));
	}

	public function create(Request $request)
	{
		$this->validate($request, [
			'title' => 'required',
		]);


		return response()->json($this->role->create($request->all()), 201);

	}


	public function update($id, Request $request)
	{


		return response()->json($this->role->update($id, $request->all()), 200);
	}

	public function delete($id)
	{
		if ($this->role->delete($id)) {
			return response('Deleted Successfully', 200);
		} else {
			return response('Something Wrong', 404);
		}

	}
}
