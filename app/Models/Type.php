<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $fillable = [
        'slug',
        'name',
        'created_by'
    ];

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
}
