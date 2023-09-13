<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo('1', 'Udin');

        $todolist = Session::get('todolist');

        foreach ($todolist as $item) {
            self::assertEquals("1", $item['id']);
            self::assertEquals('Udin', $item['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Memasak"
            ],
            [
                "id" => "2",
                "todo" => "Menulis"
            ]
        ];

        $this->todolistService->saveTodo('1', 'Memasak');
        $this->todolistService->saveTodo('2', 'Menulis');

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo('1', 'Melompat');
        $this->todolistService->saveTodo('2', 'Berenang');

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('3');
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('2');
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('1');
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
