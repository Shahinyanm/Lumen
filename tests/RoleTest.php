<?php

use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\testing\DatabaseMigrations;

class RoleTest extends TestCase
{
	use DatabaseMigrations;
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	protected static $user;

	public function setUp(): void
	{
		parent::setUp();

		$this->runDatabaseMigrations();
		if (is_null(self::$user)) {
			self::$user = $user = factory(User::class)->create([
				'password' => Hash::make('secret'),
			]);
		}
	}

	public function testShowAllRoles()
	{
		$user = factory(User::class)->create([
			'password' => Hash::make('secret'),
		]);
		$response = $this->actingAs(self::$user)->get('api/roles', []);
		$this->seeStatusCode(200);
		$response->assertResponseStatus(200);
		$response->seeJsonStructure([
			'*' => [
				'id', 'title', 'created_at', 'updated_at',
			]
		]);
		$response->assertResponseStatus(200);
		$this->seeJson();
	}

	public function testRoleShow()
	{
		$user = factory(User::class)->create([
			'password' => Hash::make('secret'),
		]);
		$role = Role::create(['title' => 'admin']);
		$response = $this->actingAs(self::$user)->get('api/roles/' . $role->id);
		$response->seeJsonStructure([
			'id', 'title', 'created_at', 'updated_at',
		]);
		$response->assertResponseStatus(200);
		$this->seeStatusCode(200);

	}

	public function testRoleCreate()
	{
		$user = factory(User::class)->create([
			'password' => Hash::make('secret')
		]);
		$parameters = [
			"title" => "role",
		];
		$response = $this->actingAs(self::$user)->post("api/roles", $parameters);
		$this->seeStatusCode(201);
		$response->assertResponseStatus(201);
		$this->seeInDatabase('roles', ['title' => 'role']);
	}


	public function testRoleUpdate()
	{
		$user = factory(User::class)->create([
			'password' => Hash::make('secret')
		]);
		$parameters = [
			"title" => "Newrole",
		];
		$role = Role::firstOrCreate([
			'title' => 'owner'
		]);
		$response = $this->actingAs(self::$user)->put("api/roles/" . $role->id, $parameters);
		$this->seeStatusCode(200);
		$response->assertResponseOk(200);
		$this->seeInDatabase('roles', ['title' => 'Newrole']);

	}

	public function testRoleDestroy()
	{
		$user = factory(User::class)->create([
			'password' => Hash::make('secret')
		]);
		$role = Role::firstOrCreate([
			'title' => 'owner'
		]);
		$response = $this->actingAs(self::$user)->delete("api/roles/" . $role->id, []);
		$response->assertResponseStatus(200);
		$this->seeStatusCode(200);
	}
}
