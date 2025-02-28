<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\CompanySetting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CompanySettingsExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected Request $request;

    public function __construct($request)
    {
        $this->request         = $request;
    }

    public function view(): View
    {

        $query        = CompanySetting::select('name', 'url', 'created_by', 'created_at');

        $keyword    = $this->request->search;
        $start_date = $this->request->start_date;
        $end_date   = $this->request->end_date;

        return view('exports.company-settings', [
            'company_settings' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $query)->get(),
            'is_export' => true

        ]);
    }
}
