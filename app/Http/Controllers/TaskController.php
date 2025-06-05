<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::paginate(10);
        return response()->json($tasks);
    }


    public function store(Request $request)
    {

    }


    public function show(Task $task)
    {

    }


    public function update(Request $request, Task $task)
    {

    }


    public function destroy(Task $task)
    {
        //
    }
}
