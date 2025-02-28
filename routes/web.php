<?php

use App\Events\ExcelFileReadyEvent;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CashBook\AccountController;
use App\Http\Controllers\CashBook\AccountTypeController;
use App\Http\Controllers\CashBook\BusinessTypeController;
use App\Http\Controllers\CashBook\COAController;
use App\Http\Controllers\CashBook\ExpenseController;
use App\Http\Controllers\CashBook\IncomeController;
use App\Http\Controllers\CashBook\OtherAssetsController;
use App\Http\Controllers\CashBook\SettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DamageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\ExcelImportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PriceHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTransferController;
use App\Http\Controllers\PoTransferController;
use App\Http\Controllers\ProductRestoreController;
use App\Http\Controllers\ProductReceiveController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\ProductReturnController;
use App\Http\Controllers\ProductModelController;
use App\Http\Controllers\ProductPrefixController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchasePaymentController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LocationTypeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\PosReturnController;
use App\Http\Controllers\StockCheckController;
use App\Http\Controllers\ShopperController;
use App\Http\Controllers\PDFExportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SaleConsultantController;
use App\Http\Controllers\ProfitAndLossController;
use App\Http\Controllers\CashbackController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

Route::get('/download/{filename}', function ($filename) {
    $filePath = public_path($filename);

    if (!file_exists($filePath)) {
        abort(404, 'File not found.');
    }

    return response()->download($filePath);
});

// Route::get('/generate-product-import-format', [ProductController::class, 'generateImportFormat'])->name('generate-product-import-format');


Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');


Auth::routes();
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth', 'check.account']], function () {


    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('check.access:dashboard');
    Route::get('/location-data/{location}', [DashboardController::class, 'locationData'])->name('location.data');
    Route::get('/filter-shop-data', [DashboardController::class, 'filterShopData'])->name('filter.shop.data');
    Route::get('/product-chart-data',[DashboardController::class, 'productChartData'])->name('productChartData');

    //position
    // Route::prefix('position')->group(function () {
    //     Route::get('/', [PositionController::class, 'index'])->name('position');

    //     Route::get('/create', [PositionController::class, 'create'])->name('position-create');

    //     Route::post('/', [PositionController::class, 'store'])->name('position-store');

    //     Route::get('/{position}/edit', [PositionController::class, 'edit'])->name('position-edit');

    //     Route::put('/{position}', [PositionController::class, 'update'])->name('position-update');

    //     Route::get('/{position}/detail', [PositionController::class, 'show'])->name('position-detail');

    //     Route::delete('/{position}', [PositionController::class, 'destroy'])->name('position-delete');
    // });

    // stuff

    // Route::prefix('staff')->group(function () {

    //     Route::get('/', [StaffController::class, 'index'])->name('staff');

    //     Route::get('/create', [StaffController::class, 'create'])->name('staff-create');

    //     Route::post('/', [StaffController::class, 'store'])->name('staff-store');

    //     Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('staff-edit');

    //     Route::put('/{staff}', [StaffController::class, 'update'])->name('staff-update');

    //     Route::get('/{staff}/detail', [StaffController::class, 'show'])->name('staff-detail');

    //     Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('staff-delete');
    // });

    //Company Settings
    Route::prefix('company-settings')->group(function () {

        Route::controller(CompanySettingController::class)->group(function () {

            Route::get('/',  'index')->name('company-settings-list');

            Route::get('/create', 'create')->name('company-settings-create');

            Route::post('/', 'store')->name('company-settings-store');

            Route::get('/{company_settings}/edit',  'edit')->name('company-settings-edit');

            Route::put('/{company_settings}',  'update')->name('company-settings-update');

            Route::delete('/{company_settings}', 'destroy')->name('company-settings-delete');
        });
    });

    //Brand
    Route::prefix('brand')->group(function () {

        Route::get('/', [BrandController::class, 'index'])->name('brand')->middleware('check.access:brand-list');

        Route::get('/create', [BrandController::class, 'create'])->name('brand-create')->middleware('check.access:brand-create');

        Route::post('/', [BrandController::class, 'store'])->name('brand-store');

        Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('brand-edit')->middleware('check.access:brand-edit');

        Route::put('/{brand}', [BrandController::class, 'update'])->name('brand-update');

        Route::get('/{brand}/detail', [BrandController::class, 'show'])->name('brand-detail')->middleware('check.access:brand-detail');

        Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('brand-delete')->middleware('check.access:brand-delete');
    });

    //Product Model
    Route::prefix('product-model')->group(function () {

        Route::get('/', [ProductModelController::class, 'index'])->name('product-model')->middleware('check.access:model-list');

        Route::get('/create', [ProductModelController::class, 'create'])->name('product-model-create')->middleware('check.access:model-create');

        Route::post('/', [ProductModelController::class, 'store'])->name('product-model-store');

        Route::get('/{product_model}/edit', [ProductModelController::class, 'edit'])->name('product-model-edit')->middleware('check.access:model-edit');

        Route::put('/{product_model}', [ProductModelController::class, 'update'])->name('product-model-update');

        Route::get('/{product_model}/detail', [ProductModelController::class, 'show'])->name('product-model-detail')->middleware('check.access:model-detail');

        Route::delete('/{product_model}', [ProductModelController::class, 'destroy'])->name('product-model-delete')->middleware('check.access:model-delete');

        Route::get('/get_category_brands', [ProductModelController::class, 'getCategoryBrands'])->name('get-category-brands');
    });

    //Category
    Route::prefix('category')->group(function () {

        Route::get('/', [CategoryController::class, 'index'])->name('category')->middleware('check.access:category-list');

        Route::get('/create', [CategoryController::class, 'create'])->name('category-create')->middleware('check.access:category-create');

        Route::post('/', [CategoryController::class, 'store'])->name('category-store');

        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category-edit')->middleware('check.access:category-edit');

        Route::put('/{category}', [CategoryController::class, 'update'])->name('category-update');

        Route::get('/{category}/detail', [CategoryController::class, 'show'])->name('category-detail')->middleware('check.access:category-detail');

        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category-delete')->middleware('check.access:category-delete');
    });

    //Type
    Route::prefix('type')->group(function () {

        Route::get('/', [TypeController::class, 'index'])->name('type')->middleware('check.access:type-list');

        // Route::get('/search', [TypeController::class, 'search'])->name('type-search');

        Route::get('/create', [TypeController::class, 'create'])->name('type-create')->middleware('check.access:type-create');

        Route::post('/', [TypeController::class, 'store'])->name('type-store');

        Route::get('/{type}/edit', [TypeController::class, 'edit'])->name('type-edit')->middleware('check.access:type-edit');

        Route::put('/{type}', [TypeController::class, 'update'])->name('type-update');

        Route::get('/{type}/detail', [TypeController::class, 'show'])->name('type-detail')->middleware('check.access:type-detail');

        Route::delete('/{type}', [TypeController::class, 'destroy'])->name('type-delete')->middleware('check.access:type-delete');
    });

    //Design
    Route::prefix('design')->group(function () {

        Route::get('/', [DesignController::class, 'index'])->name('design')->middleware('check.access:design-list');

        // Route::get('/search', [DesignController::class, 'search'])->name('design-search');

        Route::get('/create', [DesignController::class, 'create'])->name('design-create')->middleware('check.access:design-create');

        Route::post('/', [DesignController::class, 'store'])->name('design-store');

        Route::get('/{design}/edit', [DesignController::class, 'edit'])->name('design-edit')->middleware('check.access:design-edit');

        Route::put('/{design}', [DesignController::class, 'update'])->name('design-update');

        Route::get('/{design}/detail', [DesignController::class, 'show'])->name('design-detail')->middleware('check.access:design-detail');

        Route::delete('/{design}', [DesignController::class, 'destroy'])->name('design-delete')->middleware('check.access:design-delete');
    });

    //Prefix
    Route::prefix('product-prefix')->group(function () {

        Route::get('/', [ProductPrefixController::class, 'index'])->name('product-prefix');

        Route::get('/create', [ProductPrefixController::class, 'create'])->name('product-prefix-create');

        Route::post('/', [ProductPrefixController::class, 'store'])->name('product-prefix-store');

        Route::get('/{prefix}/edit', [ProductPrefixController::class, 'edit'])->name('product-prefix-edit');

        Route::put('/{prefix}', [ProductPrefixController::class, 'update'])->name('product-prefix-update');

        Route::put('/prefix_change_status/{prefix}', [ProductPrefixController::class, 'changeStatus'])->name('product-prefix-change-status');
    });

    //Product
    Route::prefix('product')->group(function () {

        Route::get('/', [ProductController::class, 'index'])->name('product')->middleware('check.access:product-list');

        Route::get('/create-list-search', [ProductController::class, 'searchProduct'])->name('product-list-search');

        Route::get('/list', [ProductController::class, 'list'])->name('product-list');

        Route::get('/create', [ProductController::class, 'create'])->name('product-create')->middleware('check.access:product-create');

        Route::post('/', [ProductController::class, 'store'])->name('product-store');

        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product-edit')->middleware('check.access:product-edit');

        Route::put('/{product}', [ProductController::class, 'update'])->name('product-update');

        Route::get('/{product}/detail', [ProductController::class, 'detail'])->name('product-detail')->middleware('check.access:product-detail');

        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product-delete')->middleware('check.access:product-delete');

        Route::get('/get-product-model', [ProductController::class, 'getProductModel'])->name('get-product-model');

        Route::get('/get-product-brand', [ProductController::class, 'getProductBrand'])->name('get-product-brand');

        Route::get('/product-price-history', [ProductController::class, 'productPriceHistory'])->name('product-price-history');

        Route::post('/import/excel', [ProductController::class, 'importExcel'])->name('import.excel');

        Route::get('/get-barcodes', [ProductController::class, 'getBarcodes'])->name('get-product-barcodes');

        Route::get('/select-barcodes', [ProductController::class, 'selectBarcodes'])->name('select-barcodes');

        Route::post('/print-barcodes', [ProductController::class, 'printBarcodes'])->name('print-barcodes');

        Route::get('/product-stock-check', [ProductController::class, 'stockCheck'])->name('product-stock-check');

        Route::get('/product/price-log/{product_id}', [ProductController::class, 'priceLog'])->name('product-price-log');

        Route::get('/build-new-product', [ProductController::class, 'buildNewProduct'])->name('build-new-product');
    });

    //Product Transfer
    Route::prefix('product-transfer')->group(function () {
        Route::get('/', [ProductTransferController::class, 'index'])->name('product-transfer')->middleware('check.access:product-transfer-list');

        Route::get('/product-transfer-create', [ProductTransferController::class, 'create'])->name('product-transfer-create');

        Route::get('/product-transfer-create-second', [ProductTransferController::class, 'createSecond'])->name('product-transfer-create-second');

        Route::post('/product-transfer-create-third', [ProductTransferController::class, 'createThird'])->name('product-transfer-create-third');

        Route::post('/', [ProductTransferController::class, 'store'])->name('product-transfer-store')->middleware('check.access:product-transfer-create');

        Route::get('/{product}/detail', [ProductTransferController::class, 'show'])->name('product-transfer-detail')->middleware('check.access:product-transfer-detail');

        Route::get('/transfer-product-create-search', [ProductTransferController::class, 'getSearchProduct'])->name('transfer-product-create-search');

        Route::get('/add-imei/{product}', [ProductTransferController::class, 'addIMEI'])->name('product-transfer-add-imei');

        Route::post('/{id}/validate-imei', [ProductTransferController::class, 'validateIMEI']);
    });

    //PO Transfer
    Route::prefix('po-transfer')->group(function () {
        Route::get('/', [PoTransferController::class, 'index'])->name('po-transfer')->middleware('check.access:po-transfer-list');

        Route::get('/{product}/detail', [PoTransferController::class, 'show'])->name('po-transfer-detail')->middleware('check.access:po-transfer-detail');

        Route::post('/', [PoTransferController::class, 'store'])->name('transfer-all-request')->middleware('check.access:po-transfer-edit');

        Route::post('/reject-all-request', [PoTransferController::class, 'rejectAll'])->name('reject-all-request')->middleware('check.access:po-transfer-edit');

        Route::post('/po-transfer', [PoTransferController::class, 'poTransfer'])->name('po-receive');
    });

    //Product Restore
    Route::prefix('product-restore')->group(function () {
        Route::get('/', [ProductRestoreController::class, 'index'])->name('product-restore')->middleware('check.access:restore-list');

        Route::get('/{product}/detail', [ProductRestoreController::class, 'show'])->name('product-restore-detail')->middleware('check.access:restore-detail');

        Route::post('/', [ProductRestoreController::class, 'store'])->name('product-all-restore')->middleware('check.access:restore-edit');

        Route::post('/restore-all-reject', [ProductRestoreController::class, 'rejectAll'])->name('restore-all-reject')->middleware('check.access:restore-edit');

        Route::post('/restore', [ProductRestoreController::class, 'restore'])->name('restore')->middleware('check.access:restore-edit');
    });

    //Product Recive
    Route::prefix('product-receive')->group(function () {
        Route::get('/', [ProductReceiveController::class, 'index'])->name('product-receive')->middleware('check.access:product-receive-list');

        Route::get('/{product}/detail', [ProductReceiveController::class, 'show'])->name('product-receive-detail')->middleware('check.access:product-receive-detail');

        Route::post('/', [ProductReceiveController::class, 'store'])->name('product-all-receive')->middleware('check.access:product-receive-edit');

        Route::post('/reject-all', [ProductReceiveController::class, 'rejectAll'])->name('product-all-reject')->middleware('check.access:product-receive-edit');

        Route::post('/receive', [ProductReceiveController::class, 'receive'])->name('receive')->middleware('check.access:product-receive-edit');
    });

    //Product Request
    Route::prefix('product-request')->group(function () {
        Route::get('/', [ProductRequestController::class, 'index'])->name('product-request')->middleware('check.access:product-request-list');

        Route::get('/product-request-create', [ProductRequestController::class, 'create'])->name('product-request-create');

        Route::get('/product-request-create-second', [ProductRequestController::class, 'createSecond'])->name('product-request-create-second');

        Route::get('/product-request-create-third', [ProductRequestController::class, 'createThird'])->name('product-request-create-third');

        Route::post('/', [ProductRequestController::class, 'store'])->name('product-request-store')->middleware('check.access:product-request-create');

        Route::get('/{product}/detail', [ProductRequestController::class, 'show'])->name('product-request-detail')->middleware('check.access:product-request-detail');

        Route::get('/request-product-create-search', [ProductRequestController::class, 'getSearchProduct'])->name('request-product-create-search');
    });


    //Product Return
    Route::prefix('product-return')->group(function () {
        Route::get('/', [ProductReturnController::class, 'index'])->name('product-return')->middleware('check.access:product-return-list');

        Route::get('/product-return-create', [ProductReturnController::class, 'create'])->name('product-return-create');

        Route::get('/product-return-create-second', [ProductReturnController::class, 'createSecond'])->name('product-return-create-second');

        Route::get('/product-return-create-third', [ProductReturnController::class, 'createThird'])->name('product-return-create-third');

        Route::post('/', [ProductReturnController::class, 'store'])->name('product-return-store')->middleware('check.access:product-return-create');

        Route::get('/{product}/detail', [ProductReturnController::class, 'show'])->name('product-return-detail')->middleware('check.access:product-return-detail');

        Route::get('/return-product-create-search', [ProductReturnController::class, 'getSearchProduct'])->name('return-product-create-search');

        Route::get('/add-imei/{product}', [ProductReturnController::class, 'addIMEI'])->name('product-return-add-imei');
    });

    //Price History
    Route::prefix('price-history')->group(function () {

        Route::get('/', [PriceHistoryController::class, 'index'])->name('price-history')->middleware('check.access:product-price-history-list');

        Route::get('/create-first', [PriceHistoryController::class, 'createFirst'])->name('price-history-create-first')->middleware('check.access:product-price-history-create');

        Route::get('/create-final', [PriceHistoryController::class, 'createFinal'])->name('price-history-create-final');

        Route::post('/price-change-store', [PriceHistoryController::class, 'store'])->name('product-price-change-store')->middleware('prevent.duplicate.submit');

        Route::get('/product-price-change', [PriceHistoryController::class, 'priceChange'])->name('product-price-change');

        Route::get('/list-search', [PriceHistoryController::class, 'searchProduct'])->name('product-history-product-list-search');

        Route::get('/product-history-detail/{date}', [PriceHistoryController::class, 'productHistoryDetail'])->name('product-history-detail');
    });

    //Supplier
    Route::prefix('supplier')->group(function () {

        // Route::get('/', [SupplierController::class, 'index'])->name('supplier')->middleware('check.access:supplier-list');

        Route::get('/list', [SupplierController::class, 'list'])->name('supplier-list')->middleware('check.access:supplier-list');

        Route::get('/create', [SupplierController::class, 'create'])->name('supplier-create')->middleware('check.access:supplier-create');

        Route::post('/', [SupplierController::class, 'store'])->name('supplier-store');

        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier-edit')->middleware('check.access:supplier-edit');

        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('supplier-update');

        Route::get('/{supplier}/detail', [SupplierController::class, 'detail'])->name('supplier-detail')->middleware('check.access:supplier-detail');

        Route::get('/{supplier}/payment-detail', [SupplierController::class, 'paymentDetail'])->name('supplier.payment-detail');

        Route::get('/{supplier}/export-payment-detail', [SupplierController::class, 'exportPaymentDetail'])->name('export-payment-detail');

        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('supplier-delete')->middleware('check.access:supplier-delete');

        Route::get('/get-city-data', [SupplierController::class, 'getCityData'])->name('get-city-data');

        Route::get('/payment-history-search', [SupplierController::class, 'paymentHistorySearch'])->name('supplier-payment-history-search');
    });

    //Product Stock
    Route::prefix('product-stock')->group(function () {

        Route::get('/', [StockAdjustmentController::class, 'index'])->name('product-stock')->middleware('check.access:product-adjustment-list');

        Route::get('/search', [StockAdjustmentController::class, 'search'])->name('product-stock-search');

        Route::get('/choose-location', [StockAdjustmentController::class, 'chooseLocation'])->name('product-stock-choose-location');

        Route::get('/create-first', [StockAdjustmentController::class, 'createFirst'])->name('product-stock-create-first')->middleware('check.access:product-adjustment-create');

        Route::get('/create-second', [StockAdjustmentController::class, 'createSecond'])->name('product-stock-create-second');

        Route::get('/create-final', [StockAdjustmentController::class, 'createFinal'])->name('product-stock-create-final');

        Route::post('/', [StockAdjustmentController::class, 'store'])->name('product-stock-store')->middleware('prevent.duplicate.submit');

        Route::get('/{product-stock}/edit', [StockAdjustmentController::class, 'edit'])->name('product-stock-edit')->middleware('check.access:product-adjustment-edit');

        Route::get('/confirm', [StockAdjustmentController::class, 'confirm'])->name('product-stock-edit-confirm');

        Route::get('/{stockAdjustment}/detail', [StockAdjustmentController::class, 'show'])->name('product-stock-detail')->middleware('check.access:product-adjustment-detail');

        Route::delete('/{stockAdjustment}', [StockAdjustmentController::class, 'destroy'])->name('product-stock-delete')->middleware('check.access:product-adjustment-delete');

        Route::get('/product-search', [StockAdjustmentController::class, 'searchProduct'])->name('product-stock-product-search');
    });

    //Purchase
    Route::prefix('purchase')->group(function () {

        Route::get('/', [PurchaseController::class, 'index'])->name('purchase')->middleware('check.access:purchase-list');

        Route::get('/list', [PurchaseController::class, 'list'])->name('purchase-list')->middleware('check.access:purchase-list');

        Route::get('/create-first', [PurchaseController::class, 'createFirst'])->name('purchase-create-first')->middleware('check.access:purchase-create');

        Route::get('/create-second', [PurchaseController::class, 'createSecond'])->name('purchase-create-second');

        Route::post('/create-third', [PurchaseController::class, 'createThird'])->name('purchase-create-third');

        Route::post('/create-final', [PurchaseController::class, 'createFinal'])->name('purchase-create-final');

        Route::post('/', [PurchaseController::class, 'store'])->name('purchase-store')->middleware('prevent.duplicate.submit');

        Route::get('/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchase-edit')->middleware('check.access:purchase-edit');

        Route::post('/{purchase}/edit-final', [PurchaseController::class, 'editFinal'])->name('purchase-edit-final');

        Route::put('/{purchase}', [PurchaseController::class, 'update'])->name('purchase-update');

        Route::get('/{purchase}/detail', [PurchaseController::class, 'show'])->name('purchase-detail')->middleware('check.access:purchase-detail');

        Route::delete('/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase-delete')->middleware('check.access:purchase-delete');

        Route::get('/supplier/{supplier}', [PurchaseController::class, 'getSelectedSupplier'])->name('get-selected-supplier');

        Route::get('/purchase-product-create-search', [PurchaseController::class, 'getSearchProduct'])->name('purchase-product-create-search');

        Route::get('/{id}/add-imei-scanner/{supplier_id}', [PurchaseController::class, 'addIMEIScanner'])->name('purchase-add-imei-scanner');

        Route::get('/choose-location', [PurchaseController::class, 'chooseLocation'])->name('purchase-choose-location');

        Route::get('/{id}/choose-type/{supplier_id}', [PurchaseController::class, 'chooseType'])->name('purchase-choose-type');

        Route::get('/{id}/add-imei-manual/{supplier_id}', [PurchaseController::class, 'addImeiManual'])->name('purchase-add-imei-manual');

        Route::post('/fetch-excel-data', [PurchaseController::class, 'fetchExcelData'])->name('fetch-excel-data');

        Route::get('/{id}/add-expire-date/{supplier_id}', [PurchaseController::class, 'addExpireDate']);
    });

    //Purchase Return
    Route::prefix('purchase-return')->group(function () {

        Route::get('/', [PurchaseReturnController::class, 'index'])->name('purchase-return')->middleware('check.access:return-purchase-list');

        Route::get('/create-first', [PurchaseReturnController::class, 'createFirst'])->name('purchase-return-create-first')->middleware('check.access:return-purchase-create');

        Route::get('/create-second/{supplier_id}', [PurchaseReturnController::class, 'createSecond'])->name('purchase-return-create-second');

        Route::get('/create-third/{id}', [PurchaseReturnController::class, 'createThird'])->name('purchase-return-create-third');

        Route::get('/create-fourth', [PurchaseReturnController::class, 'createFourth'])->name('purchase-return-create-fourth');

        Route::get('/create-final', [PurchaseReturnController::class, 'createFinal'])->name('purchase-return-create-final');

        Route::post('/', [PurchaseReturnController::class, 'store'])->name('purchase-return-store');

        Route::get('/{purchase-return}/edit', [PurchaseReturnController::class, 'edit'])->name('purchase-return-edit')->middleware('check.access:return-purchase-edit');

        Route::put('/{purchase-return}', [PurchaseReturnController::class, 'update'])->name('purchase-return-update');

        Route::get('/detail/{id}', [PurchaseReturnController::class, 'show'])->name('purchase-return-detail')->middleware('check.access:return-purchase-detail');

        Route::delete('/{purchase_return}', [PurchaseReturnController::class, 'destroy'])->name('purchase-return-delete')->middleware('check.access:return-purchase-delete');

        Route::get('/supplier/{supplier}', [PurchaseReturnController::class, 'getSupplierDetail'])->name('get-selected-supplier-detail');

        Route::get('/create-list-search', [PurchaseReturnController::class, 'searchProduct'])->name('purchase-return-product-list-search');

        Route::get('/purchase-return-add-imei/{product}/{purchase}', [PurchaseReturnController::class, 'addIMEI'])->name('purchase-return-add-imei');

        Route::get('/purchase-return-search-purchase', [PurchaseReturnController::class, 'searchPurchase'])->name('purchase-return-search-purchase');
    });

    //Payment
    Route::prefix('payment')->group(function () {

        Route::get('/', [PaymentController::class, 'index'])->name('payment')->middleware('check.access:payment-list');

        Route::get('/create-first', [PaymentController::class, 'createFirst'])->name('payment-create-first')->middleware('check.access:payment-create');

        Route::get('/create-second', [PaymentController::class, 'createSecond'])->name('payment-create-second');

        Route::get('/create-third', [PaymentController::class, 'createThird'])->name('payment-create-third');

        Route::get('/create-final', [PaymentController::class, 'createFinal'])->name('payment-create-final');

        Route::post('/', [PaymentController::class, 'store'])->name('payment-store')->middleware('prevent.duplicate.submit');

        Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('payment-edit')->middleware('check.access:payment-edit');

        Route::put('/{payment}', [PaymentController::class, 'update'])->name('payment-update');

        Route::get('{payment}/detail', [PaymentController::class, 'show'])->name('payment-detail')->middleware('check.access:payment-detail');

        Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('payment-delete')->middleware('check.access:payment-delete');
    });

    // purchase payment
    Route::prefix('purchase-payment')->group(function () {

        Route::get('/', [PurchasePaymentController::class, 'index'])->name('purchase-payment')->middleware('check.access:purchase-payment-list');

        Route::get('/create-first', [PurchasePaymentController::class, 'createFirst'])->name('purchase-payment-create-first')->middleware('check.access:purchase-payment-create');

        Route::get('/create-second', [PurchasePaymentController::class, 'createSecond'])->name('purchase-payment-create-second');

        Route::get('/create-third', [PurchasePaymentController::class, 'createThird'])->name('purchase-payment-create-third');

        Route::get('/create-final', [PurchasePaymentController::class, 'createFinal'])->name('purchase-payment-create-final');

        Route::post('/', [PurchasePaymentController::class, 'store'])->name('purchase-payment-store')->middleware('prevent.duplicate.submit');

        Route::get('{payment}/detail', [PurchasePaymentController::class, 'show'])->name('purchase-payment-detail')->middleware('check.access:payment-detail');

        Route::get('/search-purchase', [PurchasePaymentController::class, 'searchPurchase'])->name('purchase-payment-search-purchase');
    });

    //Damage
    Route::prefix('damage')->group(function () {

        Route::get('/', [DamageController::class, 'index'])->name('damage')->middleware('check.access:product-damage-list');

        Route::get('/choose-store', [DamageController::class, 'chooseStoreLocation'])->name('damage-choose-location');

        Route::get('/create-first', [DamageController::class, 'createFirst'])->name('damage-create-first')->middleware('check.access:product-damage-create');

        Route::get('/create-second', [DamageController::class, 'createSecond'])->name('damage-create-second');

        Route::get('/create-final', [DamageController::class, 'createFinal'])->name('damage-create-final');

        Route::post('/', [DamageController::class, 'store'])->name('damage-product-store')->middleware('prevent.duplicate.submit');

        Route::get('/edit-first', [DamageController::class, 'editFirst'])->name('damage-edit-first')->middleware('check.access:product-damage-edit');

        Route::get('/edit-final', [DamageController::class, 'editFinal'])->name('damage-edit-final')->middleware('check.access:product-damage-edit');

        Route::put('/{damage}', [DamageController::class, 'update'])->name('damage-update');

        Route::get('/{damage}/detail', [DamageController::class, 'show'])->name('damage-detail')->middleware('check.access:product-damage-detail');

        Route::delete('/{damage}', [DamageController::class, 'destroy'])->name('damage-delete')->middleware('check.access:product-damage-delete');

        // Route::get('/search-damage-product', [DamageController::class, 'searchDamageProduct'])->name('damage-edit-search-product');
    });

    //Promotion
    Route::prefix('promotion')->group(function () {

        Route::get('/', [PromotionController::class, 'index'])->name('promotion')->middleware('check.access:promotion-list');

        Route::get('/create-first', [PromotionController::class, 'createFirst'])->name('promotion-create-first');

        Route::get('/create-second', [PromotionController::class, 'createSecond'])->name('promotion-create-second');

        Route::get('/create-third', [PromotionController::class, 'createThird'])->name('promotion-create-third');

        Route::get('/create-final', [PromotionController::class, 'createFinal'])->name('promotion-create-final');

        Route::post('/', [PromotionController::class, 'store'])->name('promotion-store');

        Route::get('/{promotion}/edit', [PromotionController::class, 'edit'])->name('promotion-edit');

        Route::put('/{promotion}', [PromotionController::class, 'update'])->name('promotion-update');

        Route::get('/{promotion}/detail', [PromotionController::class, 'show'])->name('promotion-detail');

        Route::delete('/{promotion}', [PromotionController::class, 'destroy'])->name('promotion-delete');

        Route::get('/promotion-choose-product-search', [PromotionController::class, 'chooseProductSearch'])->name('promotion-choose-product-search');

        Route::put('/change-status/{promotion}', [PromotionController::class, 'changeStatus'])->name('promotion-change-status');

        Route::get('/choose-method', [PromotionController::class, 'chooseMethod'])->name('promotion-choose-method');

        Route::get('/get-brands', [PromotionController::class, 'getBrands'])->name('promotion-get-brands');

        Route::get('/get-brands-by-category', [PromotionController::class, 'getBrandsByCategory'])->name('get.brands.by.category');
    });

    //User
    Route::prefix('user')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('user')->middleware('check.access:user-list');

        Route::get('/list', [UserController::class, 'list'])->name('user-list')->middleware('check.access:user-list');

        Route::get('/activity-list', [UserController::class, 'activityList'])->name('user-activity-list')->middleware('check.access:activity-log-list');

        Route::get('/create-first', [UserController::class, 'createFirst'])->name('user-create-first')->middleware('check.access:user-create');

        Route::post('/create-final', [UserController::class, 'createFinal'])->name('user-create-final');

        Route::post('/user-store-final', [UserController::class, 'storeFinal'])->name('user-store-final');

        Route::get('/{user}/edit-first', [UserController::class, 'editFirst'])->name('user-edit-first')->middleware('check.access:user-edit');

        Route::post('/edit-final', [UserController::class, 'editFinal'])->name('user-edit-final');

        Route::put('/{user}', [UserController::class, 'update'])->name('user-update');

        Route::get('/{user}/detail', [UserController::class, 'show'])->name('user-detail')->middleware('check.access:user-detail');

        Route::get('/{user}/user-task', [UserController::class, 'showTask'])->name('user-task');

        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user-delete')->middleware('check.access:user-delete');

        Route::post('/{id}/account-activate', [UserController::class, 'activate'])->name('account-activate');

        Route::post('/{id}/account-deactivate', [UserController::class, 'deactivate'])->name('account-deactivate');

        Route::get('/user-setting', [UserController::class, 'userSetting'])->name('user-setting');

        Route::post('/user-password-confirm', [UserController::class, 'checkPassForUserEdit'])->name('user-confirm-pass-for-edit');

        Route::post('/user-update-form-one-from-profile/{user}', [UserController::class, 'updateUserFormOneFromProfile'])->name('user-update-form-one-from-profile');

        Route::post('/user-update-from-profile/{user}', [UserController::class, 'updateUserFromProfile'])->name('user-update-from-profile');

        Route::post('/reset-noti-count', [UserController::class, 'resetNotiCount'])->name('reset.noti-count');
    });

    //Company
    Route::prefix('company')->group(function () {

        Route::get('/', [CompanyController::class, 'index'])->name('company')->middleware('check.access:user-list');

        Route::get('/create', [CompanyController::class, 'create'])->name('company-create');

        Route::post('/', [CompanyController::class, 'store'])->name('company-store');

        Route::get('/{company}/edit', [CompanyController::class, 'edit'])->name('company-edit');

        Route::put('/{company}', [CompanyController::class, 'update'])->name('company-update');

        Route::get('/{company}/detail', [CompanyController::class, 'show'])->name('company-detail');

        Route::delete('/{company}', [CompanyController::class, 'destroy'])->name('company-delete');
    });

    //Location Type
    Route::prefix('location-type')->group(function () {

        Route::get('/', [LocationTypeController::class, 'index'])->name('location-type')->middleware('check.access:location-type-list');

        Route::get('/create', [LocationTypeController::class, 'create'])->name('location-type-create');

        Route::post('/', [LocationTypeController::class, 'store'])->name('location-type-store');

        Route::get('/{location_type}/edit', [LocationTypeController::class, 'edit'])->name('location-type-edit')->middleware('check.access:location-type-edit');

        Route::put('/{location_type}', [LocationTypeController::class, 'update'])->name('location-type-update');
    });

    //Location Type
    Route::prefix('location')->group(function () {

        Route::get('/', [LocationController::class, 'index'])->name('location')->middleware('check.access:location-list');

        Route::get('/create', [LocationController::class, 'create'])->name('location-create');

        Route::post('/', [LocationController::class, 'store'])->name('location-store');

        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('location-edit')->middleware('check.access:location-edit');

        Route::put('/{location}', [LocationController::class, 'update'])->name('location-update');

        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('location-destroy');
    });

    //Role
    Route::prefix('role')->group(function () {

        Route::get('/', [RoleController::class, 'index'])->name('role')->middleware('check.access:role-list');

        Route::get('/list', [RoleController::class, 'list'])->name('role-list')->middleware('check.access:role-list');

        Route::get('/create', [RoleController::class, 'create'])->name('role-create')->middleware('check.access:role-create');

        Route::post('/', [RoleController::class, 'store'])->name('role-store');

        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('role-edit')->middleware('check.access:role-edit');

        Route::put('/{role}', [RoleController::class, 'update'])->name('role-update');

        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('role-delete');
    });

    //Export
    // Route::get('/export', Export::class)->name('export');
    Route::get('/export-type/{list}', [ExportController::class, 'exportType'])->name('export-type');
    Route::get('/export/{list}', [ExcelExportController::class, 'export'])->name('export-list');
    Route::get('/pdf-export/{list}', [PDFExportController::class, 'export'])->name('pdf-export-list');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Report
    Route::prefix('report')->group(function () {

        Route::controller(ReportController::class)->group(function () {

            Route::get('/', 'index')->name('report');

            Route::prefix('product')->group(function () {

                Route::get('/',  'productReport')->name('product-report');

                Route::get('/brands/{categoryId}', 'getBrands')->name('get-brands');

                Route::get('/models/{brandId}', 'getModels')->name('get-models');

                Route::post('/get-product-report', 'executeProductReport')->name('get-product-report');
            });

            Route::prefix('customer')->group(function () {

                Route::get('/',  'customerReport')->name('customer-report');

                Route::post('/get-customer-report', 'executeCustomerReport')->name('get-customer-report');
            });

            Route::prefix('sale')->group(function () {

                Route::get('/',  'saleReport')->name('sale-report');

                Route::get('/brands/{categoryId}', 'getBrands')->name('get-brands');

                Route::get('/models/{brandId}', 'getModels')->name('get-models');

                Route::post('/get-sale-report', 'executeSaleReport')->name('get-sale-report');
            });

            Route::prefix('sale-payment')->group(function () {

                Route::get('/',  'salePaymentReport')->name('sale-payment-report');

                Route::post('/get-sale-payment-report', 'executeSalePaymentReport')->name('get-sale-payment-report');
            });

            Route::prefix('purchase-payment')->group(function () {

                Route::get('/',  'purchasePaymentReport')->name('purchase-payment-report');

                Route::post('/get-purchase-payment-report', 'executePurchasePaymentReport')->name('get-purchase-payment-report');
            });

            Route::prefix('purchase')->group(function () {

                Route::get('/',  'purchaseReport')->name('purchase-report');

                Route::get('/brands/{categoryId}', 'getBrands')->name('get-brands');

                Route::get('/models/{brandId}', 'getModels')->name('get-models');

                Route::post('/get-purchase-report', 'executePurchaseReport')->name('get-purchase-report');
            });

            Route::prefix('purchase-return')->group(function () {

                Route::get('/',  'purchaseReturnReport')->name('purchase-return-report');

                Route::get('/brands/{categoryId}', 'getBrands')->name('get-brands');

                Route::get('/models/{brandId}', 'getModels')->name('get-models');

                Route::post('/get-purchase-return-report', 'executePurchaseReturnReport')->name('get-purchase-return-report');
            });

            Route::prefix('sale-return')->group(function () {

                Route::get('/',  'saleReturnReport')->name('sale-return-report');

                Route::get('/brands/{categoryId}', 'getBrands')->name('get-brands');

                Route::get('/models/{brandId}', 'getModels')->name('get-models');

                Route::post('/get-sale-return-report', 'executeSaleReturnReport')->name('get-sale-return-report');
            });

            Route::prefix('cash-book')->group(function () {

                Route::get('/',  'cashBookReport')->name('cash-book-report');

                Route::post('/get-cash-book-report', 'executeCashBookReport')->name('get-cash-book-report');
            });

            Route::prefix('bank')->group(function () {

                Route::get('/',  'bankReport')->name('bank-report');

                Route::post('/get-bank-report', 'executeBankReport')->name('get-bank-report');
            });
        });

        Route::prefix('excel')->group(function () {

            Route::controller(ExcelExportController::class)->group(function () {

                Route::post('export-product-report', 'exportProductReport')->name('export-product-report')->middleware('check.access:export-product-report');

                Route::post('export-customer-report', 'exportCustomerReport')->name('export-customer-report')->middleware('check.access:export-customer-report');

                Route::post('export-sale-report', 'exportSaleReport')->name('export-sale-report');

                Route::post('export-purchase-report', 'exportPurchaseReport')->name('export-purchase-report');

                Route::post('export-purchase-return-report', 'exportPurchaseReturnReport')->name('export-purchase-return-report');

                Route::post('export-sale-payment-report', 'exportSalePaymentReport')->name('export-sale-payment-report');

                Route::post('export-purchase-payment-report', 'exportPurchasePaymentReport')->name('export-purchase-payment-report');

                Route::post('export-sale-return-report', 'exportSaleReturnReport')->name('export-sale-return-report');

                Route::post('export-cash-book-report', 'exportCashBookReport')->name('export-cash-book-report');

                Route::post('export-bank-report', 'exportBankReport')->name('export-bank-report');

                Route::get('/export-sale-details/{saleId}', [ExcelExportController::class, 'exportSaleDetailReport'])->name('export-sale-detail');

                Route::get('/export-sale-return-details/{returnableId}', [ExcelExportController::class, 'exportSaleReturnDetailReport'])->name('export-sale-return-detail');

                Route::get('/export-purchase-details/{purchaseId}', [ExcelExportController::class, 'exportPurchaseDetailReport'])->name('export-purchase-detail');

                Route::get('/export-purchase-return-details/{returnableId}', [ExcelExportController::class, 'exportPurchaseReturnDetailReport'])->name('export-purchase-return-detail');

            });
        });
    });

    //CashBook
    Route::prefix('cashbook')->group(function () {

        Route::prefix('settings')->group(function () {

            Route::controller(SettingsController::class)->group(function () {

                Route::get('/',  'index')->name('settings-list');

                Route::get('/create',  'create')->name('settings-create');
            });

            Route::prefix('account-type')->group(function () {

                Route::controller(AccountTypeController::class)->group(function () {

                    Route::get('/',  'index')->name('account-type-list');

                    Route::get('/create',  'create')->name('account-type-create');

                    Route::post('/store',  'store')->name('account-type-store');

                    Route::get('/{accountType}/edit', 'edit')->name('account-type-edit');

                    Route::put('/{accountType}', 'update')->name('account-type-update');

                    Route::delete('/{accountType}', 'destroy')->name('account-type-delete');

                    Route::get('/select-options', 'selectOptions')->name('account-type-select-options');
                });
            });

            Route::prefix('business-type')->group(function () {

                Route::controller(BusinessTypeController::class)->group(function () {

                    Route::get('/',  'index')->name('business-type-list');

                    Route::get('/create',  'create')->name('business-type-create');

                    Route::post('/store',  'store')->name('business-type-store');

                    Route::get('/{businessType}/edit', 'edit')->name('business-type-edit');

                    Route::put('/{businessType}', 'update')->name('business-type-update');

                    Route::delete('/{businessType}', 'destroy')->name('business-type-delete');

                    Route::get('/select-options', 'selectOptions')->name('business-type-select-options');
                });
            });

            Route::prefix('account')->group(function () {

                Route::controller(AccountController::class)->group(function () {

                    Route::get('/',  'index')->name('account-list');

                    Route::get('/create',  'create')->name('account-create');

                    Route::post('/store',  'store')->name('account-store');

                    Route::get('/{account}/edit', 'edit')->name('account-edit');

                    Route::put('/{account}', 'update')->name('account-update');

                    Route::delete('/{account}', 'destroy')->name('account-delete');

                    Route::get('/select-options', 'selectOptions')->name('account-select-options');

                    Route::post('/get-account-from-account-type-selected', 'getAccountFromSelectedAccountType')->name('get-account-from-account-type-selected');
                });
            });

            Route::prefix('bank')->group(function () {

                Route::controller(BankController::class)->group(function () {

                    Route::get('/',  'index')->name('bank');

                    Route::get('/create',  'create')->name('bank-create');

                    Route::post('/store',  'store')->name('bank-store');

                    Route::get('/{bank}/edit', 'edit')->name('bank-edit');

                    Route::put('/{bank}', 'update')->name('bank-update');

                    Route::delete('/{bank}', 'destroy')->name('bank-delete');
                });
            });
        });

        Route::prefix('coa')->group(function () {
            Route::controller(COAController::class)->group(function () {

                Route::get('/',  'index')->name('coa-list');

                Route::get('/create',  'create')->name('coa-create');
            });
        });

        Route::prefix('profit-and-loss')->group(function () {
            Route::controller(ProfitAndLossController::class)->group(function () {
                Route::get('/', 'index')->name('pl-list');
                Route::get('/choose-month', 'chooseMonth')->name('profit-and-loss-choose-month');
                Route::get('/calculate-data', 'calculateData')->name('profit-and-loss-calculate-data');
                Route::get('/select-income-expense', 'selectIncomeExpense')->name('profit-and-loss-select-income-expense');
                Route::post('/store-pl-format', 'storePLFormat')->name('profit-and-loss-store-pl-format');
                Route::post('/save-and-export', 'saveAndExport')->name('profit-and-loss-save-and-export');
                Route::get('/details/{id}', 'details')->name('profit-and-loss-details');
            });
        });

        Route::prefix('income')->group(function () {

            Route::controller(IncomeController::class)->group(function () {

                Route::get('/',  'index')->name('income-list');

                Route::get('/create',  'create')->name('income-create');

                Route::post('/store',  'store')->name('income-store');

                Route::get('/{income}/edit', 'edit')->name('income-edit');

                Route::put('/{income}', 'update')->name('income-update');

                Route::delete('/{income}', 'destroy')->name('income-delete');
            });
        });

        Route::prefix('expense')->group(function () {

            Route::controller(ExpenseController::class)->group(function () {

                Route::get('/',  'index')->name('expense-list');

                Route::get('/create',  'create')->name('expense-create');

                Route::post('/store',  'store')->name('expense-store');

                Route::get('/{expense}/edit', 'edit')->name('expense-edit');

                Route::put('/{expense}', 'update')->name('expense-update');

                Route::delete('/{expense}', 'destroy')->name('expense-delete');
            });
        });

        Route::prefix('others')->group(function () {

            Route::controller(OtherAssetsController::class)->group(function () {

                Route::get('/',  'index')->name('others-list');

                Route::get('/create',  'create')->name('others-create');

                Route::post('/store',  'store')->name('others-store');

                Route::get('/{other}/edit', 'edit')->name('others-edit');

                Route::put('/{other}', 'update')->name('others-update');

                Route::delete('/{other}', 'destroy')->name('others-delete');
            });
        });
    });

    //Excel Import
    Route::prefix('excel-import')->group(function () {

        Route::controller(ExcelImportController::class)->group(function () {

            Route::get('/customer', 'customerFileImport')->name('customer-import-upload');

            Route::post('/import-customers', 'importCustomers')->name('import-customer');

            Route::get('/product', 'productFileImport')->name('product-import-upload');

            Route::post('/import-products', 'importProducts')->name(('import-product'));
        });
    });

    // Add Purchase Stock
    Route::prefix('add-purchase-stock')->group(function() {
        Route::controller(PurchaseController::class)->group(function(){
            Route::get('/histories', 'stockAddHistories')->name('product-purchase-stock-histories');
            Route::get('/list', 'purchaseStockList')->name('product-purchase-stock-list');
            Route::get('/choose-purchase', 'choosePurchase')->name('product-purchase-choose');
            Route::get('/add', 'addPurchase')->name('product-purchase-stock-add');
            Route::post('/store', 'storePurchaseStock')->name('product-purchase-stock-store');
            Route::get('/histories/details', 'historyDetails')->name('product-purchase-stock-history-details');
        });
    });

   //Point Of Sale
   Route::prefix('pos')->group(function() {
    Route::controller(POSController::class)->group(function(){
        Route::get('/create', 'create')->name('pos-create');
        Route::get('/pos-product-create-search', 'productCreateSearch')->name('pos-create-search');
        Route::post('/create-final', 'createFinal')->name('pos-create-final');
        Route::post('/store', 'store')->name('pos-store');
        Route::get('/list', 'index')->name('pos-list');
        Route::get('/details', 'details')->name('pos-details');
        Route::get('/print-receipt', 'printReceipt')->name('printReceipt');
        Route::get('/{id}/choose-type', 'chooseType')->name('pos-choose-type');
        Route::get('/{id}/add-imei', 'addIMEI')->name('pos-add-imei');
        Route::get('/{id}/add-imei-manual', 'addIMEIManual')->name('pos-add-imei-manual');
        Route::post('/{id}/pos-validate-imei', 'validateIMEI');
    });

    //Point of Sale Return
    Route::prefix('pos-return')->group(function() {
        Route::controller(PosReturnController::class)->group(function(){
            Route::get('/list', 'index')->name('pos-return-list');
            Route::get('/create-first', 'createFirst')->name('pos-return-create-first');
            Route::get('/create-second', 'createSecond')->name('pos-return-create-second');
            Route::get('/create-third/{id}', 'createThird')->name('pos-return-create-third');
            Route::get('/create-fourth', 'createFourth')->name('pos-return-create-fourth');
            Route::get('/create-final', 'createFinal')->name('pos-return-create-final');
            Route::post('/store', 'store')->name('pos-return-store');
            Route::get('/shopper', 'getShopperDetail')->name('get-selected-shopper-detail');
            Route::get('/details', 'details')->name('pos-return-details');
            Route::get('/{purchase}/{product}/add-imei', 'addIMEI')->name('pos-return-add-imei');
        });
    });

    //Point of Sale Cashback
    Route::prefix('pos-cashback')->group(function() {
        Route::controller(CashbackController::class)->group(function(){
            Route::get('/list', 'index')->name('pos-cashback-list');
            Route::get('/details/{supplier}', 'details')->name('pos-cashback-details');
            Route::get('/change-status/{supplier}', 'changeStatus')->name('pos-cashback-change-status');
        });
    });

    });

    //Stocks Check
    Route::prefix('stocks-check')->group(function() {
        Route::controller(StockCheckController::class)->group(function(){
            Route::get('/list', 'index')->name('stock-check-list');
            Route::get('/location-stock-details', 'stockDetails')->name('stock-check-details');
            Route::get('/location-product-search', 'searchLocationProduct')->name('stock-check-search-location-product');
            Route::get('/imei-stock', 'imeiStock')->name('imei-stock');
            Route::get('/location-reconcile', 'locationReconcile')->name('location-reconcile');
            Route::get('/reconcile-product-search', 'searchReconcileProduct')->name('location-reconcile-search-product');
            Route::post('save-reconcile', 'saveReconcile')->name('location-reconcile-save');
            Route::get('/reconciliation/{id}/detail', 'reconciliationDetail')->name('reconciliation-detail');
            Route::get('/reconciliation/{id}/export', 'exportReconcile')->name('export-reconcile');
            Route::get('/get-brands-by-category', 'getBrandsByCategory')->name('get.brands.by.category');
        });

    });

    //Shopper
    Route::prefix('shopper')->group(function() {
        Route::controller(ShopperController::class)->group(function() {
            Route::post('/store', 'store')->name('shopper-store');
        });
    });

    //Sale Consultants
    Route::prefix('sale-consultants')->group(function() {
        Route::controller(SaleConsultantController::class)->group(function() {
            Route::get('/', 'index')->name('sc-list');
            Route::get('/create', 'create')->name('sc-create');
            Route::post('/store', 'store')->name('sc-store');
            Route::get('/edit/{id}', 'edit')->name('sc-edit');
            Route::post('/update/{id}', 'update')->name('sc-update');
            Route::delete('/{id}', 'destroy')->name('sc-delete');
            Route::get('/details/{id}', 'details')->name('sc-details');
        });
    });

    //IMEI History
    Route::prefix('imei-history')->group(function() {
        Route::get('/imei-history-search',[ProductController::class, 'imeiHistorySearch'])->name('imei-history-search');
        Route::post('/check-imei-product', [ProductController::class, 'checkIMEIProduct']);
        Route::get('/imei-history-data/{imei}',[ProductController::class, 'imeiHistoryData'])->name('imei-history-data');
    });

});
