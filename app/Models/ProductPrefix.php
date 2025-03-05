<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrefix extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'product_prefixs';
    protected $fillable = [
        'prefix',
        'prefix_length',
        'created_by',
        'status',
        'prefix_type'
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
