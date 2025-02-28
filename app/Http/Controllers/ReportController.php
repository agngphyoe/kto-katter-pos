<?php

namespace App\Http\Controllers;

use App\Actions\ReportHandler;
use App\Constants\ProgressStatus;
use App\Constants\PurchaseType;
use App\Constants\SaleType;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\BusinessType;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Supplier;
use App\Models\ProductModel;
use App\Models\Township;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Traits\GetUserLocationTrait;

class ReportController extends Controller

{
    use GetUserLocationTrait;
    //Report index
    public function index()
    {

        return view('report.index');
    }

    //-------------Product Report--------------//

    public function productReport()
    {
        $categories = Category::all();

        $brands = Brand::all();

        $categories = Category::all();

        $models = ProductModel::all();

        return view('report.product.index', compact('categories', 'brands', 'categories', 'models'));
    }

    public function executeProductReport(Request $request)
    {
        $productables = (new ReportHandler(request: $request))->executeProduct();

        $validateLocation = $this->validateLocation();

        $view = View::make('report.product.get-report', compact('productables','validateLocation'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'product_count' => count($productables),
        ]);
    }

    public function getBrands($categoryId)
    {
        $brands = Brand::where('category_id', $categoryId)->get();
        return response()->json($brands);
    }

    public function getModels($brandId)
    {
        $models = ProductModel::where('brand_id', $brandId)->get();
        return response()->json($models);
}

    //-------------Product Report--------------//

    //-------------Customer Report--------------//

    public function customerReport()
    {
        $divisions = Division::all();

        $townships = Township::all();

        return view('report.customer.index', compact('divisions', 'townships'));
    }

    public function executeCustomerReport(Request $request)
    {
        $customers = (new ReportHandler(request: $request))->executeCustomer();

        $view = View::make('report.customer.get-report', compact('customers'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'customer_count' => count($customers),
        ]);
    }

    //-------------Customer Report--------------//

    //-------------Sale Report--------------//

    public function saleReport()
    {
        $categories = Category::all();

        $brands = Brand::all();

        $models = ProductModel::all();

        return view('report.sale.index', compact('categories', 'brands', 'models'));
    }

    public function executeSaleReport(Request $request)
    {
        $sales = (new ReportHandler(request: $request))->executeSale();

        $view = View::make('report.sale.get-report', compact('sales'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'sale_count' => count($sales),
        ]);
    }

    //-------------Sale Report--------------//


    //-------------Payment Report--------------//

    public function paymentReport()
    {

        return view('report.payment.index');
    }

    public function executePaymentReport(Request $request)
    {
        $sales = (new ReportHandler(request: $request))->executeSale();

        $view = View::make('report.sale.get-report', compact('sales'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
        ]);
    }
    //-------------Payment Report--------------//

    //-------------Purchase Report--------------//
    public function purchaseReport()
    {
        $suppliers = Supplier::all();

        $purchase_types = PurchaseType::TYPES;

        $brands = Brand::all();

        $categories = Category::all();

        $models = ProductModel::all();

        return view('report.purchase.index', compact('suppliers', 'purchase_types', 'brands', 'categories', 'models'));
    }

    public function executePurchaseReport(Request $request)
    {
        $purchases = (new ReportHandler(request: $request))->executePurchase();

        $view = View::make('report.purchase.get-report', compact('purchases'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'purchase_count' => count($purchases),
        ]);
    }
    //-------------Purchase Report--------------//


    //-------------Purchase Return Report--------------//
    public function purchaseReturnReport()
    {
        $suppliers = Supplier::all();

        $brands = Brand::all();

        $categories = Category::all();

        $models = ProductModel::all();

        return view('report.purchase-return.index', compact('suppliers', 'brands', 'categories', 'models'));
    }

    public function executePurchaseReturnReport(Request $request)
    {
        $returnables = (new ReportHandler(request: $request))->executePurchaseReturn();

        $view = View::make('report.purchase-return.get-report', compact('returnables'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'purchase_return_count' => count($returnables),
        ]);
    }
    //-------------Purchase Return Report--------------//

    //-------------Sale Payment Report--------------//
    public function salePaymentReport()
    {
        $customers = Customer::all();

        $divisions = Division::all();

        $townships = Township::all();

        return view('report.sale-payment.index', compact('customers', 'divisions', 'townships'));
    }

    public function executeSalePaymentReport(Request $request)
    {
        $paymentables = (new ReportHandler(request: $request))->executeSalePayment();

        $view = View::make('report.sale-payment.get-report', compact('paymentables'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'sale_payment_count' => count($paymentables),
        ]);
    }

    public function purchasePaymentReport()
    {
        $suppliers = Supplier::all();

        return view('report.purchase-payment.index', compact('suppliers'));
    }

    public function executePurchasePaymentReport(Request $request)
    {
        $paymentables = (new ReportHandler(request: $request))->executePurchasePayment();
        $view = View::make('report.purchase-payment.get-report', compact('paymentables'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'sale_payment_count' => count($paymentables),
        ]);
    }
    //-------------Purchase Report--------------//

    // sale return report start
    public function saleReturnReport()
    {
        $categories = Category::all();

        $brands = Brand::all();

        $models = ProductModel::all();

        return view('report.sale-return.index', compact('categories', 'brands', 'models'));
    }

    public function executeSaleReturnReport(Request $request)
    {
        $returnables = (new ReportHandler(request: $request))->executeSaleReturn();

        $view = View::make('report.sale-return.get-report', compact('returnables'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'purchase_return_count' => count($returnables),
        ]);
    }
    // sale return report end

    public function cashBookReport()
    {
        $business_types = BusinessType::all();
        $account_types = AccountType::all();
        $accounts = Account::all();
        return view('report.cash-book.index', compact('business_types', 'accounts', 'account_types'));
    }

    public function executeCashBookReport(Request $request)
    {
        $cash_book_reports = (new ReportHandler(request: $request))->executeCashBook();
        $view = View::make('report.cash-book.get-report', compact('cash_book_reports'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'cash_book_record_count' => count($cash_book_reports),
        ]);
    }

    public function bankReport()
    {
        $business_types = BusinessType::all();
        $banks = Bank::all();
        return view('report.bank.index', compact('business_types', 'banks'));
    }

    public function executeBankReport(Request $request)
    {
        $bank_reports = (new ReportHandler(request: $request))->executeBank();
        $view = View::make('report.bank.get-report', compact('bank_reports'))->render();

        return response()->json([
            'success' => true,
            'view' => $view,
            'bank_count' => count($bank_reports),
        ]);
    }
}
