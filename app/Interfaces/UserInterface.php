<?php
namespace App\Interfaces;

use mysql_xdevapi\Collection;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;

interface UserInterface extends BaseRepositoryInterface
{
	public function showAllUsers() ;

	public function showAllUsersWithTeam() ;









}