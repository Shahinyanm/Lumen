<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class AuthTest extends TestCase
{
//    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
//    public function testLogin()
//    {
//        $params=[
//            'email'=>'testuser@test.com',
//            'password'=>'secret',
//        ];
//        $this->get('api/login',$params, []);
//        $this->seeStatusCode(200);
//        $this->seeJson([
//            'access_token',
//            'token_type',
//            'expires_in',
//        ]);
//
//        $this->assertTrue(true);
//    }


    /** @test */
    public function it_will_register_a_user()
    {
        $response = $this->post('api/register', [
            'email'    => 'test2@email.com',
            'password' => '123456',
            'name'=>'test user'
        ]);

        $response->seeJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    /** @test */
    public function it_will_log_a_user_in()
    {
        $response = $this->post('api/login', [
            'email'    => 'test2@email.com',
            'password' => '123456'
        ]);
        $this->seeStatusCode(200);

        $response->seeJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    /** @test */
    public function it_will_not_log_an_invalid_user_in()
    {
        $response = $this->post('api/login', [
            'email'    => 'test2@email.com',
            'password' => 'notlegitpassword'
        ]);

        $response->seeJsonStructure([
            'error',
        ]);
    }

}
