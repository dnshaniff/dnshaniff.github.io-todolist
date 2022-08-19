<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
        ->assertSeeText('Login');
    }

    public function testLoginForMember()
    {
        $this->withSession([
            "user" => "dnshaniff"
        ])->get('/login')
            ->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'dnshaniff',
            'password' => '123456'
         ])->assertRedirect("/")
        ->assertSessionHas("user", "dnshaniff");
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "dnshaniff"
        ])->post('/login', [
            'user' => 'dnshaniff',
            'password' => '123456'
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [
            'user' => '',
            'password' => ''
        ])->assertSeeText("Username and password are required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'denis',
            'password' => 'denis'
        ])->assertSeeText("Username or password is incorrect");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "dnshaniff"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }

}
