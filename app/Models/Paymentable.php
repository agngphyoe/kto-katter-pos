<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentable extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'paymentable';

    protected $guarded = [];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function paymentableBy()
    {
        return $this->morphTo('paymentableby');
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
