<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\ImageStoreInPublic;
use App\Constants\FileStorePath;
use App\Constants\PrefixCodeID;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Paymentable;
use App\Exports\PaymentDetailExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class SupplierController extends Controller
{
    protected string $file_store_path = FileStorePath::SUPPLIER_IMAGE_PATH;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query        = Supplier::query();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $suppliers          = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeSupplierFilter(query: $query)->paginate(10);

            $html           = View::make('supplier.search', compact('suppliers'))->render();

            return response()->json([
                'success'   => true,
                'html'      => $html,
                'pagination' => (new HandlePagination(data: $suppliers))->pagination()
            ]);
        }

        $suppliers          = Supplier::orderByDesc('id')->paginate(10);

        $total_count    = $suppliers->count();

        $popular_suppliers = Supplier::latest()->take(3)->get();

        $new_suppliers = Supplier::latest()->take(3)->get();

        return view('supplier.index', compact('suppliers', 'popular_suppliers', 'new_suppliers', 'total_count'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            $supplierQuery        = Supplier::query();
            $total_count = $supplierQuery->count();

            $keyword    = $request->search;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;

            $query          = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeSupplierFilter(query: $supplierQuery);

            $suppliers = $query->paginate(10);
            $search_count = $query->count();

            $html           = View::make('supplier.search', compact('suppliers'))->render();

            return response()->json([
                'success'   => true,
                'html'      => $html,
                'total_count' => $total_count,
                'search_count' => $search_count,
                'pagination' => (new HandlePagination(data: $suppliers))->pagination()
            ]);
        }

        $suppliers = Supplier::orderByDesc('id')->paginate(10);

        $total_count = $suppliers->count();

        return view('supplier.list', compact('suppliers', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exist_record = Supplier::latest()->first();

        $supplier_id = getAutoGenerateID(PrefixCodeID::SUPPLIER, $exist_record?->user_number);

        $countries  = Country::all();

        $cities     = City::all();

        return view('supplier.create', compact('supplier_id', 'countries', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $image = $request->image ? (new ImageStoreInPublic())->storePublic(destination: $this->file_store_path, image: $request->image) : null;

        $request = $request->all();
        $request['image'] = $image;

        $supplier = Supplier::create($request);

        if ($supplier) {

            session()->flash('success', 'Success! Supplier created');

            return redirect()->route('supplier-list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function detail(Supplier $supplier)
    {
        $supplier->total_purchase_amount = Purchase::where('supplier_id', $supplier->id)
                                                ->sum('purchase_amount');

        $creditPurchases = Purchase::where('supplier_id', $supplier->id)
                                ->where('action_type', 'Credit')
                                ->pluck('id');

        $total_remaining_amount = Paymentable::where('paymentable_type', 'App\Models\Purchase')
                                            ->whereIn('paymentable_id', $creditPurchases)
                                            ->orderBy('id', 'desc')
                                            ->get()
                                            ->groupBy('paymentable_id')
                                            ->sum(fn($payments) => $payments->first()->remaining_amount);

        $supplier->total_remaining_amount = $total_remaining_amount;

        return view('supplier.detail', compact('supplier'));
    }

    public function paymentDetail(Supplier $supplier)
    {
        $payments = Paymentable::where('paymentable_type', 'App\Models\Purchase')
            ->whereIn('paymentable_id', Purchase::where('supplier_id', $supplier->id)->pluck('id'))
            ->orderBy('id', 'desc')
            ->get();

        return view('supplier.payment-detail', compact('supplier', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $countries  = Country::all();

        $cities     = City::all();

        return view('supplier.edit', compact('supplier', 'countries', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {

        $image  = $supplier->image;

        if ($request->hasFile('image')) {

            File::delete(public_path($this->file_store_path . '/' . $supplier->image));

            $image = (new ImageStoreInPublic())->storePublic(destination: $this->file_store_path, image: $request->image);
        }

        $request = $request->all();
        $request['image'] = $image;

        $supplier->update($request);

        if ($supplier) {

            session()->flash('success', 'Success! Supplier Updated');

            return redirect()->route('supplier-list');
        }

        session()->flash('error', 'Failed! Supplier not updated');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        if (!($supplier->purchases?->first())) {
            $image  = $supplier->image;

            if ($image) {

                File::delete(public_path($this->file_store_path . '/' . $image));
            }

            $supplier->delete();

            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Something went wrong.',
                'status' => 500,
            ], 500);
        }
    }

    public function getCityData(Request $request)
    {
        $country_id = $request->input('country_id');
        $country = Country::find($country_id);
        $cities = $country->cities;

        $html = View::make('supplier.city-data', compact('cities'))->render();
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function paymentHistorySearch(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $supplier_id = $request->supplier_id;

        $query = Paymentable::where('paymentable_type', 'App\Models\Purchase')
                                    ->whereIn('paymentable_id', Purchase::where('supplier_id', $supplier_id)->pluck('id'))
                                    ->orderBy('id', 'desc');
         
        $total_count = $query->count();

        $payments = (new HandleFilterQuery(start_date: $start_date, end_date: $end_date))->executeSupplierFilter(query: $query)->paginate(10);
    }

    public function exportPaymentDetail(Supplier $supplier)
    {
        return Excel::download(new PaymentDetailExport($supplier), 'payment-detail.xlsx');
    }
}
