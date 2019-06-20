<?php

namespace App\Providers;

use App\Interfaces\RoleInterface;
use App\Interfaces\TeamInterface;
use App\Interfaces\UserInterface;
use App\Repositories\RoleRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(UserInterface::class,UserRepository::class);
		$this->app->bind(TeamInterface::class,TeamRepository::class);
		$this->app->bind(RoleInterface::class,RoleRepository::class);

	}
}