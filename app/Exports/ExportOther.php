<?php

namespace App\Exports;

use App\Models\Cashbook;
use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use Illuminate\Contracts\View\View;
use App\Traits\GetUserLocationTrait;
use Maatwebsite\Excel\Concerns\FromView;

class ExportOther implements FromView
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
         $query = Cashbook::others();
       
         $keyword    = $this->request->search;
         $start_date = $this->request->start_date;
         $end_date   = $this->request->end_date;
         
         return view('exports.other-export', [
             'others' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeCOAFilter(query: $query)->get(),
             'is_export' => true,
         ]);
     }
}
