<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Adjustments</title>
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
        <h1>Stock Adjustments</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Remark</th>
                <th>Location</th>
                <th>Product</th>
                <th>Status</th>
                <th>Quantity</th>
                <th>Action By</th>
                <th>Adjustment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockAdjustments as $stockAdjustment)
                @php
                    $datas = \App\Models\StockAdjustmentProduct::where('stock_adjustment_id', $stockAdjustment->id)->get();
                @endphp
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $stockAdjustment->remark ?? '-' }}</td>
                    <td>{{ $stockAdjustment->location->location_name ?? '-' }}</td>
                    <td>{{ $data->product?->name ?? '-' }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ $data->quantity ?? '-' }}</td>
                    <td>{{ $stockAdjustment->user->name ?? '-' }}</td>
                    <td>{{ dateFormat($stockAdjustment->adjustment_date) ?? '-' }}</td>
                </tr>
                @endforeach
            
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="header">
            <h1>Mobile Shop POS</h1>
        </div>
    </div>
</body>