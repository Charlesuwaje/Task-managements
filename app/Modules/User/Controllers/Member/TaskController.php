<?php

namespace App\Modules\User\Controllers\Member;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Modules\Enums\TaskStatus;
use App\Http\Controllers\ApiController;
use App\Modules\Services\MemberTaskService;
use App\Modules\User\Requests\UpdateTaskStatusRequest;

class TaskController extends ApiController
{

    public function __construct(
        public readonly MemberTaskService $memberTaskService
    ) {}

    public function index()
    {
        $tasks = $this->memberTaskService->getOwnTasks(auth()->user());
        return $this->success($tasks);
    }

    public function update(UpdateTaskStatusRequest $request, Task $task)
    {
        $status = TaskStatus::from($request->validated()['status']);

        $updatedTask = $this->memberTaskService->updateStatus($request->user(), $task, $status);

        if (! $updatedTask) {
            return $this->error('Unauthorized', 403);
        }

        return $this->success($updatedTask);
    }
}
