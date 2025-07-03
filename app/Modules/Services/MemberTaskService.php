<?php

namespace App\Modules\Services;
use App\Models\Task;
use App\Models\User;
use App\Modules\Enums\TaskStatus;

class MemberTaskService
{
    public function getOwnTasks(User $user)
    {
        return $user->tasks;
    }

    public function updateStatus(User $user, Task $task, TaskStatus $status): ?Task
    {
        if ($task->assigned_to !== $user->id) {
            return null;
        }
    
        $task->update(['status' => $status->value]);
    
        return $task;
    }
    
}
