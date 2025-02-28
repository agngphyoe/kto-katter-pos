<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PointOfSale;
use App\Actions\HandlerResponse;
use App\Traits\GetUserLocationTrait;
use Carbon\Carbon;

class DashboardAPIController extends Controller
{
    use HandlerResponse, GetUserLocationTrait;
    public function index()
    {
        $location = $this->validateLocation();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;

        $todayTotalSales = PointOfSale::whereIn('location_id', $location)
                                        ->whereDate('created_at', $today)
                                        ->sum('net_amount');

        $yesterdayTotalSales = PointOfSale::whereIn('location_id', $location)
                                            ->whereDate('created_at', $yesterday)
                                            ->sum('net_amount');

        if ($todayTotalSales == 0 && $yesterdayTotalSales == 0) {
                $daySalePercentage = 0; // Or some other logic to signify no percentage
            } else {
                $daySalePercentage = $yesterdayTotalSales > 0
                                        ? (float) number_format((($todayTotalSales - $yesterdayTotalSales) / $yesterdayTotalSales) * 100, 2, '.', '')
                                        : 100;
        }
        // return $daySalePercentage;
        $thisMonthTotalSales = PointOfSale::where('location_id', $location)
                                            ->whereMonth('created_at', $currentMonth)
                                            ->sum('net_amount');

        $lastMonthTotalSales = PointOfSale::where('location_id', $location)
                                            ->whereMonth('created_at', $lastMonth)
                                            ->sum('net_amount');

        if ($thisMonthTotalSales == 0 && $lastMonthTotalSales == 0) {
            $monthSalePercentage = null;
        } else {
            $monthSalePercentage = $lastMonthTotalSales > 0
                ? (float) number_format((($thisMonthTotalSales - $lastMonthTotalSales) / $lastMonthTotalSales) * 100, 2, '.', '')
                : 100;
        }

        $data = [
            'todayTotalSales' => (int)$todayTotalSales,
            'yesterdayTotalSales' => (int)$yesterdayTotalSales,
            'dayChange' => $daySalePercentage,
            'thisMonthTotalSales' => (int)$thisMonthTotalSales,
            'lastMonthTotalSales' => (int)$lastMonthTotalSales,
            'monthChange' => $monthSalePercentage,
        ];


        return $this->responseCollection(data: $data);
    }
}
