<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Roles</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Role Name</th>
                <th>User</th>
                <th>Permission Allowed</th>
                <th>All Permission</th>
                <th>Created At</th>
                <th>Created By</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $data)
            <tr>
                <td>{{ $data->name ?? '-' }}</td>
                <td>{{ $data->users?->count() ?? '-' }}</td>
                <td>{{ $data->permissions?->count() }}</td>
                <td>{{ \App\Models\Permission::count() }}</td>
                <td>{{ dateFormat($data->created_at) ?? '-' }}</td>
                <td>{{ $data->user?->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="header">
            <h1>Mobile Shop POS</h1>
        </div>
    </div>
</body>