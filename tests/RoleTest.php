<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

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
            self::$user = $user = factory(\App\User::class)->create([
                'password' => \Illuminate\Support\Facades\Hash::make('secret'),
            ]);
        }
    }

    public function testShowAllRoles()
    {
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $response = $this->actingAs(self::$user)->get('api/roles', []);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }

    public function testRoleShow()
    {
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $role= \App\Role::create(['title'=>'admin']);
        $response = $this->actingAs(self::$user)->get('api/roles/'.$role->id);
        $this->seeStatusCode(200);
        $this->assertTrue(true);

    }

    public function testRoleCreate()
    {
        $user = factory(\App\User::class)->create([
            'password'=>\Illuminate\Support\Facades\Hash::make('secret')
        ]);
        $parameters = [
            "title" => "role",
        ];
        $response = $this->actingAs(self::$user)->post("api/roles", $parameters);
        $this->seeStatusCode(201);
        $this->seeInDatabase('roles', ['title' => 'role']);
    }


    public function testRoleUpdate()
    {
        $user = factory(\App\User::class)->create([
            'password'=>\Illuminate\Support\Facades\Hash::make('secret')
        ]);
        $parameters = [
            "title" => "Newrole",
        ];
        $role = \App\Role::firstOrCreate([
            'title'=>'owner'
        ]);
        $response = $this->actingAs(self::$user)->put("api/roles/".$role->id, $parameters);
        $this->seeStatusCode(200);
        $this->seeInDatabase('roles', ['title' => 'Newrole']);

    }

    public function testRoleDestroy()
    {
        $user = factory(\App\User::class)->create([
            'password'=>\Illuminate\Support\Facades\Hash::make('secret')
        ]);
        $role = \App\Role::firstOrCreate([
            'title'=>'owner'
        ]);
        $response = $this->actingAs(self::$user)->delete("api/roles/".$role->id, []);
        $this->seeStatusCode(200);
    }
}
