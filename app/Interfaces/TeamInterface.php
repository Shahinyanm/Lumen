<?php

namespace App\Interfaces;

interface TeamInterface {

	public function showAllTeams();

	public function showAllMyTeams();

	public function showTeam($id);

	public function create($data);

	public function update($id,$data);

	public function delete($id);

	public function pivot($id);

	public function find($id);

	public function userInTeam($team_id, $user_id);

	public function detachUser($user,$team_id);

}