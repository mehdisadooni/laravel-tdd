<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $todos = Auth::user()->todos;
        return response($todos);
    }

    /**
     * Store a newly created resource in storage.
     * @param TodoRequest $request
     * @return mixed
     */
    public function store(TodoRequest $request)
    {
        return Auth::user()->todos()->create([
            'name' => $request->name,
        ]);
//        return response($todo, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return response($todo);
    }

    /**
     * @param TodoRequest $request
     * @param Todo $todo
     * @return bool
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        return tap($todo)->update([
            'name' => $request->name
        ]);
    }

    /**
     * @param Todo $todo
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response('deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
