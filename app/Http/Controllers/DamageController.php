<?php

namespace App\Http\Controllers;

use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Actions\UpdateProductQuantity;
use App\Http\Requests\Damage\StoreDamageRequest;
use App\Models\Damage;
use App\Models\DamageProduct;
use App\Models\Product;
use App\Models\Productable;
use App\Models\Location;
use App\Models\LocationStock;
use App\Models\DistributionTransaction;
use App\Traits\GetUserLocationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Auth;

class DamageController extends Controller
{
    use GetUserLocationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('Super Admin')){
            $query = Damage::query();
        }else{
            $query = Damage::where('created_by', auth()->user()->id);
        }

        if ($request->ajax()) {
            $keyword    = $request->search;

            $query = (new HandleFilterQuery(keyword: $keyword))->executeDamageFilter(query: $query);

            $damages = $query->paginate(10);

            $html = View::make('damage.search', compact('damages'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $damages))->pagination()
            ]);
        }

        $damages = $query->paginate(10);

        $total_count    = $query->get()->count();

        return view('damage.index', compact('damages', 'total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFirst(Request $request)
    {
        $location_id = $request->location_id;

        if($request->ajax()){
            $keyword                = $request->input('search');
            $location_id            = $request->input('location_id');
            $selected_products      = $request->input('selectedData');
            $selected_products      = $selected_products ?? [];

            $query = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                                ->where('ls.location_id', $request->location_id)
                                ->select('products.*', 'ls.quantity as quantity');
                                
            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);
            
            $products = $query->orderByDesc('id')->paginate(20);

            $html = View::make('product.search-product-list', compact('products', 'selected_products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }
        
        $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                            ->where('ls.location_id', $request->location_id)
                            ->select('products.*', 'ls.quantity as quantity')
                            ->get();

        return view('damage.create-first', compact('products', 'location_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSecond(Request $request)
    {
        $location_id = $request->location_id;
        $products = json_decode($request->selected_products, true);
        if(!$products){
            return back()->with('error', 'No Product is Selected !');
        }

        return view('damage.create-second', compact('location_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFinal(Request $request)
    {
        if(!$request->remark){
            return back()->with('error', 'Remark is Required !');
        }
        $location = Location::find($request->location_id);

        $damage_products = json_decode($request->damage_products, true);
        $total_quantity = 0;
        $total_amount = 0;

        foreach ($damage_products as $item) {
            if($item['stock_quantity'] < $item['new_quantity']){
                return back()->with('error', 'Quantity Limit Exceeded !');
            }
            $total_quantity += $item['new_quantity'];
        }

        $damage_details = [
            'remark' => $request->remark,
            'damage_date' => $request->damage_date,
            'created_by' => auth()->user()->name,
            'total_quantity' => $total_quantity,
            'total_amount' => $total_amount,
        ];

        return view('damage.create-final', compact('damage_products', 'damage_details', 'location', 'total_amount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $damage_info = json_decode($request->damage_info, true);
        $damage_products = json_decode($request->damage_products, true);
        $damaged_products = [];

        DB::beginTransaction();

        try {

            $damage = Damage::create([
                'location_id'       => $request->location_id,
                'total_quantity'    => $damage_info['total_quantity'],
                'total_amount'      => $damage_info['total_amount'],
                'remark'            => $damage_info['remark'],
                'damage_date'       => format_date($damage_info['damage_date']),
            ]);

            foreach ($damage_products as $product) {
                $product_id = $product['id'];
                $quantity   = $product['new_quantity'];

                $availableStocks = DistributionTransaction::where('product_id', $product_id)
                                                            ->where('location_id', $request->location_id)
                                                            ->where('quantity', '!=', 0)
                                                            ->get();

                $damage_quantity = $quantity;

                foreach ($availableStocks as $stock) {
                    if($damage_quantity > 0 && $stock->remaining_quantity > 0) {
                        if($stock->remaining_quantity >= $damage_quantity){
                            $stock->remaining_quantity -= $damage_quantity;
                            $stock->save();

                            $damage_quantity = 0;
                        }else{
                            $damage_quantity -= $stock->remaining_quantity;
                            $stock->remaining_quantity = 0;
                            $stock->save();
                            
                            continue;
                        }
                    }else{
                        continue;
                    }

                    if ($damage_quantity == 0) {
                        break;
                    }
                }

                $location_stock = LocationStock::where('location_id', $request->location_id)
                                                ->where('product_id', $product_id)
                                                ->first();

                $location_stock->quantity -= $quantity;
                $location_stock->save();

                DamageProduct::create([
                    'damage_id' => $damage->id,
                    'product_id' => $product_id,
                    'quantity' => $quantity

                ]);
            }
            
            DB::commit();

            return redirect()->route('damage')->with('success', 'Success! Damage created');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();

            return back()->with('error', 'Failed! Damage can not Created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function show(Damage $damage)
    {
        return view('damage.detail', compact('damage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function editFirst(Request $request)
    {
        $damage = Damage::find($request->id);

        if($request->ajax()){
            $keyword                = $request->input('search');
            $damage_id = $request->input('damage_id');
            $selected_products      = $request->input('selectedData');
            $selected_products      = $selected_products ?? [];

            $query = Product::join('damage_products as dp', 'dp.product_id', 'products.id')
                                ->where('dp.damage_id', $damage_id)
                                ->select('products.*', 'dp.quantity as quantity');
                                
                                
            $query = (new HandleFilterQuery(keyword: $keyword))->executeProductFilter(query: $query);
            
            $products = $query->orderByDesc('id')->paginate(20);

            $html = View::make('damage.search-damage-edit-product', compact('products', 'selected_products'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }
        
        $products = Product::join('damage_products as dp', 'dp.product_id', 'products.id')
                            ->where('dp.damage_id', $damage->id)
                            ->select('products.*', 'dp.quantity as quantity')
                            ->get();

        return view('damage.edit-first', compact('products', 'damage'));
    }

    public function editFinal(Request $request){
        $damage = Damage::find($request->damage_id);
        $damage_products = json_decode($request->selected_products, true);
        
        return view('damage.edit-final', compact('damage_products', 'damage'));
    }

    public function edit(Damage $damage)
    {
        foreach ($damage->damageProducts as $data) {
            $damage->stock_quantity = LocationStock::where('location_id', $damage->location_id)
                                                    ->where('product_id', $data->product_id)
                                                    ->value('quantity');
        }
       
        return view('damage.edit', compact('damage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Damage $damage)
    {
        DB::beginTransaction();

        try {
            $total_damage_product = array_sum($request->new_quantity);

            $i = 0;
            $count = count($request->product_id);
            while ($i < $count){
                $product_id = $request->product_id[$i];
                $new_quantity = $request->new_quantity[$i];

                $damage_product = DamageProduct::where('damage_id', $damage->id)
                                                ->where('product_id', $product_id)
                                                ->first();

                $diff_product = abs($damage_product->quantity - $new_quantity);

                $locationStock = LocationStock::where('location_id', $damage->location_id)
                                                ->where('product_id', $product_id)
                                                ->first();


                if($damage_product->quantity > $new_quantity){
                    $locationStock->quantity += $diff_product;
                    $locationStock->save();

                    $availableStocks = DistributionTransaction::where('product_id', $product_id)
                                                            ->where('location_id', $damage->location_id)
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();

                    foreach ($availableStocks as $stock) {
                    
                        if($stock->quantity > $stock->remaining_quantity){
                            $restock_qty = $stock->quantity - $stock->remaining_quantity;
                            if($restock_qty <= $diff_product ){
                                $diff_product -= $restock_qty;                           
                
                                $stock->remaining_quantity = $stock->quantity;
                                $stock->save();
                            }else{
                                $stock->remaining_quantity += $diff_product;
                                $stock->save();

                                $diff_product = 0;
                            }
                        }else{
                            continue;
                        }
    
                        if ($diff_product == 0) {
                            break;
                        }
                    }
                }else{
                    $locationStock->quantity -= $diff_product;
                    $locationStock->save();

                    $availableStocks = DistributionTransaction::where('product_id', $product_id)
                                                            ->where('location_id', $damage->location_id)
                                                            ->where('quantity', '!=', 0)
                                                            ->get();

                    foreach ($availableStocks as $stock) {
                        if($diff_product > 0 && $stock->remaining_quantity > 0) {
                            if($stock->remaining_quantity >= $diff_product){
                                $stock->remaining_quantity -= $diff_product;
                                $stock->save();

                                $diff_product = 0;
                            }else{
                                $diff_product -= $stock->remaining_quantity;
                                $stock->remaining_quantity = 0;
                                $stock->save();
                                
                                continue;
                            }
                        }else{
                            continue;
                        }

                        if ($diff_product == 0) {
                            break;
                        }
                    }
                }

                $damage->total_quantity = $total_damage_product;
                $damage->save();

                $damage_product->quantity = $new_quantity;
                $damage_product->save();
                
                $i++; 
            } 

            DB::commit();

            return redirect()->route('damage')->with('success', 'Success! Damage updated');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            return back()->with('error', 'Failed! Damage can not Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Damage $damage)
    {
        DB::beginTransaction();

        try {

            foreach ($damage->damageProducts as $damageProduct) {
                LocationStock::updateOrCreate(
                    [
                        'product_id' => $damageProduct->product_id,
                        'location_id' => $damage->location_id,
                    ],
                    [
                        'quantity' => DB::raw('quantity + ' . $damageProduct->quantity),
                    ]
                );

                $add_quantity = $damageProduct->quantity;

                $availableStocks = DistributionTransaction::where('product_id', $damageProduct->product_id)
                                                            ->where('location_id', $damage->location_id)
                                                            ->orderBy('created_at', 'desc')
                                                            ->get();

                    foreach ($availableStocks as $stock) {
                    
                        if($stock->quantity > $stock->remaining_quantity){
                            $restock_qty = $stock->quantity - $stock->remaining_quantity;
                            if($restock_qty <= $add_quantity ){
                                $add_quantity -= $restock_qty;                           
                
                                $stock->remaining_quantity = $stock->quantity;
                                $stock->save();
                            }else{
                                $stock->remaining_quantity += $diff_product;
                                $stock->save();

                                $add_quantity = 0;
                            }
                        }else{
                            continue;
                        }
    
                        if ($add_quantity == 0) {
                            break;
                        }
                    }

            }

            $damage->delete();

            DB::commit();

            return response()->json([
                'message' => 'The record has been deleted successfully.',
                'status' => 200,
            ], 200);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'message' => 'Something went wrong.',
                'status' => 500,
            ], 500);
        }
    }

    public function chooseStoreLocation(){
        $locationIds = $this->validateLocation();
        
        $locations = Location::whereIn('id', $locationIds)
                                ->get();
    
        return view('damage.choose-location', compact('locations'));
    }
}
