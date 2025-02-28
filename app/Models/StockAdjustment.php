<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $fillable = [
        'remark',
        'adjustment_date',
        'action_type',
        'location_id',
    ];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function productable()
    {
        return $this->morphMany(Productable::class, 'productable');
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

    public function stockAdjustmentProducts()
    {
        return $this->hasMany(StockAdjustmentProduct::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
