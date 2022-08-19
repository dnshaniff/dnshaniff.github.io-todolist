<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    public function setUp():void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login("dnshaniff", "123456"));
    }

    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login("denis", "denis"));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login("dnshaniff", "111111"));
    }

    public function testLoginWrongUser()
    {
        self::assertFalse($this->userService->login("denis", "123456"));
    }
}
