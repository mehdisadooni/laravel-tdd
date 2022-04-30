<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\Todo;
use Symfony\Component\HttpFoundation\Response;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Todo $todo)
    {
        return response($todo->tasks);
    }

    /**
     * Store a newly created resource in storage.
     * @param TaskRequest $request
     * @return mixed
     */
    public function store(TaskRequest $request, Todo $todo)
    {
        return $todo->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'label_id' => $request->label_id,
        ]);
    }


    /**
     * @param TaskRequest $request
     * @param Task $task
     * @return bool
     */
    public function update(TaskRequest $request, Task $task)
    {
        return tap($task)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response('deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
