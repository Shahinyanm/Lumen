<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class UserTest extends TestCase
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


    public function testShowAllUsers()
    {

        $response = $this->actingAs(self::$user)->get('api/users', []);
        $response->seeJsonStructure([
            '*' => [
                'id', 'name','email','created_at'
            ]
        ]);
        $this->seeStatusCode(200);

    }

    public function testShow()
    {
        $users = factory(\App\User::class,10)->create([
            'password' => \Illuminate\Support\Facades\Hash::make('secret'),
        ]);
        $response = $this->actingAs(self::$user)->get('api/users/1',[]);

        $response->seeJsonStructure([
            'id', 'name','email','created_at'
        ]);
        $this->seeStatusCode(200);
        $response->assertResponseStatus(200);

    }

//    public function testCreate()
//    {
//        $parameters = [
//            "name" => "test",
//            "email" => "test@test.com",
//            "password" => "secret"
//        ];
//        $this->post("api/users", $parameters, []);
//        $this->seeStatusCode(201);
//        $this->seeInDatabase('users', ['email' => 'test', 'email' => 'test@test.com']);
//    }


    public function testUpdate()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $parameters = [
            "name" => "Newtest",
            "email" => "Newtest@test.com",
            "password" => "secret"
        ];
        $response = $this->actingAs(self::$user)->put("api/users/1", $parameters);
        $this->seeStatusCode(200);
        $response->assertResponseStatus(200);
        $this->seeInDatabase('users', ['email' => 'Newtest', 'email' => 'Newtest@test.com']);

    }

    public function testDestroy()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $response = $this->actingAs(self::$user)->delete("api/users/".self::$user->id, []);
        $this->seeStatusCode(200);
        $response->assertResponseStatus(200);
        $this->assertTrue(true);
    }


    public function testDestroyFailed()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $response = $this->actingAs($user)->delete("api/users/".$user->id, []);
//        dd(json_decode($response->response->getContent()));
       $response->assertResponseStatus(200);

        $this->assertTrue(true);
    }
}
