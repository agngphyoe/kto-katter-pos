<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosReturn extends Model
{
    use HasFactory;
    protected $table = 'pos_returns';
    protected $guarded = [];

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class, 'point_of_sale_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function posReturnProducts()
    {
        return $this->hasMany(PosReturnProduct::class);
    }
}
