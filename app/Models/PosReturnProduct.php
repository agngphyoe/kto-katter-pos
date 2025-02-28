<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosReturnProduct extends Model
{
    use HasFactory;
    protected $table = 'pos_return_products';
    protected $guarded = [];

    public function posReturn()
    {
        return $this->belongsTo(PosReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
