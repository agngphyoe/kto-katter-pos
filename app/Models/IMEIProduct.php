<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IMEIProduct extends Model
{
    use HasFactory;
    protected $table = 'imei_products';
    protected $fillable = [
        'imei_number',
        'product_id',
        'status',
        'purchase_id',
        'location_id'
    ];

}
