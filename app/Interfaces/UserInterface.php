<?php
namespace App\Interfaces;

use mysql_xdevapi\Collection;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;

interface UserInterface
{
	public function showAllUsers() ;

	public function showAllUsersWithTeam() ;

	public function show($id);

	public function update($id,$data);

	public function save($id,$data);

	public function destroy($id);







}