<?php

namespace App\Http\Controllers;

use App\Role;
use App\Team;
use App\User;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function assignTeam(Request $request)
    {

        $user = User::findOrfail($request->user_id);
        $team = Team::with('users')->where('id', $request->team_id)->first();
        if (!$team) {
            return response()->json('Wrong Team ID', 401);
        }
        $pivot = optional($team->users->find(\Auth::id()))->pivot;


        if (!$pivot || !$pivot->owner) {
            return response()->json('You can not assign users to this team, because you are not owner', 401);
        }

        $old = $team->users->find($user->id);
        if (!$old) {
            $team->users()->attach($user);
        } else {
            return response()->json('User is already assigned team', 200);

        }

        return response()->json('User Successfully assigned to Team', 200);
    }


    public function assignRole(Request $request)
    {
        $user = User::findOrfail($request->user_id);
        $role = Role::findOrfail($request->role_id);
        $role->users()->sync($user);

        return response()->json('User Successfully assigned to Team', 200);
    }

    public function unAssignTeam(Request $request)
    {

        $user = User::findOrfail($request->user_id);
        $team = Team::where('id', $request->team_id)->where('owner', \Auth::id())->first();
        if (!$team) {
            return response()->json('You can not un assign users to this team, because you are not owner', 200);
        }
        $team->users()->detach($user);

        return response()->json('User Successfully assigned to Team', 200);
    }


    public function unAssignRole(Request $request)
    {
        $user = User::findOrfail($request->user_id);
        $role = Role::findOrfail($request->role_id);

        $role->users()->detach($user);

        return response()->json('User Successfully assigned to Team', 200);
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
            return response()->json('You can not assign users to this team, because you are not owner', 401);
        }
        $old = optional($team->users->find($user->id))->pivot;
        if (!$old || !$old->owner) {
            $team->users()->attach($user, ['owner' => true]);
        } else {
            return response()->json('User is already owner of this team', 200);

        }


        return response()->json('Now ' . $team->title . ' Owner is ' . $user->name, 200);
    }

}
