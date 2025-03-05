<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointOfSaleProduct extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'point_of_sale_products';

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class, 'id', 'point_of_sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
