<?php

namespace App\Actions;

use Carbon\Carbon;

trait HandleDashboardQuery
{

    // public function executeDailyQuery($date_column = 'action_date', $sum_column = 'total_amount')
    // {

    //     $current_week = Carbon::now()->isoWeek;

    //     $query = $this->model::whereRaw('WEEK(' . $date_column . ', 1) = ?', [$current_week]);

    //     if ($this->morph_model) {

    //         $query->whereHasMorph('returnable', $this->morph_model);
    //     }

    //     $daily_sum_total = $query->get()
    //         ->groupBy(function ($query) use ($date_column) {
    //             $day_index = Carbon::parse($query->$date_column)->dayOfWeek - 1;
    //             return $day_index;
    //         })
    //         ->map(function ($group_row) use ($sum_column) {
    //             return $group_row->sum($sum_column);
    //         })
    //         ->toArray();

    //     $result = array_fill(0, 7, 0);

    //     foreach ($daily_sum_total as $index => $value) {
    //         $result[$index] = $value;
    //     }

    //     return $result;
    // }

    // public function executeWeeklyQueryForCurrentMonth($date_column = 'action_date', $sum_column = 'total_amount')
    // {
    //     $current_month = Carbon::now()->month;

    //     $query = $this->model::whereRaw('MONTH(' . $date_column . ') = ?', [$current_month]);

    //     if ($this->morph_model) {

    //         $query->whereHasMorph('returnable', $this->morph_model);
    //     }

    //     $weekly_sum_total = $query->get()
    //         ->groupBy(function ($query) use ($date_column) {

    //             return Carbon::parse($query->$date_column)->isoWeek - Carbon::parse($query->$date_column)->startOfMonth()->isoWeek;
    //         })
    //         ->map(function ($group_row) use ($sum_column) {

    //             return $group_row->sum($sum_column);
    //         })
    //         ->toArray();

    //     $result = array_fill(0, 5, 0);

    //     foreach ($weekly_sum_total as $week_number => $value) {

    //         $result[$week_number] = $value;
    //     }

    //     return $result;
    // }

    // public function executeMonthlyQueryForCurrentYear($date_column = 'action_date', $sum_column = 'total_amount')
    // {
    //     $current_year = Carbon::now()->year;

    //     $query = $this->model::whereRaw('YEAR(' . $date_column . ') = ?', [$current_year]);

    //     if ($this->morph_model) {

    //         $query->whereHasMorph('returnable', $this->morph_model);
    //     }

    //     $monthly_sum_total = $query->get()
    //         ->groupBy(function ($query) use ($date_column) {

    //             return Carbon::parse($query->$date_column)->month - 1;
    //         })
    //         ->map(function ($group_row) use ($sum_column) {

    //             return $group_row->sum($sum_column);
    //         })
    //         ->toArray();

    //     $result = array_fill(0, 12, 0);

    //     foreach ($monthly_sum_total as $month_number => $value) {

    //         $result[$month_number] = $value;
    //     }

    //     $result = array_values($result);

    //     return $result;
    // }
}
