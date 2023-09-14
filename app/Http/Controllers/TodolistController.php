<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodolistController extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todoList(): Response
    {
        $todolist = $this->todolistService->getTodolist();

        $data = [
            "title" => "Todolist Page",
            "todolist" => $todolist
        ];

        return response()->view('todolist.index', $data);
    }

    public function addTodo(Request $request): Response|RedirectResponse
    {
        $todo = $request->input('todo');

        // check input empty
        if (empty($todo)) {
            $todolist = $this->todolistService->getTodolist();
            return response()->view('todolist.index', [
                'title' => 'Todolist Page',
                'todolist' => $todolist,
                'error' => 'Todo is required'
            ]);
        }

        // save todolist
        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todoList']);
    }

    public function removeTodo()
    {
    }
}
