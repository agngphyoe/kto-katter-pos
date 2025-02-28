<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CurrencyType;

class Purchase extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $guarded = [];

    protected $casts = [
        'currency_type' => CurrencyType::class,
    ];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getReturnTotalQuantity()
    {
        return $this->returnable()->productable()->sum('quantity');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function paymentables()
    {
        return $this->morphMany(Paymentable::class, 'paymentable');
    }
    
    public function getFinalAmountAttribute()
    {
        return $this->total_amount - $this->discount_amount;
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function checkPurchaseStatus()
    {
        $productStatus = $this->purchaseProducts()->where('status', 'added')->count() == $this->purchaseProducts()->count();
        $this->stock_status = $productStatus ? 'Added' : 'Remaining';
        $this->save();
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function getTotalPurchaseQuantityAttribute() {
        return $this->purchaseProducts()->sum('purchase_quantity');
    }

    public function getTotalPurchaseReturnAmountAttribute() {
        return $this->purchaseReturns()->sum('return_amount');
    }

}
