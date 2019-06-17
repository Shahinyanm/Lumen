<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class Usertest extends testCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowAllUsers()
    {
        $this->get('api/users', []);
        $this->seeStatusCode(200);
        $this->seeJson();
//        $this->seeJsonStructure(
//            ['*' => ['*' =>
//                [
//                    'id',
//                    'name',
//                    'email',
//                    'created_at',
//                    'updated_at',
//                ]
//            ]
//            ]
//        );
        $this->assertTrue(true);
    }

    public function testShow()
    {
        $this->get('api/users/1', []);
        $this->seeStatusCode(200);
        $this->assertTrue(true);
//        $this->seeJsonStructure(
//            ['data' =>
//                [
//                    'id',
//                    'name',
//                    'email',
//                    'created_at',
//                    'updated_at',
//                ]
//            ]
//        );
    }

    public function testCreate()
    {
        $parameters = [
            "name" => "test",
            "email" => "test@test.com",
            "password" => "secret"
        ];
        $this->post("api/users", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeInDatabase('users', ['email' => 'test', 'email' => 'test@test.com']);
    }


    public function testUpdate()
    {
        $parameters = [
            "name" => "Newtest",
            "email" => "Newtest@test.com",
            "password" => "secret"
        ];
        $this->put("api/users/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeInDatabase('users', ['email' => 'Newtest', 'email' => 'Newtest@test.com']);


    }

    public function testDestroy()
    {

        $this->delete("api/users/11", [], []);
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
