<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class ActionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAssignTeam()
    {
        $parametr=[
                'team_id'=>1,
                'user_id'=>1
        ];
        $this->post('api/assignTeam',$parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }


    public function testAssignRole()
    {
        $parametr=[
            'role_id'=>1,
            'user_id'=>1
        ];
        $this->post('api/assignRole',$parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }


    public function testUnAssignRole()
    {
        $parametr=[
            'role_id'=>1,
            'user_id'=>1
        ];
        $this->post('api/unAssignRole',$parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }


    public function testUnAssignTeam()
    {
        $parametr=[
            'team_id'=>1,
            'user_id'=>1
        ];
        $this->post('api/unAssignTeam',$parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }

    public function testSetOwner()
    {
        $parametr=[
            'team_id'=>1,
            'user_id'=>1
        ];
        $this->post('api/unAssignTeam',$parametr);
        $this->seeStatusCode(200);
        $this->seeJson();
        $this->assertTrue(true);
    }
}
