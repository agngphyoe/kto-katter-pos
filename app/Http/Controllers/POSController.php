<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\HandleFilterQuery;
use App\Actions\HandlePagination;
use App\Models\Supplier;
use App\Models\PointOfSale;
use App\Models\PointOfSaleProduct;
use App\Models\Product;
use App\Models\IMEIProduct;
use App\Models\LocationStock;
use App\Models\Shopper;
use App\Models\Address;
use App\Models\Bank;
use App\Models\User;
use App\Models\PosReturn;
use App\Models\SaleConsultant;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Models\SupplierCashback;
use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Carbon;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;

class POSController extends Controller
{

    use GetUserLocationTrait;

    public function index(Request $request){

        $user = Auth::user();

        if ($request->ajax()) {
            $keyword     = $request->input('search');

            if($user->hasRole('Super Admin')){
                $query       = PointOfSale::query();
            }else{
                $query       = PointOfSale::where('createable_id', auth()->user()->id);
            }
            
            $query = (new HandleFilterQuery(keyword: $keyword))->executePOSFilter(query: $query);

            $sales = $query->paginate(10);

            $html = View::make('pos.search-order', compact('sales'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => (new HandlePagination(data: $sales))->pagination()
            ]);
        }

        if($user->hasRole('Super Admin')){
            $sales = PointOfSale::orderByDesc('id')
                                ->paginate(10);

            $today_sales = PointOfSale::where('order_date', date('Y-m-d'))
                                        ->orderByDesc('id')
                                        ->paginate(10);
        }else{
            $sales = PointOfSale::where('location_id', $this->validateLocation())
                        ->orderByDesc('id')
                        ->paginate(10);

            $today_sales = PointOfSale::where('location_id', $this->validateLocation())
                        ->where('order_date', date('Y-m-d'))
                        ->orderByDesc('id')
                        ->paginate(10);
        }
        
        $today_sale_count = PointOfSale::where('order_date', date('Y-m-d'))->count();
        $total_sale_count    = PointOfSale::count();

        if($total_sale_count == 0){
            $sale_data = [
                'total_sale_count' => 0,
                'total_sale_amount' => 0,
                'total_sale_quantity' => 0,
                'today_sale_count' => 0,
                'today_sale_amount' => 0,
                'today_sale_quantity' => 0,
                'today_sale_percentage' => 0,
                'today_sale_amount_percentage' => 0,
                'today_sale_quantity_percentage' => 0
            ];
        }else{
            $today_sale_percentage = intval(($today_sale_count/$total_sale_count) * 100);

            $total_sale_amount = PointOfSale::sum('net_amount');
            $today_sale_amount = PointOfSale::where('order_date', date('Y-m-d'))
                                            ->sum('net_amount');

            $today_sale_amount_percentage = intval(($today_sale_amount/$total_sale_amount) * 100);

            $total_sale_quantity_count = PointOfSaleProduct::sum('quantity');
            $today_sale_quantity_count = PointOfSaleProduct::join('point_of_sales as pos', 'pos.id', '=', 'point_of_sale_products.point_of_sale_id')
                                                            ->whereDate('pos.order_date', '=', date('Y-m-d'))
                                                            ->sum('point_of_sale_products.quantity');

            $today_sale_quantity_percentage = intval(($today_sale_quantity_count/$total_sale_quantity_count) * 100);

            $sale_data = [
                'total_sale_count' => $total_sale_count,
                'total_sale_amount' => $total_sale_amount,
                'total_sale_quantity' => $total_sale_quantity_count,
                'today_sale_count' => $today_sale_count,
                'today_sale_amount' => $today_sale_amount,
                'today_sale_quantity' => $today_sale_quantity_count,
                'today_sale_percentage' => $today_sale_percentage,
                'today_sale_amount_percentage' => $today_sale_amount_percentage,
                'today_sale_quantity_percentage' => $today_sale_quantity_percentage
            ];
        }
        
        return view('pos.index', compact('today_sale_count', 'sales', 'sale_data', 'today_sales'));
    }

    public function create(){

        $retailLocations = $this->getBranchLocations();
        if (count($retailLocations) === 1) {
            $retailLocation_id = $retailLocations[0]->id;
        }else{
            return redirect()->back()->with('error', 'User Has More Than One Locations');
        }
        $products = Product::join('location_stocks as ls', 'ls.product_id', 'products.id')
                            ->where('ls.location_id', $retailLocation_id)
                            ->where('ls.quantity', '!=', 0)
                            ->select('products.*', 'ls.quantity as total_stock_qty')
                            ->get();

        $is_promoted_location = validPromotion($retailLocation_id);

        if($is_promoted_location){
            foreach($products as $product){
                $checkPromoProduct = checkRetailPrice($retailLocation_id, $product->id);
                $checkCashBack = PromotionProduct::where('promotion_id', $checkPromoProduct['promotion_id'])
                                                    ->where('buy_product_id', $product->id)
                                                    ->first();
                if($checkCashBack){
                    $product->cashback_value = $checkCashBack->cashback_value;
                }
                $product->retail_price = $checkPromoProduct['retail_price'];
                $product->is_promoted = $checkPromoProduct['promoted_product'];
                $product->promotion_id = $checkPromoProduct['promotion_id'];
            }
        }
       
        return view('pos.create', compact('retailLocation_id', 'products'));
    }

    public function productCreateSearch(Request $request)
    {
        try {
            $retailLocations = $this->getBranchLocations();
            if (count($retailLocations) === 1) {
                $retailLocation_id = $retailLocations[0]->id;
            }

            if (!$retailLocation_id) {
                return response()->json(['success' => false, 'message' => 'User location not found'], 404);
            }

            $keyword = $request->input('search');

            if (empty($keyword)) {
                $products = Product::join('location_stocks as ls', 'ls.product_id', '=', 'products.id')
                                    ->where('ls.location_id', $retailLocation_id)
                                    ->where('ls.quantity', '!=', 0)
                                    ->select('products.id', 'products.code', 'products.name', 'products.retail_price',
                                            'products.category_id', 'products.brand_id', 'products.model_id',
                                            'products.design_id', 'products.type_id', 'products.image', 'products.is_imei',
                                            'ls.quantity as total_stock_qty')
                                    ->distinct()
                                    ->get();

            } else {
                $productsByNameOrCode = Product::join('location_stocks as ls', 'ls.product_id', '=', 'products.id')
                                                ->where('ls.location_id', $retailLocation_id)
                                                ->where('ls.quantity', '!=', 0)
                                                ->where(function ($query) use ($keyword) {
                                                    $query->where('products.code', 'like', '%'.$keyword.'%')
                                                        ->orWhere('products.name', 'like', '%'.$keyword.'%');
                                                })
                                                ->select('products.id', 'products.code', 'products.name', 'products.retail_price',
                                                        'products.category_id', 'products.brand_id', 'products.model_id',
                                                        'products.design_id', 'products.type_id', 'products.image', 'products.is_imei',
                                                        'ls.quantity as total_stock_qty')
                                                ->distinct()
                                                ->get();

                $productsByIMEI = Product::join('location_stocks as ls', 'ls.product_id', '=', 'products.id')
                                        ->join('imei_products as ip', 'ip.product_id', '=', 'products.id')
                                        ->where('ls.location_id', $retailLocation_id)
                                        ->where('ip.imei_number', 'like', '%'.$keyword.'%') // Changed to 'like'
                                        ->select('products.id', 'products.code', 'products.name', 'products.retail_price',
                                                'products.category_id', 'products.brand_id', 'products.model_id',
                                                'products.design_id', 'products.type_id', 'products.image', 'products.is_imei',
                                                'ls.quantity as total_stock_qty')
                                        ->distinct()
                                        ->get();

                $products = $productsByNameOrCode->merge($productsByIMEI)->unique('id');
            }

            $is_promoted_location = validPromotion($retailLocation_id);
            
            if ($is_promoted_location) {
                foreach ($products as $product) {
                    $checkPromoProduct = checkRetailPrice($retailLocation_id, $product->id);
                    $checkCashBack = PromotionProduct::where('promotion_id', $checkPromoProduct['promotion_id'])
                                                    ->where('buy_product_id', $product->id)
                                                    ->first();
                if($checkCashBack){
                    $product->cashback_value = $checkCashBack->cashback_value;
                }
                    $product->retail_price = $checkPromoProduct['retail_price'];
                    $product->is_promoted = $checkPromoProduct['promoted_product'];
                    $product->promotion_id = $checkPromoProduct['promotion_id'];
                }
            }

            $html = View::make('pos.search-product-create', compact('products', 'retailLocation_id'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function createFinal(Request $request){
        $shoppers = Shopper::all();
        $banks = Bank::all();
        $saleConsultants = SaleConsultant::where('location_id', $request->location_id)
                                            ->get();

        $location_id = $request->location_id;

        return view('pos.create-final', compact('shoppers', 'location_id', 'banks', 'saleConsultants'));
    }

    public function store(Request $request){
        $invoice_number = 'POS-' . date('YmdHis');
        $order_products = json_decode($request->products);
    
        try{
            DB::beginTransaction();

            $order = PointOfSale::create([
                'order_number' => $invoice_number,
                'order_date' => now(),
                'shopper_id' => $request->shopper_id,
                'location_id' => $request->location_id,
                'origin_quantity' => $request->total_quantity,
                'total_quantity' => $request->total_quantity,
                'origin_amount' => $request->total_amount,
                'total_amount' => $request->total_amount,
                'discount_amount' => $request->discount_amount,
                'origin_net_amount' => $request->total_amount - $request->discount_amount,
                'net_amount' => $request->total_amount - $request->discount_amount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->change_amount,
                'bank_id' => $request->bank_id,
                'createable_id' => auth()->user()->id,
                'createable_type' => 'App\Models\Users',
                'sale_consultant_id' => $request->sale_consultant_id,
            ]);

            foreach($order_products as $order_product){
                $pos_product = PointOfSaleProduct::create([
                                        'point_of_sale_id' => $order->id,
                                        'product_id' => $order_product->product_id,
                                        'unit_price' => $order_product->unit_price,
                                        'origin_quantity' => $order_product->order_quantity,
                                        'quantity' => $order_product->order_quantity,
                                        'is_promote' => $order_product->is_promoted ?? 0,
                                        'promotion_id' => $order_product->promotion_id ?? null,
                                        'origin_price' => ($order_product->unit_price * $order_product->order_quantity),
                                        'cashback_amount' => property_exists($order_product, 'cashback_price') ? $order_product->cashback_price : null,
                                        'price' => ($order_product->unit_price * $order_product->order_quantity),
                                    ]);

                if($order_product->is_promoted == 1){
                    $promotion = Promotion::find($order_product->promotion_id);
                    $pos_product->imei = json_encode($order_product->imei);
                    $imeiNumbers = json_decode($pos_product->imei, true);

                    $promotionProduct = PromotionProduct::where('promotion_id', $order_product->promotion_id)
                                                        ->where('buy_product_id', $order_product->product_id)
                                                        ->first();

                    $promotionProduct->sold_quantity += $order_product->order_quantity;
                    $promotionProduct->save();

                    if($promotion->promo_type == 'cashback' && $promotionProduct && $order_product->isIMEI == 1){ /////need update
                        
                        $supplier = Supplier::join('purchases', 'purchases.supplier_id', '=', 'suppliers.id')
                                            ->join('IMEI_products', 'IMEI_products.purchase_id', '=', 'purchases.id')
                                            ->where('IMEI_products.imei_number', $order_product->imei)
                                            ->select('suppliers.id')
                                            ->first();

                        foreach ($imeiNumbers as $imei) {
                            $supplierCashback = SupplierCashback::create([
                                'supplier_id' => $supplier->id,
                                'point_of_sale_id' => $order->id,
                                'product_id' => $order_product->product_id,
                                'imei' => $imei,
                                'amount' => $promotionProduct->cashback_value,
                                'payment_status' => 'unpaid',
                                'payment_date' => now(),
                            ]);
                        }
                    }
                }

                if($order_product->isIMEI == 1){
                    $pos_product->imei = json_encode($order_product->imei);
                    $pos_product->save();

                    $imeiNumbers = json_decode($pos_product->imei, true);
                    foreach ($imeiNumbers as $imei) {
                        $imei_data = IMEIProduct::where('imei_number', $imei)
                                                    ->update([
                                                        'status' => 'Sold'
                                                    ]);
                    }
                }

                $locationStock = LocationStock::where('location_id', $request->location_id)
                                                ->where('product_id', $order_product->product_id)
                                                ->first();

                $locationStock->quantity -= $order_product->order_quantity;
                $locationStock->save();


            }
            DB::commit();
            return redirect()->route('pos-create')->with('success', 'Success! Order created');
            // return redirect()->route('printReceipt',['order_id' => $order->id]);
        }catch (\Exception $e){
            DB::rollback();
            dd($e);
            return redirect()->route('pos-create')->with('error', 'Failed! Order can not Created');
        }

    }

    public function details(Request $request){

        $sale = PointOfSale::find($request->id);
        $saleReturn = PosReturn::where('point_of_sale_id', $sale->id)->first();

        return view('pos.details', compact('sale', 'saleReturn'));
    }

    // public function printReceipt(Request $request)
    // {
    //     $order = PointOfSale::find($request->order_id);
    //     $created_by = User::where('id', $order->createable_id)->value('name');
    //     $orderProducts = PointOfSaleProduct::where('point_of_sale_id', $order->id)->get();
    //     try {

    //         // Use the shared printer name
    //         // $connector = new WindowsPrintConnector("smb://localhost/POS80 Printer");
    //         $connector = new WindowsPrintConnector("smb://localhost/POS-80C");
    //         // $connector = new WindowsPrintConnector("smb://103.149.51.68/POS-80C");

    //         $printer = new Printer($connector);
    //         $printer->selectPrintMode(Printer::MODE_FONT_B);


    //         //Name
    //         $printer->setJustification(Printer::JUSTIFY_CENTER);
    //         $printer->setFont(Printer::FONT_A); // Use larger font
    //         $printer->setTextSize(2, 2); // Double width and height for name
    //         $printer->text($order->location->location_name."\n");
    //         $printer->text("\n");

    //         //address
    //         $printer->setFont(Printer::FONT_B); // Use smaller font for address
    //         $printer->setTextSize(1, 1); // Standard size
    //         $printer->text(wrapText($order->location->address, 27));
    //         $printer->text("\n");

    //         $printer->setJustification(Printer::JUSTIFY_LEFT);
    //         $printer->setTextSize(1, 2);
    //         $printer->text("Date        : " . ($order->created_at->format('Y-m-d H:i:s'))."          Payment : ".$order->paymentType->bank_name."\n");
    //         $printer->text("\n");
    //         $printer->text("Receipt No  : ".$order->id."                           Customer: ".wrapText($order->shopper->name, 27)."");
    //         $printer->text("\n");
    //         $printer->text("Cashier     : ".$created_by."\n\n");

    //         $printer->setEmphasis(true);
    //         $printer->setTextSize(1, 2);
    //         $printer->text(str_pad("Items", 30) . str_pad("Qty", 4, ' ', STR_PAD_LEFT) . str_pad("Price", 15, ' ', STR_PAD_LEFT) . str_pad("Amount", 15, ' ', STR_PAD_LEFT) . "\n");
    //         $printer->setUnderline(0);
    //         $printer->setEmphasis(false);
    //         $printer->text("-----------------------------------------------------------------\n");


    //         foreach ($orderProducts as $item) {
    //             $product = Product::find($item->product_id);
    //             $imeiNums = [];
    //             if ($item->imei) {
    //                 $imeiNumbers = json_decode($item->imei);
    //                 if (is_array($imeiNumbers)) {
    //                     $totalImeis = count($imeiNumbers); // Get the total number of IMEIs
    //                     foreach ($imeiNumbers as $index => $imei) {
    //                         if ($index === $totalImeis - 1) {
    //                             // Add \n after the last IMEI
    //                             $imeiNums[] = "IMEI: " . $imei . "\n";
    //                         } else {
    //                             $imeiNums[] = "IMEI: " . $imei;
    //                         }
    //                     }
    //                 }
    //             }
    //             $wrappedName = wrapText($product->name, 27);
    //             if (!empty($imeiNums)) {
    //                 $wrappedName .= implode("\n", $imeiNums); // Append IMEI numbers on new lines
    //             }

    //             $lines = explode("\n", $wrappedName);


    //             foreach ($lines as $index => $line) {
    //                 if ($index === 0) {
    //                     $printer->setEmphasis(false);
    //                     $printer->text(
    //                         str_pad($line, 30) .
    //                         str_pad($item->quantity, 4, ' ', STR_PAD_LEFT) .
    //                         str_pad(number_format($item->unit_price, 2), 15, ' ', STR_PAD_LEFT) .
    //                         str_pad(number_format($item->price, 2), 15, ' ', STR_PAD_LEFT)
    //                     );
    //                 } else {
    //                     $printer->text(str_pad($line, 34) . "\n");
    //                 }
    //             }


    //         }

    //         $printer->text("-----------------------------------------------------------------\n");
    //         $printer->setEmphasis(false);
    //         $printer->setTextSize(1, 2);
    //         $printer->text("                           Sub Total:" . str_pad(number_format($order->total_amount, 2), 27, ' ', STR_PAD_LEFT) . "\n");
    //         $printer->text("\n");
    //         $printer->text("                            Discount:" . str_pad(number_format($order->discount_amount, 2), 27, ' ', STR_PAD_LEFT) . "\n");
    //         $printer->text("\n");
    //         $printer->setEmphasis(true);
    //         $printer->setTextSize(2, 2);
    //         $printer->text("             Total:" . str_pad(number_format($order->net_amount, 2), 12, ' ', STR_PAD_LEFT) . "\n");
    //         $printer->setEmphasis(false);
    //         $printer->setTextSize(1, 2);
    //         $printer->text("\n");
    //         $printer->text("                                Paid:" . str_pad(number_format($order->paid_amount, 2), 27, ' ', STR_PAD_LEFT) . "\n");
    //         $printer->text("\n");
    //         $printer->text("                              Change:" . str_pad(number_format($order->change_amount, 2), 27, ' ', STR_PAD_LEFT) . "\n");

    //         //Thanks
    //         $printer->setJustification(Printer::JUSTIFY_CENTER);
    //         $printer->setTextSize(1, 2);
    //         $printer->text("\n");
    //         $printer->text("Thank you for your purchase!\n");
    //         $printer->text("\n\n\n\n");

    //         // Cut the paper
    //         $printer->cut();

    //         // Close the printer connection
    //         $printer->close();

    //         // return response()->json(['message' => 'Print job sent successfully']);
    //         return redirect()->route('pos-create')->with('success', 'Success! Order created');
    //     } catch (Exception $e) {
    //         return redirect()->route('pos-create')->with('error', 'Print Error Found! ');
    //     }
    // }

    public function printReceipt(Request $request)
    {
        $order = PointOfSale::find($request->order_id);
        $created_by = User::where('id', $order->createable_id)->value('name');
        $orderProducts = PointOfSaleProduct::where('point_of_sale_id', $order->id)->get();

        try {
            // Prepare data for the Blade view (receipt.blade.php)
            $data = [
                'order' => $order,
                'created_by' => $created_by,
                'orderProducts' => $orderProducts,
            ];

            // Load the Blade view and generate PDF
            $pdf = Pdf::loadView('pos.receipt', $data);

            // Set custom page size for POS (80mm width, height auto)
            $pdf->setPaper([0, 0, 226.77, 1000]); // 80mm width = 226.77px, height = auto (1000px)

            // Stream the PDF to the browser
            return $pdf->stream('receipt.pdf');

        } catch (Exception $e) {
            return redirect()->route('pos-create')->with('error', 'Print Error Found!');
        }
    }

    public function chooseType($id){
        return view('pos.choose-type', compact('id'));
    }

    public function addIMEI($id)
    {
        $retailLocation_id = DB::table('user_location')
                            ->where('user_id', auth()->user()->id)
                            ->value('location_id');
        $product_imeis = IMEIProduct::where('location_id', $retailLocation_id)
                                    ->where('product_id', $id)
                                    ->where('status', 'Available')
                                    ->get();

        $imei_arr = [];
        for($i = 0; $i < count($product_imeis); $i++){
            $imei_arr[] = $product_imeis[$i]['imei_number'];
        }
        $commaSeparatedString = implode(',', $imei_arr);
        $imei_product_arr = "[$commaSeparatedString]";

        return view('pos.add-imei', compact('id', 'imei_product_arr'));
    }

    public function addIMEIManual($id)
    {
        $retailLocation_id = DB::table('user_location')
                            ->where('user_id', auth()->user()->id)
                            ->value('location_id');
        $product_imeis = IMEIProduct::where('location_id', $retailLocation_id)
                                    ->where('product_id', $id)
                                    ->where('status', 'Available')
                                    ->get();

        $imei_arr = [];
        for($i = 0; $i < count($product_imeis); $i++){
            $imei_arr[] = $product_imeis[$i]['imei_number'];
        }
        $commaSeparatedString = implode(',', $imei_arr);
        $imei_product_arr = "[$commaSeparatedString]";

        return view('pos.add-imei-manual', compact('id', 'imei_product_arr'));
    }

    public function validateIMEI($id, Request $request) {
        $imeiNumbers = $request->input('imei');
        $productId = $request->input('product_id');

        $location_id = DB::table('user_location')
                            ->where('user_id', auth()->user()->id)
                            ->value('location_id');

        $errors = [];
        foreach ($imeiNumbers as $index => $imei) {
            if (! $this->isValidIMEI($productId, $location_id, $imei)) {
                $errors[$index] = "Invalid.";
            }
        }

        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        }

        return response()->json(['success' => true]);
    }

    private function isValidIMEI($product_id, $location_id, $imei) {
        $imei_exist = IMEIProduct::where('location_id', $location_id)
                                    ->where('product_id', $product_id)
                                    ->where('imei_number', $imei)
                                    ->where('status', 'Available')
                                    ->first();

        if($imei_exist){
            return true;
        }else{
            return false;
        }

    }
}
