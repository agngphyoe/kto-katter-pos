<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\GetUserLocationTrait;
use App\Actions\HandleFilterQuery;
use App\Models\Role;
use App\Models\ProductTransfer;
use App\Models\PoTransfer;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductModel;
use App\Models\Type;
use App\Models\Design;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentProduct;
use App\Models\Damage;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Paymentable;
use App\Models\ProductRequest;
use App\Models\ProductReturn;
use App\Models\PointOfSale;
use App\Models\PosReturn;
use App\Models\ProfitAndLoss;
use Auth;
use DB;

class PDFExportController extends Controller
{
    use GetUserLocationTrait;

    public function export(string $list, Request $request)
    {
        $data = json_decode($request->data, true);

        $keyword    = $data['search'] ?? null;
        $start_date = $data['start_date'] ?? null;
        $end_date   = $data['end_date'] ?? null;
        $date = now()->format('Y-m-d');

        $user = Auth::user();

        switch ($list) {
            case 'roles':
                $query = Role::query();
                $roles = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeKeyDataForProductFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.roles', compact('roles', 'date'));
                return $pdf->download('roles.pdf');
                break;

            case 'categories':
                $query = Category::query();
                $categories = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeKeyDataForProductFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.categories', compact('categories', 'date'));
                return $pdf->download('categories.pdf');
                break;

            case 'brands':
                $query = Brand::query();
                $brands = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeKeyDataForProductFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.brands', compact('brands', 'date'));
                return $pdf->download('brands.pdf');
                break;

            case 'product-models':
                $query = ProductModel::query();
                $product_models = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeKeyDataForProductFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.product-models', compact('product_models', 'date'));
                return $pdf->download('product-models.pdf');
                break;

            case 'types':
                $query = Type::query();
                $types = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeKeyDataForProductFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.types', compact('types', 'date'));
                return $pdf->download('types.pdf');
                break;

            case 'designs':
                $query = Design::query();
                $designs = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeKeyDataForProductFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.designs', compact('designs', 'date'));
                return $pdf->download('designs.pdf');
                break;

            case 'product_stocks':
                $query = $user->hasRole('Super Admin') ? StockAdjustment::query() : StockAdjustment::where('created_by', auth()->user()->id);
                $stockAdjustments = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeStockAdjustmentFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.stockAdjustments', compact('stockAdjustments', 'date'));
                return $pdf->download('stockAdjustments.pdf');
                break;

            case 'damages':
                $query = $user->hasRole('Super Admin') ? Damage::query() : Damage::where('created_by', auth()->user()->id);
                $damages = (new HandleFilterQuery(keyword: $keyword))
                    ->executeDamageFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.damages', compact('damages', 'date'));
                return $pdf->download('damages.pdf');
                break;

            case 'suppliers':
                $query = Supplier::query();
                $suppliers = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeSupplierFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.suppliers', compact('suppliers', 'date'));
                return $pdf->download('suppliers.pdf');
                break;

            case 'purchases':
                $query = Purchase::where('created_by', auth()->user()->id);
                $purchases = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executePurchaseFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.purchases', compact('purchases', 'date'));
                return $pdf->download('purchases.pdf');
                break;

            case 'purchase-returns':
                $query = PurchaseReturn::where('created_by', auth()->user()->id);
                $purchaseReturns = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeProductPurchaseReturnFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.purchase-returns', compact('purchaseReturns', 'date'));
                return $pdf->download('purchaseReturns.pdf');
                break;

            case 'purchase-payment':
                $query = Paymentable::where('paymentable_type', Purchase::class)
                    ->select('paymentable_id', DB::raw('MAX(id) as id'))
                    ->groupBy('paymentable_id')
                    ->orderByDesc('id');
                $purchasePayments = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executePaymentFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.purchase-payments', compact('purchasePayments', 'date'));
                return $pdf->download('payables.pdf');
                break;

            case 'product_transfers':
                $query = ProductTransfer::query();
                $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeProductTransferFilter(query: $query);
                $product_transfers = $query->whereIn('from_location_id', $this->validateLocation())
                    ->selectRaw('
                        transfer_inv_code,
                        CASE
                            WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                            ELSE MAX(status)
                        END as status,
                        from_location_id,
                        to_location_id,
                        created_by,
                        transfer_date,
                        remark,
                        MAX(id) as id
                    ')
                    ->groupBy('transfer_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'transfer_date', 'remark')
                    ->orderBy('id', 'desc')
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.product-transfers', compact('product_transfers', 'date'));
                return $pdf->download('product-transfers.pdf');
                break;

            case 'product_receives':
                $query = ProductTransfer::query();
                $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeProductReceiveFilter(query: $query);
                $product_receives = $query->whereIn('to_location_id', $this->validateLocation())
                    ->selectRaw('
                        transfer_inv_code,
                        CASE
                            WHEN SUM(CASE WHEN status = "partial" THEN 1 ELSE 0 END) > 0 THEN "partial"
                            ELSE MAX(status)
                        END as status,
                        from_location_id,
                        to_location_id,
                        created_by,
                        transfer_date,
                        remark,
                        MAX(id) as id
                    ')
                    ->groupBy('transfer_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'transfer_date', 'remark')
                    ->orderBy('id', 'desc')
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.product-receives', compact('product_receives', 'date'));
                return $pdf->download('product-receives.pdf');
                break;

            case 'product_requests':
                $query = ProductRequest::query();
                $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeProductOrderRequestFilter(query: $query);
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
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.product-requests', compact('product_requests', 'date'));
                return $pdf->download('product-requests.pdf');
                break;

            case 'po_transfers':
                $query = PoTransfer::query();
                $query = (new HandleFilterQuery(keyword: $keyword, start_date: $start_date, end_date: $end_date))
                    ->executeProductOrderRequestFilter(query: $query);
                $poTransfers = $query->whereIn('to_location_id', $this->validateLocation())
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
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.po-transfers', compact('poTransfers', 'date'));
                return $pdf->download('po-transfers.pdf');
                break;

            case 'product_returns':
                $query = ProductReturn::query();
                $query = (new HandleFilterQuery(keyword: $keyword))
                    ->executeProductReturnRestoreFilter(query: $query);
                $product_returns = $query->whereIn('from_location_id', $this->validateLocation())
                    ->selectRaw('
                        return_inv_code,
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
                    ->groupBy('return_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                    ->orderBy('id', 'desc')
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.product-returns', compact('product_returns', 'date'));
                return $pdf->download('product-returns.pdf');
                break;

            case 'product_restores':
                $query = ProductReturn::query();
                $query = (new HandleFilterQuery(keyword: $keyword))
                    ->executeProductReturnRestoreFilter(query: $query);
                $product_restores = $query->whereIn('to_location_id', $this->validateLocation())
                    ->selectRaw('
                        return_inv_code,
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
                    ->groupBy('return_inv_code', 'from_location_id', 'to_location_id', 'created_by', 'created_at', 'remark')
                    ->orderBy('id', 'desc')
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.product-restores', compact('product_restores', 'date'));
                return $pdf->download('product-restores.pdf');
                break;

            case 'pos':
                $query = PointOfSale::where('createable_id', auth()->user()->id);
                $sales = (new HandleFilterQuery(keyword: $keyword))
                    ->executePOSFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.pos', compact('sales', 'date'));
                return $pdf->download('point-of-sales.pdf');
                break;

            case 'pos-returns':
                $query = PosReturn::where('created_by', auth()->user()->id);
                $returns = (new HandleFilterQuery(keyword: $keyword))
                    ->executePOSReturnFilter(query: $query)
                    ->get();
                $pdf = Pdf::loadView('exports.pdf.pos-returns', compact('returns', 'date'));
                return $pdf->download('pos-returns.pdf');
                break;

            case 'profit-and-loss':
                $pdf = Pdf::loadView('exports.pdf.profit-and-loss', array_merge($data, ['date' => $date]));
                return $pdf->download('profit-and-loss-' . $date . '.pdf');
                break;

            default:
                abort(404);
        }
    }
}
