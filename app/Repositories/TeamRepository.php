<?php

namespace App\Repositories;

use App\Interfaces\TeamInterface;
use App\Team;

class TeamRepository extends BaseRepository implements TeamInterface
{

	public function model(){
		return Team::class;
	}

	public function showAllMyTeams()
	{
		return $this->model->with('users')->whereHas('users', function ($u) {
			return $u->where('user_id', \Auth::id());
		})->get()->map(function ($team) {
			return $team->users()->where('user_teams.owner', 1)->first();
		});

	}

	public function showAllTeams()
	{
		return $this->model->with('users')->whereHas('users', function ($u) {
			return $u->where('user_id', \Auth::id());
		})->get();
	}

	public function showTeam($id)
	{
		return $this->model->with('users')->whereHas('users', function ($u) {
			return $u->where('user_id', \Auth::id());
		})->where('id',$id)->first();
	}

	public function updateTeam($id,$data)
	{
		$team = $this->model->with('users')->find($id);
		if (!$team) {
			return response()->json(['failed', 'There are no team with ' . $id . ' id'], 401);
		}
		$pivot = optional($team->users->find(\Auth::id()))->pivot;
		if (!$pivot || !$pivot->owner) {
			return response()->json('You can not update team, because you are not owner', 401);
		}
		$team->update($data);
		return $team;
	}


	public function deleteTeam($id)
	{
		$team = $this->model->with('users')->find($id);

		if (!$team) {
			return response()->json(['failed', 'There are no team with ' . $id . ' id'], 401);
		}
		$pivot = optional($team->users->find(\Auth::id()))->pivot;
		if (!$pivot || !$pivot->owner) {
			return response()->json('You can not delete team, because you are not owner', 401);
		}
		$team->delete();

		return response()->json(['success','Deleted Successfully'], 200);;
	}


	public function pivot($id)
	{
		$team = $this->model->with("users")->find($id);
		if (!$team) {
			return response()->json('Wrong Team ID', 401);
		}
		$pivot = optional($team->users->find(\Auth::id()))->pivot;

		return $pivot;
	}

	public function find($id)
	{
		return $this->model->with("users")->find($id);
	}
	public function userInTeam($team_id, $user_id)
	{
		$team = $this->find($team_id);
		$user =$team->users->find($user_id);

		return $user;

	}

public function detachUser($user,$team_id)
{
	$team = $this->find($team_id);
	$team->users()->detach($user);
}

}