<?php

namespace App\Models;

use App\Actions\GlobalCompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cashbook extends Model
{
    use HasFactory, GlobalCompanyScope;

    protected $table = 'cashbooks';

    protected $fillable = [
        'business_type_id',
        'account_id',
        'transaction_type',
        'amount',
        'description',
        'invoice_number',
        'employee_name',
        'bank_id',
        'issue_date'
    ];

    protected static function booted()
    {
        static::bootCreatedAction();
        static::bootAction();
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function businessType(): BelongsTo
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function account_type(): BelongsTo
    {
        return $this->belongsTo(AccountType::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeIncome($query)
    {
        $accounts = AccountType::whereName('Income')->first()?->accounts?->pluck('id')->toArray() ?? [];

        return $query->whereIn('account_id', $accounts);
    }

    public function scopeExpense($query)
    {
        $accounts = AccountType::whereName('Expenses')->first()?->accounts?->pluck('id')->toArray() ?? [];

        return $query->whereIn('account_id', $accounts);
    }

    public function scopeOthers($query)
    {
        $account_types = AccountType::whereNotIn('name', ['Income', 'Expense'])->pluck('id')->toArray();

        $accounts = Account::whereIn('account_type_id', $account_types)->pluck('id')->toArray() ?? [];

        return $query->whereIn('account_id', $accounts);
    }
}