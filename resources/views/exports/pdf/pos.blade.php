<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sales</title>
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
        <h1>Point of Sales</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Order Id</th>
                <th>Total Amount</th>
                <th>Discount Amount</th>
                <th>Net Amount</th>
                <th>Selled Date</th>
                <th>Payment Type</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $data)
            <tr>
                <td>{{ $data->order_number ?? '' }}</td>
                <td>{{ $data->total_amount ?? '-' }}</td>
                <td>{{ $data->discount_amount ?? '-' }}</td>
                <td>{{ $data->net_amount ?? '-' }}</td>
                <td>{{dateFormat($data->created_at)}}</td>
                <td>{{$data->paymentType->bank_name}}</td>
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