<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchases</title>
    <style>
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

        /* Print-specific styles */
        @media print {
            body {
                width: 210mm;
                margin: 0 auto;
                font-size: 7px; /* Reduce font size for printing */
            }
            .table th, .table td {
                padding: 4px; /* Reduce padding to save space */
            }
            .table {
                page-break-inside: avoid;
            }
            .header, .footer {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Purchases</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Purchase ID</th>
                <th>Supplier Name</th>
                {{-- <th>Total Buying Amount</th> --}}
                <th>Discount/Cashdown Amount</th>
                <th>Balance Amount</th>
                <th>Type</th>
                <th>Purchase Date</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $data)
            <tr>
                <td>{{ $data->invoice_number }}</td>
                <td>{{ $data->supplier?->name ?? '-' }}</td>
                {{-- <td>{{ number_format($data->total_amount) }}</td> --}}
                <td>{{ number_format($data->discount_amount) }} / {{ number_format($data->cash_down) }}</td>
                <td>{{ number_format($data->total_amount - $data->discount_amount) }}</td>
                <td>{{ $data->action_type }}</td>
                <td>{{dateFormat($data->action_date)}}</td>
                <td>{{ $data->user?->name ?? '-'}}</td>
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
</html>
