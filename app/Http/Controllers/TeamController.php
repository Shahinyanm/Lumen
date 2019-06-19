<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function showAllTeams(Auth $auth)
    {
        $teams = Team::with('users', 'owner')->whereHas('users', function ($u) {
            return $u->where('user_id', \Auth::id());
        })->orWhere('owner', \Auth::id())->get();

        return response()->json($teams);
    }

    public function show($id)
    {
        $team = Team::with('users', 'owner')
            ->where('id', $id)
            ->whereHas('users', function ($u) {
                return $u->where('user_id', \Auth::id());
            })
            ->orWhere('owner', \Auth::id())
            ->first();


        return response()->json($team);
    }

    public function create(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
        ]);
        $team = new Team();
        $team->title = $request->title;
        $team->save();
        \Auth::user()->teams()->attach($team,['owner'=>true]);


        return response()->json($team, 201);

    }


    public function update($id, Request $request)
    {
        $team = Team::with('users')->find($id);
        if(!$team){
            return response()->json(['failed','There are no team with '. $id.' id'],401);
        }
        $pivot = optional($team->users->find(\Auth::id()))->pivot;
        if (!$pivot || !$pivot->owner) {
            return response()->json('You can not update team, because you are not owner', 401);
        }
        $team->update($request->all());

        return response()->json($team, 200);
    }

    public function delete($id)
    {

        $team = Team::with('users')->find($id);

        if(!$team){
            return response()->json(['failed','There are no team with '. $id.' id'],401);
        }
        $pivot = optional($team->users->find(\Auth::id()))->pivot;
        if (!$pivot || !$pivot->owner) {
            return response()->json('You can not delete team, because you are not owner', 401);
        }
        $team->delete();
        return response('Deleted Successfully', 200);
    }
    //
}
