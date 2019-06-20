<?php

use App\Team;
use App\User;
use Illuminate\Support\Facades\Hash;
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
            self::$user = $user = factory(User::class)->create([
                'password' => Hash::make('secret'),
            ]);
        }
    }

    public function testShowAllTeams()
    {
        $team = factory(Team::class, 10)->create();
        self::$user->teams()->attach($team,['owner'=>true]);

        $response = $this->actingAs(self::$user)->get('api/teams', []);
        $this->assertEquals($team[0]->title,json_decode($response->response->getContent())[0]->title);
        $response->seeJsonStructure([
            '*' => [
                'id', 'title','created_at','updated_at'
            ]
        ]);

        $this->seeStatusCode(200);
    }

    public function testShowAllMyTeams()
    {
        $team = factory(Team::class, 10)->create();
        $user = $user = factory(User::class)->create([
            'password' => Hash::make('secret'),
        ]);
       $user->teams()->attach($team,['owner'=>true]);

        $response = $this->actingAs($user)->get('api/teams', []);
        $this->assertEquals($team[0]->title,json_decode($response->response->getContent())[0]->title);
        $response->seeJsonStructure([
            '*' => [
                'id', 'title','created_at','updated_at'
            ]
        ]);

        $this->seeStatusCode(200);

    }

    public function testTeamShow()
    {

        $team = factory(Team::class)->create();
        $user = $user = factory(User::class)->create([
            'password' => Hash::make('secret'),
        ]);
       $user->teams()->attach($team,['owner'=>true]);

        $response = $this->actingAs($user)->get('api/teams/' . $team->id, []);

        $this->assertEquals($team->title,json_decode($response->response->getContent())->title);
        $response->seeJsonStructure([
            'id', 'title','created_at','updated_at',
        ]);

        $this->seeStatusCode(200);
        $response->assertResponseOk();
    }

    public function testTeamCreate()
    {
        $parameters = [
            "title" => "Team",
        ];
        $user = factory(User::class)->create([
            'password' => Hash::make('secret')
        ]);
        Auth::setUser($user);

        $response = $this->actingAs(self::$user)->post("api/teams", $parameters);
        $this->assertEquals($parameters['title'],json_decode($response->response->getContent())->title);

        $response->seeJsonStructure([
            'id', 'title','created_at','updated_at',
        ]);
        $this->seeInDatabase('teams', ['title' => 'Team']);
        $this->seeStatusCode(201);
    }


    public function testTeamUpdate()
    {
        $team = factory(Team::class)->create();
        $user = $user = factory(User::class)->create([
            'password' => Hash::make('secret'),
        ]);
        $user->teams()->attach($team, ['owner' => true]);

        $parameters = [
            "title" => "New Team",
        ];
        $response = $this->actingAs($user)->put("api/teams/" . $team->id, $parameters);
        $this->seeStatusCode(200);
        $this->seeInDatabase('teams', ['title' => 'New Team']);

    }

    public function testTeamDestroy()
    {

        $team = factory(Team::class)->create();
        $user = $user = factory(User::class)->create([
            'password' => Hash::make('secret'),
        ]);
        $user->teams()->attach($team, ['owner' => true]);
        $response = $this->actingAs($user)->delete("api/teams/" . $team->id, []);
        $response->assertResponseOk();
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
