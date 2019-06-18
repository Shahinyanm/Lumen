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
    public function testShowAllroles()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $this->get('api/roles', []);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }

    public function testRoleShow()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $role= \App\Role::create(['title'=>'admin']);
        $this->get('api/roles/'.$role->id, $this->headers($user));
        $this->seeStatusCode(200);
        $this->assertTrue(true);

    }

    public function testRoleCreate()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
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
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
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
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $role = \App\Role::firstOrCreate([
            'title'=>'owner'
        ]);
        $this->delete("api/roles/".$role->id, [], $this->headers($user));
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
