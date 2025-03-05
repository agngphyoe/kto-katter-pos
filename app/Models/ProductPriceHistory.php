<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use App\View\Components\table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceHistory extends Model
{
    use HasFactory, GlobalCompanyScope;
    protected $table = 'product_price_histories';
    protected $fillable = [
        'product_id',
        'old_retail_price',
        'new_retail_price',
        'old_wholesale_price',
        'new_wholesale_price',
        'created_by',
        'company_id',
    ];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
