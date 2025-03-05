<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'product_models';
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($productModel) {
            foreach ($productModel->products as $product) {
                if ($product->purchaseProducts()->exists()) {
                    throw new \Exception("Product model cannot be deleted because one of its products has been purchased.");
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'model_id', 'id');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }
}
