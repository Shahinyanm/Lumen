<?php
namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Role;

class RoleRepository  extends BaseRepository  implements RoleInterface
{
	public function showAllRoles()
	{
		return Role::all();
	}

	public function show($id)
	{
		return Role::findOrFail($id);
	}


	public function create($data)
	{
		$role = Role::create($data);
		return $role;
	}

	public function update($id, $data)
	{
		$role = Role::findOrFail($id);
		$role->update($data);

		return $role;
	}

	public function delete($id)
	{
		return Role::findOrFail($id)->delete();

	}

}