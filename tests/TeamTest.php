<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowAllTeams()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $this->get('api/teams', [],$this->headers($user));
        $this->seeStatusCode(200);

        $this->assertTrue(true);
    }

    public function testTeamShow()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $this->get('api/teams/1', [],$this->headers($user));
//        $this->seeStatusCode(200);
        $this->assertTrue(true);

    }

    public function testTeamCreate()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $parameters = [
            "title" => "Team",
        ];
        $this->post("api/teams", $parameters,$this->headers($user));
        $this->seeStatusCode(201);
        $this->seeInDatabase('teams', ['title' => 'Team']);
    }


    public function testTeamUpdate()
    {

        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $team = \App\Team::create([
            'title'=>'NewTeam'
        ]);

        $parameters = [
            "title" => "NewTeam2",
        ];
        $this->put("api/teams/".$team->id, $parameters, $this->headers($user));
        $this->seeStatusCode(401);
        $this->seeInDatabase('teams', ['title' => 'NewTeam']);

    }

    public function testTeamDestroy()
    {
        $user =\App\User::firstOrCreate([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $team = \App\Team::create([
            'title'=>'NewTeam'
        ]);
        $this->delete("api/teams/".$team->id, [], $this->headers($user));
        $this->seeStatusCode(401);
        $this->assertTrue(true);
    }
}
