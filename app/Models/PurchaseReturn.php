<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory, GlobalCompanyScope;
    protected $guarded = [];

    public function paymentables()
    {
        return $this->morphMany(Paymentable::class, 'paymentable');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function purchaseReturnProducts()
    {
        return $this->hasMany(PurchaseReturnProduct::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    // protected static function booted()
    // {
    //     static::bootCreatedAction();
    //     static::bootAction();

    // }
}
