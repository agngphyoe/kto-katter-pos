<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Role;
use App\Models\Permission;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RoleExport implements FromView
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
        $query        = Role::query();

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.role', [
            'roles' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeKeyDataForProductFilter(query: $query)->get(),
            'permission_count'   => Permission::count(),
            'is_export' => true,
        ]);
    }
}
