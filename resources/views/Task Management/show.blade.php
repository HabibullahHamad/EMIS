<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1" border-radius="10" cellpadding="10" cellspacing="0" style="width: 50%; margin: auto; border-collapse: collapse;">
        <tr>
            <th>Task Details</th>
        </tr>
        <tr>
            <td>Title: {{ $task->title }}</td>
        </tr>
        <tr>
            <td>Description: {{ $task->description }}</td>
        </tr>
        <tr>
            <td>Assigned By: {{ $task->assigned_by }}</td>
        </tr>
        <tr>
            <td>Assigned To: {{ $task->assigned_to }}</td>
        </tr>
        <tr>
            <td>Priority: {{ $task->priority }}</td>
        </tr>
        <tr>
            <td>Status: {{ $task->status }}</td>
        </tr>
        <tr>
            <td>Due Date: {{ $task->due_date }}</td>
        </tr>
    </table>    
</body>
</html>