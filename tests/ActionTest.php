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

    public function testAssignTeam()
    {
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $team = \App\Team::create([
            'title' => 'New Team'
        ]);
        self::$user->teams()->attach($team,['owner'=>self::$user->id]);

        $parametr = [
            'team_id' => $team->id,
            'user_id' => $user->id
        ];
        $response = $this->actingAs(self::$user)->post('api/assignTeam', $parametr);
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }


    public function testAssignRole()
    {
        $role = \App\Role::create([
            'title' => 'New Team'
        ]);
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $parametr = [
            'role_id' => $role->id,
            'user_id' => $user->id
        ];
        $response = $this->actingAs($user)->post('api/assignRole', $parametr);
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }


    public function testUnAssignRole()
    {
//
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $role = new \App\Role();
            $role->title = 'New Role';
        self::$user->roles()->save($role);

        $parametr = [
            'role_id' => $role->id,
            'user_id' => self::$user->id
        ];
        $this->post('api/unAssignRole', $parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }


    public function testUnAssignTeam()
    {
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $team = \App\Team::create([
            'title' => 'New Team'
        ]);
        self::$user->teams()->attach($team,['owner'=>self::$user->id]);
        $user->teams()->save($team);
        $parametr = [
            'team_id' => $team->id,
            'user_id' => $user->id
        ];
        $response = $this->actingAs($user)->post('api/unAssignTeam', $parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }

    public function testSetOwner()
    {
        $user = factory(\App\User::class)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $team = \App\Team::create([
            'title' => 'New Team'
        ]);
        self::$user->teams()->attach($team,['owner'=>true]);
        $parametr = [
            'team_id' => $team->id,
            'user_id' => $user->id
        ];
        $response = $this->actingAs($user)->post('api/unAssignTeam', $parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }
}
