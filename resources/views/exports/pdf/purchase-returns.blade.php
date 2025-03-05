<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Returns</title>
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
        <h1>Purchase Returns</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Purchase ID</th>
                <th>Supplier Name</th>
                <th>Return Quantity</th>
                <th>Remarks</th>
                <th>Returned At</th>
                <th>Returned By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseReturns as $data)
            <tr>
                <td>{{ $data->purchase->invoice_number }}</td>
                <td>{{ $data->purchase->supplier->name }}</td>
                <td>{{ $data->return_quantity }}</td>
                <td>{{ $data->remark }}</td>
                <td>{{ dateFormat($data->created_at) }}</td>
                <td>{{ $data->user->name ?? '-' }}</td>
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