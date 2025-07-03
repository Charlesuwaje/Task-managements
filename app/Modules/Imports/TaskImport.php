<?php

namespace App\Modules\Imports;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Modules\Enums\TaskStatus;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use App\Modules\User\Jobs\SendTaskAssignedNotification;

class TaskImport implements ToCollection, WithHeadingRow
{
    protected array $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $missingFields = [];
            $user = null;

            // Validate fields
            if (empty($row['title'])) {
                $missingFields[] = 'title';
            }

            if (empty($row['status']) || ! TaskStatus::tryFrom($row['status'])) {
                $missingFields[] = 'status (invalid or empty)';
            }

            if (empty($row['assigned_to_email'])) {
                $missingFields[] = 'assigned_to_email';
            } else {
                $user = User::where('email', $row['assigned_to_email'])->first();
                if (! $user) {
                    $missingFields[] = 'assigned_to_email (user not found)';
                }
            }

            if (empty($row['due_date'])) {
                $missingFields[] = 'due_date';
            }

            if (!empty($missingFields)) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'missing_fields' => $missingFields,
                    'data' => $row->toArray()
                ];
                continue;
            }

            try {
                $dueDate = is_numeric($row['due_date'])
                    ? \Carbon\Carbon::instance(ExcelDate::excelToDateTimeObject($row['due_date']))
                    : \Carbon\Carbon::parse($row['due_date']);

                $task = Task::create([
                    'title' => $row['title'],
                    'description' => $row['description'] ?? '',
                    'assigned_to' => $user->id,
                    'status' => TaskStatus::from($row['status'])->value,
                    'due_date' => $dueDate->format('Y-m-d'),
                ]);

                SendTaskAssignedNotification::dispatch($task, auth()->user());
            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'error' => $e->getMessage(),
                    'data' => $row->toArray()
                ];
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
