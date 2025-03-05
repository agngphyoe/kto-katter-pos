<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use Illuminate\Support\Facades\View;
use App\Traits\GetUserLocationTrait;
use Auth;
use App\Models\SaleConsultant;
use App\Models\Location;
use App\Models\PointOfSale;

class SaleConsultantController extends Controller
{
    use GetUserLocationTrait;

    public function index(Request $request){
        if ($request->ajax()) {

            $query = SaleConsultant::whereIn('location_id', $this->validateLocation());

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeSaleConsultantFilter(query: $query);

            $sale_consultants = $query->paginate(10);

            $html = View::make('sc.search', compact('sale_consultants'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $sale_consultants))->pagination()
            ]);
        }

        $sale_consultants = SaleConsultant::whereIn('location_id', $this->validateLocation())
                                            ->paginate(10);

        $sc_count = SaleConsultant::whereIn('location_id', $this->validateLocation())
                                            ->count();                        

        return view('sc.index', compact('sale_consultants', 'sc_count'));
    }

    public function create()
    {
        $locations = $this->getDissminationLocations();

        return view('sc.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $userExist = SaleConsultant::where('name', $request->name)
                                    ->where('location_id', $request->location_id)
                                    ->first();

        if($userExist){
            return back()->with('error', 'Failed! Something went Wrong');
        }

        SaleConsultant::create($request->all());

        return redirect()->route('sc-list')->with('success', 'Success! A Sale Staff is Created');
            
    }

    public function edit($id)
    {
        $data = SaleConsultant::find($id);
        $locations = $this->getDissminationLocations();

        return view('sc.edit', compact('data', 'locations'));
    }

    public function update($id, Request $request)
    {
        $saleConsultant = SaleConsultant::find($id);
        $saleConsultant->location_id = $request->location_id;
        $saleConsultant->name = $request->name;
        $saleConsultant->save();

        return redirect()->route('sc-list')->with('success', 'Success! A Sale Staff is Updated');
    }

    public function destroy($id)
    {
        $saleConsultant = SaleConsultant::find($id);
        try {
            $saleConsultant->delete();
    
            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'error',
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function details($id){
        $saleConsultant = SaleConsultant::find($id);

        return view('sc.details', compact('saleConsultant'));
    }
}
