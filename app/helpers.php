<?php

use App\Actions\GenerateAutoID;
use App\Constants\ExchangeCashType;
use App\Constants\PrefixCodeID;
use App\Constants\PromotionType;
use App\Models\Paymentable;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use App\Models\IMEIProduct;
use App\Models\Product;
use Carbon\Carbon;

if (!function_exists('format_date')) {

    function format_date($date)
    {
        return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'd M, Y')
    {
        if ($date && strtotime($date)) {
            return date($format, strtotime($date));
        }
        return '-';
    }
}


if (!function_exists('timeFormat')) {

    function timeFormat($date)
    {
        return date('h:i A', strtotime($date));
    }
}

if (!function_exists('getAutoGenerateID')) {
    function getAutoGenerateID($prefix = null, $last_code = null, $length = PrefixCodeID::PREFIX_DEFAULT_LENGTH)
    {
        $id = (new GenerateAutoID(prefix: $prefix))->getSerialNumber(1, $length);
        if ($last_code ) {
            $id = (new GenerateAutoID(prefix: $prefix))->getGeneratedNumber(last_code: $last_code, length: $length);
        }
        return $id;
    }
}

if (!function_exists('calculateLogTimeDiff')) {
    function calculateLogTimeDiff($date_time)
    {
        $dateTime = Carbon::parse($date_time);

        $currentDateTime = Carbon::now();

        $diff_min   = $currentDateTime->diffInMinutes($dateTime);
        $diff_hour  = $currentDateTime->diffInHours($dateTime);
        $diff_day   = $currentDateTime->diffInDays($dateTime);

        // Determine the appropriate time unit and value to display
        if ($diff_day > 0) {
            return $diff_day . " day" . ($diff_day > 1 ? "s" : "") . " ago";
        } elseif ($diff_hour > 0) {
            return $diff_hour . " hour" . ($diff_hour > 1 ? "s" : "") . " ago";
        } elseif ($diff_min > 0) {
            return $diff_min . " minute" . ($diff_min > 1 ? "s" : "") . " ago";
        } else {
            return "Just now";
        }
    }
}

function calculatePaymentProgress(Paymentable|null $paymentable)
{
    $model              = $paymentable->paymentable;
    $total_net_amount   = $model->total_amount;
    $total_paid_amount  = $model->total_paid_amount;
    $remaining_amount   = $model->remaining_amount;

    if ($model instanceof Sale) {
        if ($model->paymentables->isNotEmpty()) {
            $payment = $model->paymentables()->latest()->first();
            $remaining_amount = $payment->remaining_amount;
            $total_paid_amount = $total_net_amount - $remaining_amount;
            if ($model->returnable->isNotEmpty()) {
                $last_sale_returnable = $model->returnable->sortByDesc('created_at')->first();
                $latest_cash_back_amount = $last_sale_returnable->latest_cash_back_amount;
                $latest_cash_back_type = $last_sale_returnable->latest_cash_back_type;
                if ($latest_cash_back_type == ExchangeCashType::REFUND) {
                    $return_refund_amount = -$latest_cash_back_amount;
                } elseif ($latest_cash_back_type == ExchangeCashType::RETURN) {
                    $return_refund_amount = $latest_cash_back_amount;
                }

                $total_net_amount = $total_net_amount +  $return_refund_amount;

                $total_paid_amount = $model->total_paid_amount;
            }
        } elseif ($model->returnable->isNotEmpty()) {
            $last_sale_returnable = $model->returnable->sortByDesc('created_at')->first();
            $latest_cash_back_amount = $last_sale_returnable->latest_cash_back_amount;
            $latest_cash_back_type = $last_sale_returnable->latest_cash_back_type;
            if ($latest_cash_back_type == ExchangeCashType::REFUND) {
                $return_refund_amount = -$latest_cash_back_amount;
            } elseif ($latest_cash_back_type == ExchangeCashType::RETURN) {
                $return_refund_amount = $latest_cash_back_amount;
            }
            $total_net_amount = $total_net_amount +  $return_refund_amount;
            $total_paid_amount = $model->total_paid_amount;
        }

        if ($total_net_amount == 0) {
            $progress = 100;
        } else {
            $progress           = min(($total_paid_amount / $total_net_amount) * 100, 100);
        }
    } elseif ($model instanceof Purchase) {

        if ($model->total_return_buying_amount) {

            $total_paid_amount = $model->total_paid_amount + $model->total_return_buying_amount + $model->discount_amount + $model->cash_down;

            $progress           = min(($total_paid_amount / $total_net_amount) * 100, 100);
        } else {

            $progress           = (($paymentable->total_paid_amount + $model->discount_amount + $model->cash_down)  / $total_net_amount) * 100;
        }
    }

    return [$progress, $remaining_amount];
}


function getLatestAndPaymentRecord(Purchase|Sale $model)
{
    $latest_payment = $model->paymentables()->latest()->first();

    $progress = 0;

    if ($latest_payment) {

        $progress = round(calculatePaymentProgress($latest_payment)[0]);
    }

    return $progress;
}

if (!function_exists('checkPromotionActive')) {
    function checkPromotionActive()
    {
        $promotion = Promotion::wherePromotionStatus(PromotionType::ACTIVE)->first();

        if ($promotion) {
            return true;
        }

        return false;
    }
}

if (!function_exists('changeIMEIStatus')) {
    function changeIMEIStatus(array $imei_numbers, string $status)
    {

        if (count($imei_numbers) > 0) {

            foreach ($imei_numbers as $imei) {

                $imei_product = IMEIProduct::whereImeiNumber($imei)->first();

                $imei_product->status = $status;
                $imei_product->save();
            }
        }

        return;
    }
}

if (!function_exists('checkIMEINumbers')) {
    function checkIMEINumbers($new_imei_numbers, $old_imei_numbers)
    {
        sort($new_imei_numbers);
        sort($old_imei_numbers);

        return empty(array_diff($new_imei_numbers, $old_imei_numbers));
    }
}

if (!function_exists('wrapText')){
    function wrapText($text, $maxLength) {
        $wrappedText = '';
        $words = explode(' ', $text);
        $currentLine = '';
    
        foreach ($words as $word) {
            if (strlen($currentLine . ' ' . $word) <= $maxLength) {
                $currentLine .= ($currentLine === '' ? '' : ' ') . $word;
            } else {
                $wrappedText .= $currentLine . "\n";
                $currentLine = $word;
            }
        }
    
        if ($currentLine !== '') {
            $wrappedText .= $currentLine . "\n";
        }
    
        return $wrappedText;
    }
}

if(!function_exists('validPromotion')){
    function validPromotion($location_id){
        $activePromotions = Promotion::where('status', 'active')
                                        ->whereJsonContains('locations', $location_id)
                                        ->count();

        if($activePromotions == 0){
            return false;
        }else{
            return true;
        }
    }
}

function checkRetailPrice($location_id, $product_id) {
    $product = Product::find($product_id);
    
    if (!$product) {
        return [
            'retail_price' => null,
            'promoted_product' => false
        ];
    }

    $promotionProductDatas = PromotionProduct::where('buy_product_id', $product_id)->get();
    $today = Carbon::today();
    $promotion = getValidPromotion($promotionProductDatas, $today);

    $retail_price = calculateRetailPrice($product->retail_price, $promotion);

    return [
        'retail_price' => $retail_price,
        'promoted_product' => $promotion ? true : false,
        'promotion_id' => $promotion ? $promotion->id : null,
    ];
}

function getValidPromotion($promotionProductDatas, $today) {
    foreach ($promotionProductDatas as $data) {
        $promotion = Promotion::where('id', $data->promotion_id)
                              ->where('status', 'active')
                              ->whereDate('start_date', '<=', $today)
                              ->whereDate('end_date', '>=', $today)
                              ->first();

        if ($promotion) {
            return $promotion;
        }
    }

    return null;
}

function calculateRetailPrice($retail_price, $promotion) {
    if ($promotion) {
        switch ($promotion->promo_type) {
            case 'dis_percentage':
                return $retail_price - ($retail_price * ($promotion->value / 100));
            case 'dis_price':
                return $retail_price - $promotion->value;
            default:
                return $retail_price;
        }
    }

    return $retail_price;
}

function customSlug($string)
{
    $replacements = [
        '+' => 'plus',
        '&' => 'and',
        '@' => 'at',
        '%' => 'percent',
        '$' => 'dollar',
    ];

    foreach ($replacements as $char => $replacement) {
        $string = str_replace($char, '-'.$replacement, $string);
    }

    return Str::slug($string);
}
