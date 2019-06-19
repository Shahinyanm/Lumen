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

    public function setUp(): void
    {
        parent::setUp();

        $this->runDatabaseMigrations();

    }

    public function testShowAllroles()
    {
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $this->get('api/roles', [],$this->headers($user));
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
        $this->get('api/roles/'.$role->id, $this->headers($user));
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
        $this->post("api/roles", $parameters, $this->headers($user));
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
        $this->put("api/roles/".$role->id, $parameters, $this->headers($user));
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
        $this->delete("api/roles/".$role->id, [], $this->headers($user));
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
