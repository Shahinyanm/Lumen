<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;

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


    public function showAllTeams()
    {

        return response()->json(Team::all());
    }

    public function show($id)
    {

        return response()->json(Team::findOrFail($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $team = Team::create($request->all());

        return response()->json($team, 201);

    }


    public function update($id, Request $request)
    {
        $team = Team::findOrFail($id);
        $team->update($request->all());

        return response()->json($team, 200);
    }

    public function delete($id)
    {
        Team::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
    //
}
