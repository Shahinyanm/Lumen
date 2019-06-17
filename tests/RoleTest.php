<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class RoleTest extends testCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowAllroles()
    {
        $this->get('api/roles', []);
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

    public function testroleShow()
    {
        $this->get('api/roles/1', []);
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

    public function testroleCreate()
    {
        $parameters = [
            "title" => "role",
        ];
        $this->post("api/roles", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeInDatabase('roles', ['title' => 'role']);
    }


    public function testroleUpdate()
    {
        $parameters = [
            "title" => "Newrole",
        ];
        $this->put("api/roles/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeInDatabase('roles', ['title' => 'Newrole']);

    }

    public function testroleDestroy()
    {

        $this->delete("api/roles/1", [], []);
        $this->seeStatusCode(200);
        $this->assertTrue(true);
    }
}
