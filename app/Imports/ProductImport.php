<?php
namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Design;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Type;
use App\Models\LocationStock;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\ProductPrefix;
use App\Actions\ExecuteIMEIProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    private $success = true;

    public function model(array $row)
    {
        $location = Location::where('location_name', $row['location'])->firstOrFail();
        try {
            DB::beginTransaction();

            $supplier = Supplier::firstOrCreate(
                ['user_number' => '000000'],
                [
                    'name' => 'IMPORT DATA',
                    'phone' => '000000',
                    'country_id' => 123,
                    'address' => 'IMPORT',
                    'contact_name' => 'IMPORT',
                    'contact_phone' => 'IMPORT',
                    'contact_position' => 'IMPORT',
                    'created_by' => auth()->user()->id,
                ]
            );

            $purchase = Purchase::firstOrCreate(
                ['supplier_id' => $supplier->id],
                [
                    'invoice_number' => 'IMPORT',
                    'currency_type' => 'kyat',
                    'currency_rate' => 1,
                    'total_amount' => 0,
                    'total_retail_selling_amount' => 0,
                    'total_quantity' => 0,
                    'discount_amount' => 0,
                    'action_type' => 'Cash',
                    'action_date' => date('Y-m-d'),
                    'remaining_amount' => 0,
                    'purchase_amount' => 0,
                    'currency_purchase_amount' => 0,
                    'currency_discount_amount' => 0,
                    'currency_net_amount' => 0,
                    'location_id' => $location->id,
                    'payment_type' => 1
                ]
            );

            $category = $this->findOrCreateCategory($row['category'], $row['category_prefix']);
            $brand = $this->findOrCreateBrand($category, $row['brand'], $row['brand_prefix']);
            $model = $this->findOrCreateModel($brand, $row['model']);
            $type = !empty($row['type']) ? $this->findOrCreateType($row['type']) : null;
            $design = !empty($row['design']) ? $this->findOrCreateDesign($row['design']) : null;

            // Generate prefix code similar to ProductController
            if($row['code'] == null){
                $standardPrefix = '';
                $product_prefix = ProductPrefix::first();
    
                if ($product_prefix && $product_prefix->status === 'enable') {
                    $standardPrefix = $product_prefix->prefix;
                }
    
                $lastCode = Product::where('code', 'like', $standardPrefix . '%')
                                  ->orderBy('code', 'desc')
                                  ->value('code');
    
                $nextNumber = $lastCode
                    ? str_pad(
                        (int) substr($lastCode, strlen($standardPrefix)) + 1,
                        $product_prefix->prefix_length ?? 6,
                        '0',
                        STR_PAD_LEFT
                    )
                    : str_pad(1, $product_prefix->prefix_length ?? 6, '0', STR_PAD_LEFT);
    
                $code = $standardPrefix . $nextNumber;
            }else{
                $code = $row['code'];
            }
            
            $product = Product::create([
                'name' => $row['name'],
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'model_id' => $model->id,
                'design_id' => $design?->id,
                'type_id' => $type?->id,
                'code' => $code,
                'minimum_quantity' => $row['min_quantity'],
                'retail_price' => $row['selling_price'],
                'is_imei' => $row['is_imei'],
                'created_by' => Auth::id(),
            ]);

            PurchaseProduct::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'currency_buying_price' => 0,
                'buying_price' => 0,
                'quantity' => $row['quantity'],
                'status' => 'remaining',
                'purchase_quantity' => $row['quantity']
            ]);

            $purchase->total_quantity += $row['quantity'];
            $purchase->save();

            if ($row['is_imei'] == 1) {
                $imeiArray = explode(',', $row['imei_numbers']);
                (new ExecuteIMEIProduct(product: $product, imei_products: $imeiArray, purchase: $purchase))->store();
            }

            DB::commit();
            return $product;

        } catch (ValidationException $e) {
            DB::rollBack();
            \Log::error('Validation Exception:', ['error' => $e->getMessage()]);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Exception:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    private function validateRow(array $row): bool
    {
        return !empty($row['name']) && !empty($row['category']) && !empty($row['brand']) &&
            !empty($row['model']) && !empty($row['type']) && !empty($row['design']) && !empty($row['code']) &&
            !empty($row['imei']);
    }

    private function findOrCreateCategory($name, $prefix = null)
    {
        return Category::firstOrCreate([
            'name' => $name,
            'slug' => Str::slug($name),
            'prefix' => $prefix,
            'created_by' => Auth::user()->id,
        ]);
    }

    private function findOrCreateBrand($category, $name, $prefix = null)
    {
        return Brand::firstOrCreate([
            'name' => $name,
            'category_id'=> $category->id,
            'slug' => Str::slug($name),
            'prefix' => $prefix,
            'created_by' => Auth::user()->id,
        ]);
    }

    private function findOrCreateModel($brand, $name)
    {
        return ProductModel::firstOrCreate([
            'brand_id' => $brand->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'created_by' => Auth::user()->id,
        ]);
    }

    private function findOrCreateType($name)
    {
        return Type::firstOrCreate([
            'name' => $name,
            'slug' => Str::slug($name),
            'created_by' => Auth::user()->id,
        ]);
    }

    private function findOrCreateDesign($name)
    {
        return Design::firstOrCreate([
            'name' => $name,
            'slug' => Str::slug($name),
            'created_by' => Auth::user()->id,
        ]);
    }

    private function validateProductCode($code)
    {
        $existProduct = Product::where('code', $code)->first();

        if ($existProduct) {
            throw ValidationException::withMessages(['code' => "Product with code $code already exists."]);
        }
    }

    private function validateLocation($locationName)
    {
        $customerLocation = Location::where('location_name', $locationName)->first();

            if (!$customerLocation) {
            try {
                $location = Location::create([
                    'name' => $locationName,
                    'slug' => Str::slug($locationName),
                    'created_by' => Auth::user()->id,
                ]);
            } catch (\Exception $e) {
                throw ValidationException::withMessages(['location' => "Failed to create location: $locationName"]);
            }
        }
        return $customerLocation;
    }

    public function getSuccess()
    {
        return $this->success;
    }
}
