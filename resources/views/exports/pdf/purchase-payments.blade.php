@php
use App\Constants\ExchangeCashType;
use App\Models\Paymentable;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payables</title>
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
        <h1>Payables</h1>
        <p>Date: {{ $date }}</p>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Supplier Name</th>
                <th>Purchase Invoice</th>
                <th>Total Amount</th>
                <th>Discount/Cashdown</th>
                <th>Balance Amount</th>
                <th>Total Paid Amount</th>
                <th>Remaining Amount</th>
                <th>Progress</th>
                <th>Payment Date</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchasePayments as $data)
            @php
                $payment = Paymentable::find($data->id);
            @endphp
            <tr>
                <td>{{ $payment->paymentableBy?->name }}( {{ $payment->paymentableBy?->user_number}} ))</td>
                <td>{{ $payment->paymentable?->invoice_number}}</td>
                <td>{{number_format($payment->paymentable?->total_amount)}}</td>
                <td>{{number_format($payment->paymentable?->discount_amount)}} / {{number_format($payment->paymentable?->cash_down)}}</td>
                <td>{{ number_format($payment->paymentable?->purchase_amount) }}</td>
                <td>{{number_format($data->paymentable->total_paid_amount) ?? '-'}}</td>
                <td>
                    @php
                        $purchase = $payment->paymentable;
                        $remaining_amount = $purchase->remaining_amount - $purchase->total_return_buying_amount;
                        if ($purchase->paymentables->isNotEmpty()) {
                            $payment = $purchase->paymentables->sortByDesc('created_at')->first();
                            $remaining_amount = $payment->remaining_amount;
                        }
                        if($purchase->total_amount == $purchase->total_return_buying_amount){
                                $remaining_amount = -($purchase->total_paid_amount + $purchase->cash_down); 
                        }
                    @endphp
                    {{number_format($remaining_amount)}}
                </td>
                <td>
                    @php
                        $progress = round((($payment->total_paid_amount + $purchase->total_purchase_return_amount) / $purchase->purchase_amount) * 100);
                    @endphp
                    {{ $progress }}%
                </td>
                <td>
                    {{ dateFormat($payment->payment_date)}}
                </td>
                <td>
                    {{ $payment->user?->name ?? '-' }}
                </td>
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