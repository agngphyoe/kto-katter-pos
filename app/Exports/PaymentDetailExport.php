<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentDetailExport implements FromCollection, WithHeadings, WithMapping
{
    protected $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function collection()
    {
        return $this->supplier->purchases;
    }

    public function headings(): array
    {
        return ['Paid Amount', 'Paid Date', 'Payment Type', 'Status', 'Created By'];
    }

    public function map($purchase): array
    {
        $payment_date = $purchase->paymentables->max('payment_date') ?? '-';

        $bank_names = $purchase->paymentables->map(function ($payment) {
            return optional(\App\Models\Bank::find($payment->payment_type))->bank_name ?? '-';
        })->toArray();

        return [
            number_format($purchase->total_paid_amount),
            $payment_date ? dateFormat($payment_date) : '-',
            implode(', ', $bank_names),
            $purchase->purchase_status,
            $purchase->user?->name ?? '-',
        ];
    }
}
