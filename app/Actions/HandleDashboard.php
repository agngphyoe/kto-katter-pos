<?php

namespace App\Actions;

use App\Constants\ProgressStatus;
use Carbon\Carbon;

class HandleDashboard
{
    // use HandleDashboardQuery;

    // protected string $model;
    // protected $morph_model = null;

    // public function __construct(string $model, $morph_model = null)
    // {
    //     $this->model = $model;
    //     $this->morph_model = $morph_model;
    // }

    // public function execute()
    // {
    //     $total_amount   = $this->executeSumAmount();

    //     $daily          = $this->executeDailyQuery();

    //     $weekly         = $this->executeWeeklyQueryForCurrentMonth();

    //     $monthly        = $this->executeMonthlyQueryForCurrentYear();

    //     return [
    //         'total_amount' => $total_amount,
    //         'daily' => $daily,
    //         'weekly' => $weekly,
    //         'monthly' => $monthly
    //     ];
    // }

    // public function executeReturn()
    // {
    //     $total_amount = $this->executeSumAmount('return_date', 'total_return_amount');

    //     $daily = $this->executeDailyQuery('return_date', 'total_return_amount');

    //     $weekly = $this->executeWeeklyQueryForCurrentMonth('return_date', 'total_return_amount');

    //     $monthly = $this->executeMonthlyQueryForCurrentYear('return_date', 'total_return_amount');

    //     return [
    //         'total_return_amount' => $total_amount,
    //         'return_daily' => $daily,
    //         'return_weekly' => $weekly,
    //         'return_monthly' => $monthly
    //     ];
    // }

    // public function executeSumAmount($date_column = 'action_date', $sum_column = 'total_amount')
    // {

    //     $query = $this->model::whereYear($date_column, Carbon::now()->year);

    //     if ($this->morph_model !== null) {

    //         $query->whereHasMorph('returnable', $this->morph_model);
    //     }

    //     return $query->sum($sum_column);
    // }

    // public function getOrderInfo()
    // {
    //     $order = $this->model::whereBetween('order_date', [Carbon::now()->startOfWeek(), Carbon::now()]);

    //     $clone_order = clone $order;
        
    //     $clone_orders = clone $order;

    //     $total_count = $order->count();

    //     $total_amount    = $order->sum('total_amount');

    //     $total_ongoing_count = $order->whereOrderStatus(ProgressStatus::ONGOING)->count();

    //     $ongoing_orders = $order->whereOrderStatus(ProgressStatus::ONGOING)->get();

    //     $total_complete_count = $order->whereOrderStatus(ProgressStatus::COMPLETE)->count();

    //     $total_ongoing    = $clone_orders->whereOrderStatus(ProgressStatus::ONGOING)->sum('total_amount');

    //     $total_complete    = $clone_order->whereOrderStatus(ProgressStatus::COMPLETE)->sum('total_amount');

    //     return [
    //         'total_ongoing_count' => $total_ongoing_count,
    //         'total_complete_count' => $total_complete_count,
    //         'total_count' => $total_count,
    //         'total_amount' => $total_amount,
    //         'total_ongoing' => $total_ongoing,
    //         'total_complete' => $total_complete,
    //         'ongoing_orders' => $ongoing_orders
    //     ];
    // }
}
