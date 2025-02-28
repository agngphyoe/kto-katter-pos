<?php

namespace App\Exports;

use App\Models\Cashbook;
use Illuminate\Http\Request;
use App\Models\ProductReturn;
use App\Actions\HandleFilterQuery;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Traits\GetUserLocationTrait;
use Maatwebsite\Excel\Concerns\FromView;

class ExportExpense implements FromView
{
     use GetUserLocationTrait;
    /**
     * @return \Illuminate\Support\Collection
     */

     protected Request $request;
     public function __construct($request)
     {
         $this->request = $request;
     }
 
     public function view(): View
     {
         $query = Cashbook::expense();
       
         $keyword    = $this->request->search;
         $start_date = $this->request->start_date;
         $end_date   = $this->request->end_date;
         
         return view('exports.expense-export', [
             'expenses' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeCOAFilter(query: $query)->get(),
             'is_export' => true,
         ]);
     }
}
