<?php

namespace App\Modules\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Modules\User\Notifications\TaskAssignedNotification;

class AdminTaskService
{

    public function createTask(array $data): Task
    {
        $task = Task::create($data);
        $user = $task->assignee;

        /** @var Admin $admin */
        $admin = Auth::user();

        $user->notify(new TaskAssignedNotification($task, $admin));

        return $task;
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    public function restoreTask(Task $task): void
    {
        $task->restore();
    }

    public function forceDelete(Task $task): void
    {
        $task->forceDelete();
    }

    public function getAllTasks()
    {
        return Task::all();
    }

    public function getTrashedTasks()
    {
        return Task::onlyTrashed()->get();
    }
}
