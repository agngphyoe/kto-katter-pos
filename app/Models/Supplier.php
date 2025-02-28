<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'user_number',
        'image',
        'phone',
        'city_id',
        'country_id',
        'address',
        'contact_name',
        'contact_phone',
        'contact_position',
    ];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function return()
    {
        return $this->hasMany(Purchase::class);
    }

    public function returnableBy()
    {
        return $this->morphMany(Returnable::class, 'returnableBy');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function paymentables()
    {
        return $this->morphMany(Paymentable::class, 'paymentableBy');
    }
}
