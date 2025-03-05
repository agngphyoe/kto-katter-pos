<!DOCTYPE html>
<html>

<head>
    <title>Profit and Loss Statement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total {
            background-color: #3b82f6;
            font-weight: bold;
        }

        .grand-total {
            background-color: #00812C;
            color: white;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>STATEMENT OF PROFIT OR LOSS AND COMPREHENSIVE INCOME</h1>
    <p style="text-align: center;">Date Range: {{ $start_date }} to {{ $end_date }}</p>

    <!-- Revenue -->
    <table>
        <tr>
            <th>1. Revenue</th>
            <th></th>
        </tr>
        <tr>
            <td>Sales Income</td>
            <td class="text-right">{{ number_format($sale) }}</td>
        </tr>
        <tr>
            <td>Less: Sale Return</td>
            <td class="text-right">{{ number_format($sale_return) }}</td>
        </tr>
        <tr class="total">
            <td>Total Sales</td>
            <td class="text-right">{{ number_format($total_sales) }}</td>
        </tr>
    </table>

    <!-- Cost of Sales -->
    <table>
        <tr>
            <th>2. Less: Cost of Sales</th>
            <th></th>
        </tr>
        <tr>
            <td>Opening Stock</td>
            <td class="text-right">{{ number_format($start_price) }}</td>
        </tr>
        <tr>
            <td>Purchase</td>
            <td class="text-right">{{ number_format($purchase_amount) }}</td>
        </tr>
        <tr>
            <td>Less: Purchase Return</td>
            <td class="text-right">{{ number_format($purchase_return_amount) }}</td>
        </tr>
        <tr>
            <td>Less: Closing Stock</td>
            <td class="text-right">{{ number_format($end_price) }}</td>
        </tr>
        <tr class="total">
            <td>Total Cost of Sales</td>
            <td class="text-right">{{ number_format($total_cost_of_sales) }}</td>
        </tr>
        <tr class="grand-total">
            <td>Gross Profit on Sales</td>
            <td class="text-right">{{ number_format($gross_profit_on_sales) }}</td>
        </tr>
    </table>

    <!-- Other Incomes -->
    <table>
        <tr>
            <th>3. Add: Other Incomes</th>
            <th></th>
        </tr>
        @foreach (json_decode($incomes, true) as $income)
            <tr>
                <td>{{ $income['name'] }}</td>
                <td class="text-right">{{ number_format($income['amount']) }}</td>
            </tr>
        @endforeach
        <tr class="total">
            <td>Total Other Income</td>
            <td class="text-right">{{ number_format($total_other_income) }}</td>
        </tr>
        <tr class="grand-total">
            <td>Total Gross Profit</td>
            <td class="text-right">{{ number_format($total_gross_profit) }}</td>
        </tr>
    </table>

    <!-- Expenses -->
    <table>
        <tr>
            <th>4. Less: Expenses</th>
            <th></th>
        </tr>
        @foreach (json_decode($expenses, true) as $expense)
            <tr>
                <td>{{ $expense['name'] }}</td>
                <td class="text-right">{{ number_format($expense['amount']) }}</td>
            </tr>
        @endforeach
        <tr class="total">
            <td>Total Expenses</td>
            <td class="text-right">{{ number_format($total_expenses) }}</td>
        </tr>
        <tr class="grand-total">
            <td>Net Profit Before Tax</td>
            <td class="text-right">{{ number_format($net_profit_before_tax) }}</td>
        </tr>
    </table>
</body>

</html>
