<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $fillable = ['bank_name', 'account_name', 'account_number'];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function cashBooks()
    {
        return $this->hasMany(Cashbook::class);
    }

    public function hasAnyRelations()
    {
        return $this->cashBooks()->exists();
    }

    public function pointOfSales()
    {
        return $this->hasMany('PointOfSale::class');
    }
}
