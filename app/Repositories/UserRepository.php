<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserInterface
{

	protected $model = User::class;
//	public function model(){
//		return User::class;
//	}

	public function showAllUsers()
	{
		return $this->model->all();
	}

	public function showAllUsersWithTeam()
	{
		return $this->model->with('teams')->get();	}




}