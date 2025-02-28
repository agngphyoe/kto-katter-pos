<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'locations';
    protected $fillable = [
        'location_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function locationType()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function getLocationTypeByIdAttribute() 
    {
        return $this->locationType;
    }

    public function stocks()
    {
        return $this->hasMany(LocationStock::class, 'location_id');
    }

    public function stockAdjustments()
    {
        return $this->belongsTo(StockAdjustment::class, 'location_id');
    }

    public function distributionTransaction()
    {
        return $this->hasOne(DistributionTransaction::class);
    }

    public function getTotalProductsAttribute($location_id)
    {
        return \App\Models\LocationStock::where('location_id', $this->id)
                                            ->count();
    }

    public function getTotalQuantitiesAttribute($location_id)
    {
        return \App\Models\LocationStock::where('location_id', $this->id)
                                            ->sum('quantity');
    }

    public function getTotalRetailSellingPriceAttribute()
    {
        $location_products = \App\Models\LocationStock::where('location_id', $this->id)->get();
        $totalRetailSellingPrice = 0;

        foreach ($location_products as $product) {
            $productPrice = \App\Models\Product::where('id', $product->product_id)->value('retail_price');
            $totalRetailSellingPrice += $productPrice * $product->quantity;
        }
        return $totalRetailSellingPrice;
    }

    public function damage()
    {
        return $this->hasOne(Damage::class);
    }

    public function pointOfSales()
    {
        return $this->hasMany(PointOfSale::class);
    }

    public function saleConsultant()
    {
        return $this->hasOne(saleConsultant::class);
    }
}
