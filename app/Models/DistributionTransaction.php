<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'distribution_transactions';

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}