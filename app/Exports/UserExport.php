<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Permission;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserExport implements FromView
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
        $query        = User::query();

        $keyword    = $this->request->search;
        $start_date = $this->request->start_date;
        $end_date   = $this->request->end_date;

        return view('exports.user', [
            'users' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeUserFilter(query: $query)->get(),
            'permission_count'   =>  Permission::count(),
            'is_export' => true,
        ]);
    }
}
