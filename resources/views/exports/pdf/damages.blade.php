<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damages</title>
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
        <h1>Damages</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Remark</th>
                <th>Total Damaged Quantity</th>
                <th>Damage Date</th>
                <th>Damage By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($damages as $data)
            <tr>
                <td>{{ $data->remark ?? '-'}}</td>
                <td>{{ number_format($data->total_quantity) }}</td>
                <td>{{ dateFormat($data->damage_date) }}</td>
                <td>{{ $data->user?->name }}</td>
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