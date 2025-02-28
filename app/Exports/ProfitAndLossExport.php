<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfitAndLossExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $incomes = json_decode($this->data['incomes'], true) ?? [];
        $expenses = json_decode($this->data['expenses'], true) ?? [];

        return [
            ['Profit and Loss Statement', ''],
            ['Date Range', $this->data['start_date'] . ' to ' . $this->data['end_date']],
            ['', ''],
            ['1. Revenue', ''],
            ['Sales Income', number_format($this->data['sale'])],
            ['Less: Sale Return', number_format($this->data['sale_return'])],
            ['Total Sales', number_format($this->data['total_sales'])],
            ['', ''],
            ['2. Less: Cost of Sales', ''],
            ['Opening Stock', number_format($this->data['start_price'])],
            ['Purchase', number_format($this->data['purchase_amount'])],
            ['Less: Purchase Return', number_format($this->data['purchase_return_amount'])],
            ['Less: Closing Stock', number_format($this->data['end_price'])],
            ['Total Cost of Sales', number_format($this->data['total_cost_of_sales'])],
            ['Gross Profit on Sales', number_format($this->data['gross_profit_on_sales'])],
            ['', ''],
            ['3. Add: Other Incomes', ''],
            ...array_map(fn($income) => [$income['name'], number_format($income['amount'])], $incomes),
            ['Total Other Income', number_format($this->data['total_other_income'])],
            ['Total Gross Profit', number_format($this->data['total_gross_profit'])],
            ['', ''],
            ['4. Less: Expenses', ''],
            ...array_map(fn($expense) => [$expense['name'], number_format($expense['amount'])], $expenses),
            ['Total Expenses', number_format($this->data['total_expenses'])],
            ['Net Profit Before Tax', number_format($this->data['net_profit_before_tax'])],
        ];
    }

    public function headings(): array
    {
        return ['Description', 'Amount'];
    }
}
