<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleConsultant extends Model
{
    use HasFactory;
    protected $table = 'sale_consultants';
    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function pointOfSales()
    {
        return $this->hasMany(PointOfSale::class);
    }
}
