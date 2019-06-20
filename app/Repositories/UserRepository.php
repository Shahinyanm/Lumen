<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\User;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Collection;

class UserRepository implements UserInterface
{
	public function showAllUsers()
	{
		return User::all();
	}

	public function showAllUsersWithTeam()
	{
		return User::with('teams')->get();	}

	public function show($id)
	{
		return User::findOrFail($id);
	}

	public function destroy($id)
	{
		$user = User::findOrFail($id);
		$user->delete();

		return true;
	}

	public function save($id, $data)
	{
		$user = User::findOrFail($id);
		$user->name = $data['name'];
		$user->email = $data['email'];
		$user->password = Hash::make($data['password']);
		$user->save();

		return $user;


	}

	public function update($id, $data)
	{
		$user = User::findOrFail($id);
		$user->name = $data['name'];
		$user->email = $data['email'];
		$user->password = Hash::make($data['password']);
		$user->save();

		return $user;
	}


}