<?php

namespace App\Http\Controllers;

use App\Models\ProductRequest;
use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Product;
use App\Models\Location;
use App\Models\LocationStock;
use App\Models\ProductPrefix;
use App\Constants\PrefixCodeID;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class ProductRequestController extends Controller
{
    use GetUserLocationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $keyword     = $request->input('search');
            $start_date  = $request->input('start_date');
            $end_date    = $request->input('end_date');
            $query        = ProductRequest::query();

            $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))->executeProductOrderRequestFilter(query: $query);

            $product_requests = $query->whereIn('from_location_id', $this->validateLocation())
                                    ->selectRaw('
                                        request_inv_code,
                                        CASE 
                                            WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                                            ELSE MAX(status)
                                        END as status,
                                        from_location_id,
                                        to_location_id,
                                        remark,
                                        created_by,
                                        created_at,
                                        MAX(id) as id
                                    ')
                                    ->groupBy('request_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                                    ->orderBy('id', 'desc')
                                    ->paginate(10);

            $html = View::make('product-request.search', compact('product_requests'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $product_requests))->pagination()
            ]);
        }

        $product_requests = ProductRequest::whereIn('from_location_id', $this->validateLocation())
                                            ->selectRaw('
                                                request_inv_code,
                                                CASE 
                                                    WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                                                    ELSE MAX(status)
                                                END as status,
                                                from_location_id,
                                                to_location_id,
                                                created_by,
                                                created_at,
                                                remark,
                                                MAX(id) as id
                                            ')
                                            ->groupBy('request_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);

        $total_count    = ProductRequest::count();

        return view('product-request.index', compact('product_requests', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $exist_record = ProductRequest::latest()->first();

        // $product_prefix = ProductPrefix::first();

        // $product_prefix_code = $product_prefix?->prefix ?? PrefixCodeID::PO_REQUEST;

        // $product_prefix_length = $product_prefix?->prefix_length ?? PrefixCodeID::PREFIX_DEFAULT_LENGTH;

        // $product_code = getAutoGenerateID($product_prefix_code, $exist_record?->code, $product_prefix_length);
        $product_code = 'POR-'. date('YmdHis');

        $from_locations = $this->POLocations();
        $to_locations = $this->getAllStoreLocations();

        $products = Product::all();
        
        return view('product-request.create', compact('products', 'from_locations', 'to_locations', 'product_code'));
    }

    public function createSecond(Request $request)
    {
        $data = [];
        $data['request_code'] = $request->request_code;
        $data['from_location_id'] = $request->from_location_id;
        $data['to_location_id'] = $request->to_location_id;
        $data['remark'] = $request->remark;

        $data['from_location_name'] = Location::where('id', $request->from_location_id)
                                                ->value('location_name');

        $data['to_location_name'] = Location::where('id', $request->to_location_id)
                                                ->value('location_name');

        $products = LocationStock::where('location_id', $request->to_location_id)
                                    ->where('quantity', '!=', 0)
                                    ->get();

        $product_prefix = PrefixCodeID::PO_REQUEST;

        $prefix_code = $product_prefix . '-' . $request->request_code;

        $data['prefix_code'] = $prefix_code;

        return view('product-request.create-second', compact('data', 'products'));
    }

    public function createThird(Request $request)
    {
        $data = json_decode($request->data, true);
        
        $products = $request->selected_products;
        $data['prefix_code'] = $request->prefix_code;
        $data['from_location_id'] = $data['from_location_id'];
        $data['to_location_id'] = $data['to_location_id'];

        $from_location_name = Location::where('id', $data['from_location_id'])->first();
        $to_location_name = Location::where('id', $data['to_location_id'])->first();
        $data['from_location_name'] = $from_location_name->location_name;
        $data['to_location_name'] = $to_location_name->location_name;

        $data['products'] = $products;
        if (!$products) {
            return redirect()->route('product-request-create-second')->with('message', 'Fail. Empty Cart!');
        }
    

        return view('product-request.create-final', compact('data', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $login_user = Auth()->user();
        $status = 'pending';
        $data = json_decode($request->data, true);
        
        try {
            DB::beginTransaction();

            $products = json_decode($data['products'], true);

            foreach ($products as $product) {

                $productReq = new ProductRequest();
                $productReq->request_inv_code = 'POR-'.$data['request_code'];
                $productReq->from_location_id = $data['from_location_id'];
                $productReq->to_location_id = $data['to_location_id'];
                $productReq->remark = $data['remark'];
                $productReq->product_id = $product['product_id'];
                $productReq->request_qty = $product['quantity'];
                $productReq->quantity = 0;
                $productReq->status = $status;
                $productReq->created_by = $login_user->id;
                $productReq->save();

            }

            DB::commit();

            return redirect()->route('product-request')->with('success', 'Success! Product Request Created');
        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            return back()->with('failed', 'Failed! Product Request cannot Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRequest $productRequest, $product)
    {
        $productReq = ProductRequest::where('request_inv_code', $product)->first();
        $products = ProductRequest::where('request_inv_code', $product)->get();
        return view('product-request.detail', compact('productReq', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRequest $productRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRequest $productRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRequest $productRequest)
    {
        //
    }

    public function getSearchProduct(Request $request)
    {
        $keyword = $request->input('search');
        $keyword = "%{$keyword}%";
        $location_id = $request->location_id;

        $locationProducts = LocationStock::where('location_id', $location_id)
                                            ->where('quantity', '!=', 0)
                                            ->select('product_id')
                                            ->get();

                                            $products = Product::whereIn('id', $locationProducts)
                                            ->where(function ($query) use ($keyword) {
                                                $query->where('name', 'like', $keyword)
                                                    ->orWhere('code', 'like', $keyword)
                                                    ->orWhereHas('brand', function ($query) use ($keyword) {
                                                        $query->where('name', 'like', $keyword);
                                                    })
                                                    ->orWhereHas('design', function ($query) use ($keyword) {
                                                        $query->where('name', 'like', $keyword);
                                                    })
                                                    ->orWhereHas('category', function ($query) use ($keyword) {
                                                        $query->where('name', 'like', $keyword);
                                                    })
                                                    ->orWhereHas('productModel', function ($query) use ($keyword) {
                                                        $query->where('name', 'like', $keyword);
                                                    })
                                                    ->orWhereHas('type', function ($query) use ($keyword) {
                                                        $query->where('name', 'like', $keyword);
                                                    });
                                            })
                                            ->get();

        $html = View::make('product-request.selected-product', compact('products', 'location_id'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
