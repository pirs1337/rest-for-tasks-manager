<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Task\StoreRequest;
use App\Http\Requests\Api\V1\Task\UpdateRequest;
use App\Http\Resources\Api\V1\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends SendController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    private const TASK = [
        'store' => 'Task created',
        'update' => 'Task updated',
        'destroy' => 'Task deleted',
        'not_found' => 'Task not found'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query('status'); 

        if ($status) {
            $tasks = Task::where('user_id', Auth::id())->where('status', $status)->get();
        } else {
            $tasks = Task::where('user_id', Auth::id())->get();
        }

        return $this->sendSuccess(['data' => TaskResource::collection($tasks)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $task = Task::create($validated);
        return $this->sendSuccess(['msg' => self::TASK['store'], 'data' => new TaskResource($task)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        if ($task) {

            if ($task->user_id == Auth::id()) {

                return $this->sendSuccess(['data' => new TaskResource($task)]);
            }

            return $this->sendAccessDenied();

        }

        return $this->notFound();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $task = Task::find($id);

        if ($task) {

            if ($task->user_id == Auth::id()) {
                
                $task->update($validated);
                return $this->sendSuccess(['msg' => self::TASK['update'], 'data'=> new TaskResource($task)]);
            }

            return $this->sendAccessDenied();
        }

        return $this->notFound();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task) {

            if ($task->user_id == Auth::id()) {

                $task->delete();
                return $this->sendSuccess(['msg' => self::TASK['destroy']]);
            }

            return $this->sendAccessDenied();

        }

        return $this->notFound();
    }

    private function notFound(){
        return $this->sendError(['msg' => self::TASK['not_found']], 404);
    }
}
