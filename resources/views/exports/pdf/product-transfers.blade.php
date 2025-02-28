<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Transfers</title>
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
        <h1>Product Transfer</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Remark</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>Created By</th>
                <th>Status</th>
                <th>Transfer Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product_transfers as $data)
            <tr>
                <td>{{ $data->transfer_inv_code ?? '' }}</td>
                <td>{{ $data->remark ?? '-' }}</td>
                <td>{{ $data->fromLocationName->location_name ?? '-' }}</td>
                <td>{{ $data->toLocationName->location_name ?? '-' }}</td>
                <td>{{ $data->user->name ?? '-' }}</td>
                <td>{{ $data->status }}</td>
                <td> {{ dateFormat(Carbon\Carbon::parse($data->transfer_date)->format('d-m-Y')) }}</td>
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