<?php
namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Role;

class RoleRepository  extends BaseRepository  implements RoleInterface
{
	protected  $model = Role::class;



}