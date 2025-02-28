<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'promotions';
    protected $guarded = [];

    // protected static function booted()
    // {
    //     static::bootCreatedAction();
    //     static::bootAction();
    // }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function promotionProducts()
    {
        return $this->hasMany(PromotionProduct::class);
    }

    // public function activityLogs()
    // {
    //     return $this->morphMany(ActivityLog::class, 'loggable');
    // }

    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }
}
