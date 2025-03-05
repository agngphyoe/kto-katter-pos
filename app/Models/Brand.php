<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'brands';
    protected $fillable = [
        'slug',
        'name',
        'category_id',
        'created_by',
        'prefix',
    ];


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($brand) {
            foreach ($brand->products as $product) {
                if ($product->purchaseProducts()->exists()) {
                    throw new \Exception("Brand cannot be deleted because one of its products has been purchased.");
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function productModel()
    {
        return $this->hasMany(ProductModel::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
