<?php

namespace App\Http\Controllers;

use App\Interfaces\TeamInterface;
use App\Repositories\BaseRepository;
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

    public function __construct(TeamInterface $teamRepasitory)
    {
        $this->team = $teamRepasitory;
    }

    public function showAllTeams()
    {
    	$this->team->all();
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
	    $team =$this->team->create($request->all());
	    \Auth::user()->teams()->attach($team,['owner'=>true]);

	    return response()->json($team, 201);

    }

    public function update($id, Request $request)
    {
        return response()->json($this->team->updateTeam($id,$request->all()), 200);
    }

    public function delete($id)
    {
		return $this->team->deleteTeam($id);

    }
    //
}
