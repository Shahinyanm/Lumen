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

    public function testShowAllUsers()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $this->get('api/users', $this->headers($user));
        $this->seeStatusCode(200);
//        $this->seeJson();

        $this->assertTrue(true);
    }

    public function testShow()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $this->get('api/users/1',  $this->headers($user));
        $this->seeStatusCode(200);
        $this->assertTrue(true);

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
        $this->put("api/users/1", $parameters,  $this->headers($user));
        $this->seeStatusCode(200);
        $this->seeInDatabase('users', ['email' => 'Newtest', 'email' => 'Newtest@test.com']);

    }

    public function testDestroy()
    {
        $user =\App\User::create([
            'name'=> 'Test',
            'email'=> 'Test@example.com',
            'password'=> 'secret',
        ]);
        $this->delete("api/users/".$user->id, [],  $this->headers($user));
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
