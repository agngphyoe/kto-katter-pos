<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockPermission extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'stock_permissions';
    protected $fillable = [
        'name'
    ];

    /**
     * The products that belong to the shop.
     */
    public function locationTypes()
    {
        return $this->belongsToMany(LocationType::class);
    }
}
