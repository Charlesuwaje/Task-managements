<?php

namespace App\Modules\User\Controllers\Admin;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Modules\Imports\TaskImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ApiController;
use App\Modules\Exports\TemplateExport;
use App\Modules\Services\AdminTaskService;

class AdminTaskController extends ApiController
{
    public function __construct(
        public readonly AdminTaskService $adminTaskService
    ) {}

    public function index()
    {
        $tasks = $this->adminTaskService->getAllTasks();
        return $this->success($tasks);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
        ]);

        $task = $this->adminTaskService->createTask($data);

        return $this->success($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->only(['title', 'description', 'assigned_to', 'status', 'due_date']);

        $updatedTask = $this->adminTaskService->updateTask($task, $data);

        return $this->success($updatedTask);
    }

    public function destroy(Task $task)
    {
        $this->adminTaskService->deleteTask($task);

        return $this->Ok('Task deleted');
    }

    public function trashed()
    {
        return $this->success($this->adminTaskService->getTrashedTasks());
    }


    public function restore($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $this->adminTaskService->restoreTask($task);

        return $this->Ok('Task restored');
    }

    public function forceDelete($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task = $this->adminTaskService->forceDelete($task);

        return $this->Ok('Task permanently deleted');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    $import = new TaskImport();
    Excel::import($import, $request->file('file'));

    $errors = $import->getErrors();

    if (!empty($errors)) {
        return $this->error('Some rows failed to import.', 422, [], [
            'failures' => $errors
        ]);
    }

    return $this->Ok('Tasks imported successfully.');
}

}
