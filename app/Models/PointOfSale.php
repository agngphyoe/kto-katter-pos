<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfSale extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'point_of_sales';

    public function user(){
        return $this->belongsTo(User::class, 'createable_id');
    }

    public function shopper()
    {
        return $this->belongsTo(Shopper::class, 'shopper_id');
    }

    public function pointOfSaleProducts()
    {
        return $this->hasMany(PointOfSaleProduct::class, 'point_of_sale_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function posReturns()
    {
        return $this->hasMany(PosReturn::class, 'point_of_sale_id', 'id');
    }

    public function saleConsultant()
    {
        return $this->belongsTo(SaleConsultant::class);
    }

    public function supplierCashbacks()
    {
        return $this->hasMany(SupplierCashback::class);
    }
}
