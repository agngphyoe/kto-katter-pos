<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReconciliationProduct extends Model
{
    use HasFactory;

    protected $table = 'stock_reconciliation_products';
    protected $guarded = [];
}
