<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Category extends Model
{
    use HasFactory, GlobalCompanyScope;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'prefix'
    ];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            foreach ($category->products as $product) {
                if ($product->purchaseProducts()->exists()) {
                    throw new \Exception("Category cannot be deleted because one of its products has been purchased.");
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
