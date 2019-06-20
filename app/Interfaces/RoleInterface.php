<?php

namespace App\Interfaces;

interface RoleInterface
{
	public function showAllRoles();
	public function show($id);
	public function create($data);
	public function update($id,$data);
	public function delete($id);



}