<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'business_types';
    protected $fillable = ['name', 'slug'];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
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
}
