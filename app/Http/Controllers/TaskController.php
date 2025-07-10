<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareTaskRequest;
use App\Http\Requests\TaskRequest;
use App\Models\SharedTasks;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Symfony\Component\VarDumper\Dumper\esc;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::forCurrentUser()
            ->search($request->all())
            ->orderBy('due_date', 'asc')
            ->get();

        return view('task.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = new Task($request->validated());
        $task->user_id = auth()->id();

        if ($task->save()) {
            return redirect(route('tasks.show', ['task' => $task]))->with('success', 'Task created successfully!');
        };

        return redirect(route('tasks.index'))->with('error', 'Task could not be created! Try again later!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('task.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        if ($task->update($request->validated())) {
            return redirect(route('tasks.show', ['task' => $task]))->with('success', 'Task updated successfully!');
        };

        return redirect(route('tasks.index'))->with('error', 'Task could not be updated! Try again later!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task): JsonResponse|RedirectResponse
    {
        $success = $task->delete();
        $message = $success ? 'Task deleted successfully!' : 'Task could not be deleted! Try again later!';

        if ($request->expectsJson()) {
            $response = response()->json(['message' => $message]);
            if (!$success) {
                $response->setStatusCode(500);
                session()->flash('error', $message);
            } else {
                session()->flash('success', $message);
            }

            return $response;
        }

        return redirect()
            ->route('tasks.index')
            ->with($success ? 'success' : 'error', $message);
    }

    public function share(Request $request, Task $task)
    {
        if (!$request->expectsJson()) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'expires_at' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $activeShares = $task->sharedNotExpiredTasks();
        if ($activeShares->count() >= 3) {
            return response()->json([
                'message' => 'Exceed limit of shared tasks!',
            ], 429);
        }

        $token = Str::random(30);

        $sharedTask = new SharedTasks();
        $sharedTask->task_id = $task->id;
        $sharedTask->token = $token;
        $sharedTask->expires_at = $request->input('expires_at');

        return response()->json($sharedTask->save() ?
            [
                'url' => route('tasks.shared-view', ['token' => $token]),
                'formatted_date' => Carbon::parse($sharedTask->expires_at)->format('F j H:i, Y')
            ] : [
                'error' => 'Task could not be shared! Try again later!'
            ]);
    }

    public function sharedView(Request $request, string $token)
    {
        $task = Task::bySharedToken($token)->first();
        if (!$task) {
            abort(404);
        }

        return view('task.show', ['task' => $task]);
    }
}
