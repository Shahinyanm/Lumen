<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class TeamTest extends testCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowAllTeams()
    {
        $this->get('api/teams', []);
        $this->seeStatusCode(200);
        $this->seeJson();

        $this->assertTrue(true);
    }

    public function testTeamShow()
    {
        $this->get('api/teams/1', []);
        $this->seeStatusCode(200);
        $this->assertTrue(true);

    }

    public function testTeamCreate()
    {
        $parameters = [
            "title" => "Team",
        ];
        $this->post("api/teams", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeInDatabase('teams', ['title' => 'Team']);
    }


    public function testTeamUpdate()
    {
        $parameters = [
            "title" => "NewTeam",
        ];
        $this->put("api/teams/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeInDatabase('teams', ['title' => 'NewTeam']);

    }

    public function testTeamDestroy()
    {

        $this->delete("api/teams/1", [], []);
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
