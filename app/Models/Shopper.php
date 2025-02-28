<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopper extends Model
{
    use HasFactory;
    protected $table = 'shoppers';
    protected $guarded = [];

    public function pointOfSales()
    {
        return $this->hasMany(PointOfSale::class, 'shopper_id');
    }
}
