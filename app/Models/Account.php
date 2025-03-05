<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'accounts';
    protected $fillable = ['account_type_id', 'name', 'account_number'];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function accountType(): BelongsTo
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function cashBooks()
    {
        return $this->hasMany(Cashbook::class);
    }

    public function hasAnyRelations()
    {
        return $this->cashBooks()->exists();
    }

    public function scopeByAccountType($query, $name)
    {
        return $query->whereHas('accountType', function ($q) use ($name) {
            $q->where('name', $name);
        });
    }
}
