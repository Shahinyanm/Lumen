<?php

use Laravel\Lumen\testing\DatabaseMigrations;
use Laravel\Lumen\testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

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
            'email' => 'test2@email.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'name' => 'test user'
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
        \App\User::create([
            'email' => 'test2@email.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'name'=>'test'
        ]);
        $response = $this->post('api/login', [
            'email' => 'test2@email.com',
            'password' => '123456'
        ]);
        $response->seeStatusCode(200);

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
            'email' => 'test2@email.com',
            'password' => 'notlegitpassword'
        ]);

        $response->seeJsonStructure([
            'error',
        ]);
    }

    public function it_will_log_out_user()
    {
        $user = \App\User::create([
            'name' => 'Test',
            'email' => 'Test@example.com',
            'password' => 'secret',
        ]);
        $response = $this->post('api/logout', [
            'email' => 'test2@email.com',
            'password' => 'notlegitpassword'
        ],
            $this->headers($user));
        $this->seeStatusCode(200);

    }

}
