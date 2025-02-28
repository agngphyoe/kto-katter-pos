<?php

namespace App\Exports;

use App\Actions\HandleFilterQuery;
use App\Models\Damage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Auth;

class DamageExport implements FromView
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
        $user = Auth::user();
        if($user->hasRole('Super Admin')){
            $query = Damage::query();
        }else{
            $query = Damage::where('created_by', auth()->user()->id);
        }

        $data = json_decode($this->request->data, true);
        $keyword = $data['search'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        return view('exports.damage', [
            'damages' => (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeDamageFilter(query: $query)->get(),
            'is_export' => true,
        ]);
    }
}
