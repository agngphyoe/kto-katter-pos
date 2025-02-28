<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $fillable = [
        'total_quantity',
        'total_amount',
        'remark',
        'damage_date',
        'location_id'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function damageProducts()
    {
        return $this->hasMany(DamageProduct::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
