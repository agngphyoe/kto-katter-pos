<?php

namespace App\Http\Controllers\API;

use ReflectionClass;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\LocationStock;
use App\Models\LocationType;
use App\Models\IMEIProduct;
use App\Actions\HandlerResponse;
use App\Traits\GetUserLocationTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\CustomerCollection;

class ProductsAPIController extends Controller
{
    use HandlerResponse, GetUserLocationTrait;

    public function GetProductsByCategory(Request $request)
    {
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $model_id = $request->model_id;
        $keyword = $request->search ? '%' . $request->search . '%' : null;

        $productsQuery = Product::join('location_stocks as ls', 'ls.product_id', '=', 'products.id')
                                ->leftJoin('imei_products as imeis', 'imeis.product_id', '=', 'products.id')
                                ->when($category_id, fn($query) => $query->where('category_id', $category_id))
                                ->when($brand_id, fn($query) => $query->where('brand_id', $brand_id))
                                ->when($model_id, fn($query) => $query->where('model_id', $model_id))
                                ->whereIn('ls.location_id', $this->validateLocation())
                                ->with('category', 'brand', 'productModel', 'type', 'design')
                                ->groupBy('products.id')
                                ->select('products.*');

        if ($keyword) {
            $productsQuery->where(function ($query) use ($keyword) {
                $query->where('products.name', 'like', $keyword)
                    ->orWhere('products.code', 'like', $keyword)
                    ->orWhere('imeis.imei_number', 'like', $keyword);
            });
        }

        $products = $productsQuery->withSum(['location as quantity' => function ($query) {
                                                $query->whereIn('location_id', $this->validateLocation());
                                            }], 'quantity')
                                            ->get();

        foreach ($products as $product) {
            $product->image = asset('/products/image/' . $product->image);
            $product->imei_list = $product->is_imei
                ? $product->imei_products()
                            ->where('location_id', $this->validateLocation())
                            ->where('status', 'Available')
                            ->pluck('imei_number')
                : [];
        }

        return $this->responseCollection(data: $products);
    }
    
}