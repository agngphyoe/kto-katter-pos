<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitAndLoss extends Model
{
    use HasFactory;

    protected $table = 'profit_and_losses';

    protected $fillable = [
        'profit_and_loss_number', 'month', 'sale', 'sale_return', 'sale_discount', 'total_sales',
        'purchase_amount', 'purchase_return_amount', 'start_price', 'end_price',
        'total_cost_of_sales', 'gross_profit_on_sales', 'incomes', 'total_other_income',
        'total_gross_profit', 'expenses', 'total_expenses', 'net_profit_before_tax', 'created_by'
    ];

    protected $casts = [
        'incomes' => 'array',
        'expenses' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
