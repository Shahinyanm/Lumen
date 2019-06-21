<?php

namespace App\Interfaces;

interface TeamInterface extends BaseRepositoryInterface{

	public function showAllTeams();

	public function showAllMyTeams();

	public function showTeam($id);


	public function updateTeam($id,$data);

	public function deleteTeam($id);

	public function pivot($id);

	public function find($id);

	public function userInTeam($team_id, $user_id);

	public function detachUser($user,$team_id);

}