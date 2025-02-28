<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $guarded = [];
    protected $table = 'countries';

    protected static function booted()
    {
        // static::bootAction();
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }
}
