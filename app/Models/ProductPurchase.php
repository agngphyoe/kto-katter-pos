<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'buying_price',
        'selling_price'
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
}
