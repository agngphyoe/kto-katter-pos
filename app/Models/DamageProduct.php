<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageProduct extends Model
{
    use HasFactory;
    protected $table = 'damage_products';
    protected $guarded = [];

    public function damage()
    {
        return $this->belongsTo(Damage::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
