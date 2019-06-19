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

    protected static $user;
    public function setUp(): void
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        if (is_null(self::$user)) {
            self::$user =  $user = factory(\App\User::class)->create([
                'password' => \Illuminate\Support\Facades\Hash::make('secret'),
            ]);
        }
    }

    public function testShowAllTeams()
    {
        $team = factory(\App\Team::class,10)->create();

        $this->get('api/teams', [],$this->headers(self::$user));
        $this->seeStatusCode(200);

        $this->assertTrue(true);
    }

    public function testTeamShow()
    {
        $team = factory(\App\Team::class)->create();
        $this->get('api/teams/'.$team->id, [],$this->headers(self::$user));
        $this->seeStatusCode(200);
        $this->assertTrue(true);

    }

    public function testTeamCreate()
    {

        $parameters = [
            "title" => "Team",
        ];
        $this->post("api/teams", $parameters,$this->headers(self::$user));
        $this->seeStatusCode(201);
        $this->seeInDatabase('teams', ['title' => 'Team']);
    }


    public function testTeamUpdate()
    {
        $team = factory(\App\Team::class)->create();
        self::$user->teams()->attach($team,['owner'=>true]);

        $parameters = [
            "title" => "New Team",
        ];
        $this->put("api/teams/".$team->id, $parameters, $this->headers(self::$user));
        $this->seeStatusCode(200);
        $this->seeInDatabase('teams', ['title' => 'New Team']);

    }

    public function testTeamDestroy()
    {

        $team = factory(\App\Team::class)->create();
        self::$user->teams()->attach($team,['owner'=>true]);
        $this->delete("api/teams/".$team->id, [], $this->headers(self::$user));
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
