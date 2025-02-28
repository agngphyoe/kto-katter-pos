<?php

namespace App\Console\Commands;

use App\Constants\PromotionType;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionToEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update promotion status to end promotion.';

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
        DB::table('promotions')->where('end_date', '<', today())->update([
            'promotion_status' => PromotionType::INACTIVE
        ]);

        DB::table('products')->update([
            'promotion_price' => 0,
            'promotion_status' => 0,
        ]);

        // Log::info('running');
    }
}
