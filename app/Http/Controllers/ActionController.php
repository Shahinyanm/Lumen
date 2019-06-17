<?php

namespace App\Http\Controllers;

use App\Role;
use App\Team;
use App\User;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function assignTeam(Request $request){

        $user = User::findOrfail($request->user_id);
        $team = Team::findOrfail($request->team_id);
        $team->users()->sync($user);

        return response()->json('User Successfully assigned to Team', 200);
    }


    public function assignRole(Request $request){
        $user = User::findOrfail($request->user_id);
        $role = Role::findOrfail($request->role_id);
        $role->users()->sync($user);

        return response()->json('User Successfully assigned to Team', 200);
    }

    public function unAssignTeam(Request $request){

        $user = User::findOrfail($request->user_id);
        $team = Team::findOrfail($request->team_id);
        $team->users()->detach($user);

        return response()->json('User Successfully assigned to Team', 200);
    }


    public function unAssignRole(Request $request){
        $user = User::findOrfail($request->user_id);
        $role = Role::findOrfail($request->role_id);
        $role->users()->detach($user);

        return response()->json('User Successfully assigned to Team', 200);
    }

    public function setOwner(Request $request){
        $user = User::findOrfail($request->user_id);
        $team =Team::findOrfail($request->team_id);
        $team->owner = $user->id;
        $team->save();

        return response()->json('User Successfully assigned to Team', 200);
    }

}
