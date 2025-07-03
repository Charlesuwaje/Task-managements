<!DOCTYPE html>
<html>

<head>
    <title>Task Assigned</title>
</head>

<body>
    <h2>Hello {{ $task->assignee->name }},</h2>

    <p>You have been assigned a new task by <strong>{{ $admin->name }}</strong>.</p>

    <h4>Task Details:</h4>
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->toFormattedDateString() }}</li>
    </ul>

    <p>Please log in to the system to update the task status when done.</p>

    <p>Thanks,<br />Team Task Manager</p>
</body>

</html>
