<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StockReconciliation extends Model
{
    protected $fillable = [
        'reconciliation_id',
        'location_id',
        'reconciliation_date',
        'created_by'
    ];

    protected $casts = [
        'reconciliation_date' => 'date'
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'stock_reconciliation_products')
            ->withPivot(['inv_qty', 'real_qty', 'diff']);
    }
}
