<?php

namespace App\Exports\Report;

use App\Actions\ReportHandler;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Traits\GetUserLocationTrait;

class ProductReportExport implements FromView, WithColumnWidths, ShouldAutoSize
{
    protected Request $request;
    use GetUserLocationTrait;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $productables = (new ReportHandler(request: $this->request))->executeProduct();

        $validateLocation = $this->validateLocation();

        return view('exports.report.product', [
            'productables' => $productables,
            'validateLocation' => $validateLocation
        ]);
    }

    // Define the column widths
    public function columnWidths(): array
    {
        return [
            'A' => 20, // Name column
            'B' => 15, // Code column
            'C' => 25, // IMEI column
            'D' => 20, // Brand column
            'E' => 20, // Category column
            'F' => 15, // Price column
            'G' => 15, // Wholesale Price column
            'H' => 10, // Quantity column
            'I' => 20, // Date column
        ];
    }
}
