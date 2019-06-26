<?php

namespace App\Http\Controllers;

use App\Interfaces\TeamInterface;
use App\Interfaces\UserInterface;
use App\Role;
use App\Team;
use App\User;
use Illuminate\Http\Request;

class ActionController extends Controller
{
	protected $user;
	protected $team;

	public function __construct(TeamInterface $team, UserInterface $user)
	{

		$this->user = $user;
		$this->team = $team;
	}

	public function assignTeam(Request $request)
	{
		$user = $this->user->show($request->user_id);
		$team = $this->team->find($request->team_id);
		if (!$team) {
			return response()->json('Wrong Team ID', 401);
		}
		$pivot = $this->team->pivot($request->team_id);

		if (!$pivot || !$pivot->owner) {
			return response()->json(['failed'=>'You can not assign users to this team, because you are not owner'], 401);
		}

		$userInTeam = $this->team->userInTeam($request->team_id, $user->id);

		if (!$userInTeam) {
			$team->users()->attach($user, ['owner' => false]);
		}
		else {
			return response()->json(['failed'=>'User is already assigned team'], 403);

		}

		return response()->json(['success'=>'User Successfully assigned to Team'], 200);
	}


	public function assignRole(Request $request)
	{
		$user = $this->user->show($request->user_id);
		$role = Role::findOrfail($request->role_id);
		$role->users()->sync($user);

		return response()->json(['success'=>'User Successfully assigned to Team'], 200);
	}

	public function unAssignTeam(Request $request)
	{
		$user = $this->user->show($request->user_id);
		$pivot = $this->team->pivot($request->team_id);
		if (!$pivot || !$pivot->owner) {
			return response()->json(['failed'=>'You can not un assign users to this team, because you are not owner'], 404);
		}
		$team = $this->team->find($request->team_id);
		$userInTeam = $this->team->userInTeam($request->team_id, $user->id);
		if (!$userInTeam) {
			return response()->json(['failed'=>'There are no user in team'], 404);
		}
		$team->users()->detach($user);

		return response()->json(['success'=>'User Successfully unsigned to Team'], 200);
	}


	public function unAssignRole(Request $request)
	{
		$user = User::findOrfail($request->user_id);
		$role = Role::findOrfail($request->role_id);

		$role->users()->detach($user);

		return response()->json(['success'=>'User Successfully assigned to Team'], 200);
	}

	public function setOwner(Request $request)
	{
		$user = User::findOrfail($request->user_id);
		$team = Team::with('users')->where('id', $request->team_id)->first();
		if (!$team) {
			return response()->json('Wrong Team ID', 401);
		}
		$pivot = $team->users->find(\Auth::id())->pivot;


		if (!$pivot->owner) {
			return response()->json(['failed'=>'You can not assign users to this team, because you are not owner'], 401);
		}
		$old = optional($team->users->find($user->id))->pivot;
		if (!$old || !$old->owner) {
			$team->users()->attach($user, ['owner' => true]);
		}
		else {
			return response()->json(['success'=>'User is already owner of this team'], 200);

		}


		return response()->json('Now ' . $team->title . ' Owner is ' . $user->name, 200);
	}

}
