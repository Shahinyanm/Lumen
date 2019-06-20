<?php

namespace App\Http\Controllers;

use App\Interfaces\TeamInterface;
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

    protected $team;

    public function __construct(TeamInterface $teamRepository)
    {
        $this->team = $teamRepository;
    }

    public function showAllTeams()
    {
        return response()->json($this->team->showAllTeams());
    }

    public function showAllMyTeams()
    {
        return response()->json($this->team->showAllMyTeams());
    }

    public function show($id)
    {
        return response()->json($this->team->showTeam($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        return response()->json($this->team->create($request->all()), 201);

    }

    public function update($id, Request $request)
    {
        return response()->json($this->team->update($id,$request->all()), 200);
    }

    public function delete($id)
    {
		return $this->team->delete($id);

    }
    //
}
