<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

use function Psy\debug;

class Product extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $fillable = [
        'code',
        'name',
        'category_id',
        'brand_id',
        'model_id',
        'type_id',
        'design_id',
        'retail_price',
        'minimum_quantity',
        'image',
        'promotion_quantity',
        'promotion_price',
        'promotion_status',
        'company_id',
        'created_by',
        'is_imei',
        'is_foc'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            if ($product->purchaseProducts()->exists()) {
                throw new \Exception("Product cannot be deleted because it has been purchased.");
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function productModel()
    {
        return $this->belongsTo(ProductModel::class, 'model_id');
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function imei_products()
    {
        return $this->hasMany(IMEIProduct::class);
    }

    public function location()
    {
        return $this->hasMany(LocationStock::class, 'product_id', 'id');
    }

    public function stockAdjustmentProduct()
    {
        return $this->hasMany(StockAdjustmentProduct::class);
    }
    
    public function productTransfer()
    {
        return $this->hasOne(ProductTransfer::class ,  'product_id' , 'id');
    }

    public function DistributionTransaction()
    {
        return $this->hasOne(DistributionTransaction::class);
    }

    public function OrderProduct()
    {
        return $this->hasOne(OrderProduct::class);
    }

    public function DamageProduct()
    {
        return $this->hasOne(DamageProduct::class);
    }

    public function purchaseReturnProduct()
    {
        return $this->hasOne(PurchaseReturnProduct::class);
    }

    public function promotionProduct()
    {
        return $this->hasOne(PromotionProduct::class);
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function available_imei_products()
    {
        return $this->hasMany(IMEIProduct::class)->where('status', 'Available');
    }

}
