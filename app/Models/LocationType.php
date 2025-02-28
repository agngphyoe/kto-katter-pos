<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationType extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'location_types';
    protected $fillable = [
        'location_type_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'location_type_id');
    }
}
