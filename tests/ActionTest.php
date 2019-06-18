<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class ActionTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAssignTeam()
    {
        $user = \App\User::create([
            'name' => 'Test',
            'email' => 'Test@example.com',
            'password' => 'secret',
        ]);
        $team = \App\Team::create([
            'title' => 'New Team'
        ]);
        $parametr = [
            'team_id' => $team->id,
            'user_id' => $user->id
        ];
        $this->post('api/assignTeam', $parametr, $this->headers($user));
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }


    public function testAssignRole()
    {
        $user = \App\User::create([
            'name' => 'Test',
            'email' => 'Test@example.com',
            'password' => 'secret',
        ]);
        $role = \App\Role::create([
            'title' => 'New Team'
        ]);
        $parametr = [
            'role_id' => $role->id,
            'user_id' => $user->id
        ];
        $this->post('api/assignRole', $parametr, $this->headers($user));
        $this->seeStatusCode(401);
        $this->seeJson();
        $this->assertTrue(true);
    }


    public function testUnAssignRole()
    {
        $user = \App\User::create([
            'name' => 'Test',
            'email' => 'Test@example.com',
            'password' => 'secret',
        ]);
        $role = new \App\Role();
            $role->title = 'New Role';
        $user->roles()->save($role);

        $parametr = [
            'role_id' => $role->id,
            'user_id' => $user->id
        ];
        $this->post('api/unAssignRole', $parametr, $this->headers($user));
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }


    public function testUnAssignTeam()
    {
        $user = \App\User::create([
            'name' => 'Test',
            'email' => 'Test@example.com',
            'password' => 'secret',
        ]);
        $team = new \App\Team();
        $team->title = "New Team";

        $user->teams()->save($team);
        $parametr = [
            'team_id' => $team->id,
            'user_id' => $user->id
        ];
        $this->post('api/unAssignTeam', $parametr, $this->headers($user));
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }

    public function testSetOwner()
    {
        $user = \App\User::create([
            'name' => 'Test',
            'email' => 'Test@example.com',
            'password' => 'secret',
        ]);
        $team = \App\Team::create([
            'title' => 'New Team'
        ]);
        $parametr = [
            'team_id' => $team->id,
            'user_id' => $user->id
        ];
        $this->post('api/unAssignTeam', $parametr, $this->headers($user));
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }
}
