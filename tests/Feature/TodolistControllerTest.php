<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "dnshaniff",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Belajar Laravel"
                ],
                [
                    "id" => "2",
                    "todo" => "Belajar JavaScript"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Belajar Laravel")
            ->assertSeeText("2")
            ->assertSeeText("Belajar JavaScript");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "dnshaniff"
        ])->post('/todolist', [])
        ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "dnshaniff"
        ])->post('/todolist', [
            "todo" => "Belajar Laravel"
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "dnshaniff",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Belajar Laravel"
                ],
                [
                    "id" => "2",
                    "todo" => "Belajar JavaScript"
                ]
            ]
        ])->post('/todolist/{1}/delete')
            ->assertRedirect('/todolist');
    }
}
