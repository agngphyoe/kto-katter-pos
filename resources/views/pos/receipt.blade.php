<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        @page {
            size: 72.1mm 210mm; /* Set page width to 72.1mm and max height to 210mm */
            margin: 0; /* Remove all margins */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 72.1mm; /* Set the body width to 72.1mm */
        }

        .header {
            text-align: center;
            font-size: 16px; /* Header font size */
            font-weight: bold;
            padding: 10px 0;
        }

        .address {
            text-align: center;
            font-size: 12px; /* Address font size */
            margin-bottom: 10px;
        }

        .content {
            padding: 0 5mm; /* Slight padding on the sides */
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Remove spacing between table cells */
            font-size: 10px; /* Table font size */
        }

        th, td {
            text-align: left;
            padding: 4px 0; /* Reduce padding for a more compact layout */
        }

        th {
            border-bottom: 1px solid #000;
            font-size: 11px; /* Font size for table headers */
        }

        .total-row td {
            font-weight: bold;
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 12px; /* Footer font size */
            padding-top: 10px;
        }

        .details {
            font-family: monospace; /* Use monospace font for alignment */
            font-size: 10px; /* Font size for details */
            line-height: 1.2; /* Space between lines */
        }

        .row {
            display: flex;
            justify-content: space-between; /* Align items on opposite sides */
            margin: 3px 0; /* Space between rows */
        }

        .label {
            font-weight: bold; /* Bold for labels */
            width: 40%; /* Fixed width for labels */
        }

        .value {
            width: 30%; /* Fixed width for values */
            text-align: right; /* Align values to the right */
            font-weight: bold;
        }

        .right {
            margin-left: auto; /* Pushes the label to the right */
        }

        .underline {
            border-top: 1px solid #000;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .center-image {
            text-align: center;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="center-image">
        <img src="{{ public_path('images/mi.png') }}" alt="Logo">
    </div>
    <div class="header">
        <h2>{{ $order->location->location_name }}</h2>
    </div>

    <div class="address">
        <p>{{ $order->location->address }}</p>
    </div>

    <div class="content">
        <div class="details">
            <div class="row">
                <span class="label">Date:</span>
                <span class="value">{{ $order->created_at->format('Y-m-d') }}&nbsp;</span>
                <span class="label right">Payment:</span>
                <span class="value">{{ $order->paymentType->bank_name }}</span>
            </div>

            <div class="row">
                <span class="label">Receipt No:</span>
                <span class="value">{{ $order->id }}&nbsp;&nbsp;&nbsp;</span>
                <span class="label right">Customer:</span>
                <span class="value">{{ $order->shopper->name }}</span>
            </div>

            <div class="row">
                <span class="label">Cashier:</span>
                <span class="value">{{ $created_by }}</span>
            </div>
        </div><br>

        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Item</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 30%;">Price</th>
                    <th style="width: 30%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderProducts as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                    </tr>
                    @if ($item->imei)
                        <tr>
                            <td colspan="2">IMEI: {{ implode(', ', json_decode($item->imei)) }}</td>
                        </tr>
                    @endif
                @endforeach
            
                <tr class="underline"><td colspan="4"></td></tr>
                <!-- Add the summary rows inside the table -->
                <tr class="total-row">
                    <td>Subtotal:</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($order->total_amount, 2) }}</td>
                </tr>
                <tr class="total-row" >
                    <td>Discount:</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total:</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($order->net_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Paid:</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($order->paid_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Change:</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($order->change_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        
    </div>

    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>
</body>
</html>
