<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'account_types';
    protected $fillable = ['name', 'created_by'];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function hasAnyRelations()
    {
        return $this->accounts()->exists();
    }
}
