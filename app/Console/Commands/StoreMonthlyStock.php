<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StoreMonthlyStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:store-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store stock data per product on the first and last day of each month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // Store for the first day of the month
        $this->storeStockForDate(Carbon::now()->startOfMonth()->toDateString(), 'First');

         // Store for the last day of the month
        $this->storeStockForDate(Carbon::now()->endOfMonth()->toDateString(), 'Last');
        // $firstDayOfMonth = Carbon::now()->startOfMonth()->toDateString();
        // $month = Carbon::now()->format('Y-m');

        // $stocks = DB::table('location_stocks')
        //             ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
        //             ->groupBy('product_id')
        //             ->get();

        // foreach ($stocks as $stock) {
        //     DB::table('monthly_stock')->updateOrInsert(
        //         ['month' => $month, 'product_id' => $stock->product_id],
        //         ['quantity' => $stock->total_quantity,
        //          'created_at' => now(),
        //          'updated_at' => now()]
        //     );
        // }

        // $this->info("Stock data for {$firstDayOfMonth} stored successfully.");
    }

    private function storeStockForDate($date, $dayType)
    {
        $month = Carbon::now()->format('Y-m');

        $stocks = DB::table('location_stocks')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->get();

        foreach ($stocks as $stock) {
            DB::table('monthly_stock')->updateOrInsert(
                ['month' => $month, 'product_id' => $stock->product_id, 'date' => $date],
                ['quantity' => $stock->total_quantity, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        $this->info("Stock data per product stored for {$dayType} Day: {$date}");
    }
}
