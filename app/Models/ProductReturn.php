<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'product_returns';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function fromLocationName()
    {
        return $this->hasOne(Location::class, 'id', 'from_location_id');
    }

    public function toLocationName()
    {
        return $this->hasOne(Location::class, 'id', 'to_location_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productables()
    {
        return $this->hasMany(Productable::class, 'product_id', 'product_id');
    }

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function productable()
    {
        return $this->morphMany(Productable::class, 'productable');
    }
}
