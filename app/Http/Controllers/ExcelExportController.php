<?php

namespace App\Http\Controllers;

use App\Exports\BrandExport;
use App\Exports\CategoryExport;
use App\Exports\CompanyExport;
use App\Exports\CompanySettingsExport;
use App\Exports\CustomerExport;
use App\Exports\CustomerSaleExport;
use App\Exports\DamageExport;
use App\Exports\DeliveryExport;
use App\Exports\DesignExport;
use App\Exports\ExportExpense;
use App\Exports\ExportIncome;
use App\Exports\ExportOther;
use App\Exports\ExportProductOrderRequests;
use App\Exports\ExportProductReceive;
use App\Exports\ExportProductRequests;
use App\Exports\ExportProductRestore;
use App\Exports\ExportProductReturn;
use App\Exports\ExportProductTransfer;
use App\Exports\OrdersExport;
use App\Exports\PaymentExport;
use App\Exports\ProductExport;
use App\Exports\ProductHistoryExport;
use App\Exports\ProductModelExport;
use App\Exports\PromotionExport;
use App\Exports\PurchaseExport;
use App\Exports\PurchasePaymentExport as ExportsPurchasePaymentExport;
use App\Exports\PurchaseReturnExport;
use App\Exports\Report\BankReportExport;
use App\Exports\Report\CashBookReportExport;
use App\Exports\Report\CustomerReportExport;
use App\Exports\Report\ProductReportExport;
use App\Exports\Report\PurchasePaymentExport;
use App\Exports\Report\PurchaseReportExport;
use App\Exports\Report\PurchaseReturnReportExport;
use App\Exports\Report\PurchaseDetailReportExport;
use App\Exports\Report\PurchaseReturnDetailReportExport;
use App\Exports\Report\SalePaymentExport;
use App\Exports\Report\SaleReportExport;
use App\Exports\Report\SaleReturnReportExport;
use App\Exports\Report\SaleDetailReportExport;
use App\Exports\Report\SaleReturnDetailReportExport;
use App\Exports\RoleExport;
use App\Exports\SaleExport;
use App\Exports\StockAdjustmentExport;
use App\Exports\SupplierExport;
use App\Exports\TypeExport;
use App\Exports\UserExport;
use App\Exports\POSExport;
use App\Exports\POSReturnExport;
use App\Exports\ReconcileExport;
use App\Exports\ProfitAndLossExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportController extends Controller
{
    public function export(string $list, Request $request)
    {
        $data = json_decode($request->query('data'), true);

        if (!$data) {
            throw new \Exception('No data provided for export.');
        }

        switch ($list) {

            case 'products':
                $export = new ProductExport($request);
                $filename = 'products.xlsx';
                break;

            case 'suppliers':
                $export = new SupplierExport($request);
                $filename = 'suppliers.xlsx';
                break;

            case 'shops':
                $export = new CustomerExport($request);
                $filename = 'shops.xlsx';
                break;

            case 'categories':
                $export = new CategoryExport($request);
                $filename = 'categories.xlsx';
                break;

            case 'brands':
                $export = new BrandExport($request);
                $filename = 'brands.xlsx';
                break;

            case 'product-models':
                $export = new ProductModelExport($request);
                $filename = 'product-models.xlsx';
                break;

            case 'types':
                $export = new TypeExport($request);
                $filename = 'types.xlsx';
                break;

            case 'designs':
                $export = new DesignExport($request);
                $filename = 'designs.xlsx';
                break;

            case 'purchases':
                $export = new PurchaseExport($request);
                $filename = 'purchases.xlsx';
                break;

            case 'purchase-returns':
                $export = new PurchaseReturnExport($request);
                $filename = 'purchase-returns.xlsx';
                break;

            case 'sales':
                $export = new SaleExport($request);
                $filename = 'sales.xlsx';
                break;

            case 'payments':
                $export = new PaymentExport($request);
                $filename = 'payments.xlsx';
                break;

            case 'companies':
                $export = new CompanyExport();
                $filename = 'companies.xlsx';
                break;

            case 'damages':
                $export = new DamageExport($request);
                $filename = 'damages.xlsx';
                break;

            case 'roles':
                $export = new RoleExport($request);
                $filename = 'roles.xlsx';
                break;

            case 'users':
                $export = new UserExport($request);
                $filename = 'users.xlsx';
                break;

            case 'promotions':
                $export = new PromotionExport($request);
                $filename = 'promotions.xlsx';
                break;

            case 'product_stocks':
                $export = new StockAdjustmentExport($request);
                $filename = 'stock_adjustments.xlsx';
                break;

            case 'price-change-histories':
                $export = new ProductHistoryExport($request);
                $filename = 'price-change-histories.xlsx';
                break;

            case 'purchase-payment':
                $export = new ExportsPurchasePaymentExport($request);
                $filename = 'purchase-payment.xlsx';
                break;

            case 'product_transfers':
                $export = new ExportProductTransfer($request);
                $filename = 'product-transfers.xlsx';
                break;

            case 'product_receives':
                $export = new ExportProductReceive($request);
                $filename = 'product-receives.xlsx';
                break;

            case 'product_requests':
                $export = new ExportProductRequests($request);
                $filename = 'product-requests.xlsx';
                break;

            case 'po_transfer':
                $export = new ExportProductOrderRequests($request);
                $filename = 'product-order-transfer.xlsx';
                break;

            case 'product_returns':
                $export = new ExportProductReturn($request);
                $filename = 'product-return.xlsx';
                break;

            case 'product_restores':
                $export = new ExportProductRestore($request);
                $filename = 'product-restore.xlsx';
                break;

            case 'income':
                $export = new ExportIncome($request);
                $filename = 'coa-income.xlsx';
                break;

            case 'expense':
                $export = new ExportExpense($request);
                $filename = 'coa-expense.xlsx';
                break;

            case 'others':
                $export = new ExportOther($request);
                $filename = 'coa-other.xlsx';
                break;

            case 'company-settings':
                $export = new CompanySettingsExport($request);
                $filename = 'company-settings.xlsx';
                break;

            case 'pos':
                $export = new POSExport($request);
                $filename = 'pos-sales.xlsx';
                break;

            case 'pos-returns':
                $export = new POSReturnExport($request);
                $filename = 'pos-returns.xlsx';
                break;

            case 'profit-and-loss':
                $export = new ProfitAndLossExport($data);
                $filename = 'profit-and-loss-' . date('Y-m-d') . '.xlsx';
                break;

            default:
                abort(404);
        }

        return Excel::download($export, $filename);
    }

    public function exportProductReport(Request $request)
    {
        return Excel::download(new ProductReportExport(request: $request), 'product_report.xlsx');
    }

    public function exportCustomerReport(Request $request)
    {
        return Excel::download(new CustomerReportExport(request: $request), 'customer_report.xlsx');
    }

    public function exportSaleReport(Request $request)
    {
        return Excel::download(new SaleReportExport(request: $request), 'sale_report.xlsx');
    }

    public function exportPurchaseReport(Request $request)
    {
        return Excel::download(new PurchaseReportExport(request: $request), 'purchase_report.xlsx');
    }

    public function exportPurchaseReturnReport(Request $request)
    {
        return Excel::download(new PurchaseReturnReportExport(request: $request), 'purchase_return_report.xlsx');
    }

    public function exportSalePaymentReport(Request $request)
    {
        return Excel::download(new SalePaymentExport(request: $request), 'sale_payment_report.xlsx');
    }

    public function exportPurchasePaymentReport(Request $request)
    {
        return Excel::download(new PurchasePaymentExport(request: $request), 'purchase_payment_report.xlsx');
    }

    public function exportSaleReturnReport(Request $request)
    {
        return Excel::download(new SaleReturnReportExport(request: $request), 'sale_return_report.xlsx');
    }

    public function exportCashBookReport(Request $request)
    {
        return Excel::download(new CashBookReportExport(request: $request), 'cash_book_report.xlsx');
    }

    public function exportBankReport(Request $request)
    {
        return Excel::download(new BankReportExport(request: $request), 'bank_report.xlsx');
    }

    public function exportSaleDetailReport($saleId)
    {
        $sale = \App\Models\PointOfSale::with('pointOfSaleProducts')->findOrFail($saleId);

        return Excel::download(new SaleDetailReportExport($sale), 'sale_detail_report.xlsx');
    }

    public function exportSaleReturnDetailReport($returnableId)
    {
        $return = \App\Models\PosReturn::with('posReturnProducts')->findOrFail($returnableId);

        return Excel::download(new SaleReturnDetailReportExport($return), 'sale_return_detail_report.xlsx');
    }

    public function exportPurchaseDetailReport($purchaseId)
    {
        $purchase = \App\Models\Purchase::with('purchaseProducts')->findOrFail($purchaseId);

        return Excel::download(new PurchaseDetailReportExport($purchase), 'purchase_detail_report.xlsx');
    }

    public function exportPurchaseReturnDetailReport($returnableId)
    {
        $purchase_return = \App\Models\PurchaseReturn::with('purchaseReturnProducts')->findOrFail($returnableId);

        return Excel::download(new PurchaseReturnDetailReportExport($purchase_return), 'purchase_return_detail_report.xlsx');
    }

    public function exportReconcile(Request $request)
    {
        $locationId = $request->location_id;

        return Excel::download(new ReconcileExport($locationId), 'reconcile.xlsx');
    }

}
