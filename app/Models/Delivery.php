<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $fillable = [
        'sale_id',
        'status',
        'image',
    ];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
