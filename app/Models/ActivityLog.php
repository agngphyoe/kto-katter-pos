<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'activity_logs';
    protected $fillable = [
        'user_id',
        'title',
        'activity',
        'company_id',
        'createable_id',
        'createable_type',
    ];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function createable()
    {
        return $this->morphTo();
    }
}
