<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolistPage()
    {
        $this->withSession([
            'user' => 'udinsurudin'
        ])->get('/todolist')->assertSeeText('Sign Out');
    }

    public function testTodolistFailed()
    {
        $this->withSession([
            'user' => 'udinsurudin'
        ])->post('/todolist', [])->assertSeeText('Todo is required');
    }

    public function testTodolistSuccess()
    {
        $this->withSession([
            'user' => 'udinsurudin'
        ])->post('/todolist', [
            'id' => '1',
            'todo' => 'Memasak'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodo()
    {
        $this->withSession([
            'user' => 'udinsurudin'
        ])->post('/todolist', [
            'id' => '1',
            'todo' => 'Memasak'
        ])->assertRedirect('/todolist');

        $this->withSession([
            'user' => 'udinsurudin'
        ])->post('/todolist/1/delete')->assertRedirect('/todolist');
    }
}
