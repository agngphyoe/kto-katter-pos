<?php

namespace App\Actions;

use App\Constants\SaleType;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class HandleFilterQuery
{
    protected $keyword, $start_date, $end_date, $location;

    public function __construct($keyword,$location = null, $start_date = null, $end_date = null)
    {
        $this->keyword      = $keyword;
        $this->location     = $location;
        $this->start_date   = $start_date;
        $this->end_date     = $end_date;
    }


    //execute filter for user
    public function executeUserFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('name', 'like', $keyword)
                    ->orWhereHas('role', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })
                    ->orWhereHas('company', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    // user activity filters
    public function executeUserActivityFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('title', 'like', $keyword)
                    ->orWhere('activity', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }
    //excute filter for staff data
    public function executeKeyDataForStaffFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('name', 'like', $keyword)
                    ->orWhere('user_number', 'like', $keyword)
                    ->orWhere('phone', 'like', $keyword)
                    ->orWhereHas('position', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })->orWhereHas('division', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })->orWhereHas('township', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for key data product
    public function executeKeyDataForProductFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('name', 'like', $keyword)
                    ->orWhere('prefix', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    public function executeKeyDataForTypeDesignFilter($query)
    {
        if ($this->keyword) {
            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('name', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {
            $query->whereDate('created_at', '>=', $this->start_date)
                  ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }


    //execute filter for key data Location Type
    public function executeLocationTypeFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('location_type_name', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for key data Location
    public function executeLocationFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('location_name', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for product
    public function executeProductPurchaseReturnFilter($query)
    {

        if ($this->keyword) {

            $keyword = "%{$this->keyword}%";

            $query->where(function ($q) use ($keyword) {
                $q->where('remark', 'like', $keyword)
                    ->orWhere('purchase_return_number', 'like', $keyword)
                    ->orWhereHas('purchase', function ($query) use ($keyword){
                        $query->where('invoice_number', 'like', $keyword);
                    });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //product list
    public function executeProductFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('code', 'like', $keyword)
                    ->orwhere('name', 'like', $keyword)
                    ->orWhereHas('brand', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })->orWhereHas('design', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })->orWhereHas('category', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })->orWhereHas('productModel', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })->orWhereHas('type', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    });
            });
        }

        return $query;
    }

    //product transfer
    public function executeProductTransferFilter($query, $limitQty = false)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = '%' . $this->keyword . '%';

                $q->where('transfer_inv_code', 'like',  $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        });
        return $query;
    }

    //ProductReceiveFilter
    public function executeProductReceiveFilter($query, $limitQty = false)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = '%' . $this->keyword . '%';

                $q->where('transfer_inv_code', 'like',  $keyword);
            });
        }

        // $query->when($limitQty, function ($query) {

        //     $query->where('quantity', '>', 0);
        // })
        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        });
        return $query;
    }

     //execute filter for product  order request
    public function executeProductOrderRequestFilter($query, $limitQty = false)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = '%' . $this->keyword . '%';

                $q->where('request_inv_code', 'like',  $keyword);
            });
        }

        // $query->when($this->start_date && $this->end_date, function ($query) {

        //     $query->whereDate('created_at', '>=', $this->start_date)
        //         ->whereDate('created_at', '<=', $this->end_date);
        // });
        return $query;
    }

    //execute filter for product price change histories
    public function executeProductPriceChangeHistory($query, $limitQty = false)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', $keyword);
                })->orWhereHas('product', function ($query) use ($keyword) {
                    $query->where('code', 'like', $keyword)
                            ->orWhere('name', 'like', $keyword);
                });
            });
        }

        $query->when($limitQty, function ($query) {

            $query->where('quantity', '>', 0);
        })->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        });

        return $query;
    }

    //execute filter for order
    public function executeOrderFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('order_number', 'like', $keyword)
                    ->orWhereHas('customer', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for purchase
    public function executePurchaseFilter($query)
    {
        if ($this->keyword) {
            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('invoice_number', 'like', $keyword)
                    ->orWhereHas('supplier', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    })->orWhere('action_type', 'like', $keyword)
                    ->orWhere('total_quantity', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('action_date', '>=', $this->start_date)
                ->whereDate('action_date', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }


    //execute filter for supplier
    public function executeSupplierFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('name', 'like', $keyword)
                    ->orWhere('user_number', 'like', $keyword)
                    ->orWhere('phone', 'like', $keyword)
                    ->orWhere('contact_name', 'like', $keyword)
                    ->orWhere('contact_phone', 'like', $keyword)
                    ->orWhere('address', 'like', $keyword)
                    ->orWhere('contact_position', 'like', $keyword)
                    ->orWhereHas('city', function ($query) use ($keyword) {

                        $query->where('name', 'like', $keyword);
                    })
                    ->orWhereHas('country', function ($query) use ($keyword) {

                        $query->where('name', 'like', $keyword);
                    });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for customer
    public function executeCustomerFilter($query)
    {

        if ($this->keyword) {

            $keyword = "%{$this->keyword}%";

            $query->where(function ($q) use ($keyword) {
                $q->where('user_number', 'like', $keyword)
                    ->orWhere('name', 'like', $keyword)
                    ->orWhere('phone', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for sale
    public function executeSaleFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('invoice_number', 'like', $keyword)
                    ->orWhere('action_type', 'like', $keyword)
                    ->orWhereHas('saleableBy', function ($query) use ($keyword) {

                        $query->where('name', 'like', $keyword)
                            ->orWhere('user_number', 'like', $keyword)
                            ->orWhere('phone', 'like', $keyword);
                    });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('action_date', '>=', $this->start_date)
                ->whereDate('action_date', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for sale return
    public function executeSaleReturnFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->whereHas('sale', function($query) use ($keyword) {
                    $query->where('invoice_number', 'like', $keyword);
                })
                    ->orWhere('return_type', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('return_date', '>=', $this->start_date)
                ->whereDate('return_date', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for payment
    public function executePaymentFilter($query)
    {
        // Keyword filter
        if ($this->keyword) {
            $keyword = "%{$this->keyword}%";

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('paymentable', function ($query) use ($keyword) {
                    $query->where('invoice_number', 'like', $keyword);
                });
            });
        }

        // Ensure only valid relationships are returned
        $query->whereHas('paymentable'); // Ensures no null relationships are included

        // Ordering
        $query->orderByDesc('id');

        return $query;
    }

    //execute filter for delivery
    public function executeDeliveryFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {

                $keyword = "%{$this->keyword}%";

                // $q->WhereHas('sale', function ($query) use ($keyword) {
                //     $query->where('invoice_number', 'like', $keyword)
                //         ->orWhereHas('saleableBy', function ($query) use ($keyword) {
                //             $query->where('name', 'like', $keyword)
                //                 ->orWhere('user_number', 'like', $keyword);
                //         })->orWhereHas('division', function ($query) use ($keyword) {
                //             $query->where('name', 'like', $keyword);
                //         })->orWhereHas('township', function ($query) use ($keyword) {
                //             $query->where('name', 'like', $keyword);
                //         });
                // })->orWhere('status', 'like', $keyword);

                $q->WhereHas('sale', function ($query) use ($keyword) {
                    $query->where('invoice_number', 'like', $keyword)
                        ->orWhereHas('saleableBy', function ($query) use ($keyword) {
                            $query->where('name', 'like', $keyword)
                                ->orWhere('user_number', 'like', $keyword);
                        });
                })->orWhere('status', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for damage
    public function executeDamageFilter($query)
    {
        // if ($this->keyword) {

        //     $query->where(function ($query) {

        //         $keyword = "%{$this->keyword}%";

        //         $query->whereHas('productable.product', function ($query) use ($keyword) {
        //             $query->where('name', 'like', '%' . $keyword . '%');
        //         })
        //             ->orWhere('remark', 'like', $keyword)
        //             ->orWhereHas('user', function ($query) use ($keyword) {
        //                 $query->where('name', 'like', $keyword);
        //             })->orWhereHas('productable', function ($query) use ($keyword) {
        //                 $query->whereHas('product', function ($query) use ($keyword) {
        //                     $query->where('name', 'like', $keyword);
        //                 });
        //             });
        //     });
        // }

        // $query->when($this->start_date && $this->end_date, function ($query) {

        //     $query->whereDate('damage_date', '>=', $this->start_date)
        //         ->whereDate('damage_date', '<=', $this->end_date);
        // })->orderByDesc('id');

        // return $query;

        if ($this->keyword) {

            $keyword = "%{$this->keyword}%";

            $query->where(function ($q) use ($keyword) {
                $q->where('remark', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for product
    public function executeRoleFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('name', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for promotion
    public function executePromotionFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('title', 'like', $keyword)
                    ->orWhere('code', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //execute filter for stock adjustment
    public function executeStockAdjustmentFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('remark', 'like', $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('adjustment_date', '>=', $this->start_date)
                ->whereDate('adjustment_date', '<=', $this->end_date);
        });

        return $query;
    }

    public function executeKeyDataFilter($query)
    {
        $query->where(function ($q) {
            $keyword = "%{$this->keyword}%";

            $q->where('name', 'like', $keyword);
        });

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    public function executeCOAFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->orWhereHas('businessType', function ($query) use ($keyword) {
                    $query->where('name', 'like', $keyword);
                })->orWhereHas('account', function ($query) use ($keyword) {
                    $query->where('name', 'like', $keyword);
                });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {
            $query->whereBetween('created_at', [$this->start_date, $this->end_date] );
        })->orderByDesc('id');
        return $query;
    }

    public function executeCOAAccountFilter($query)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('name', 'like', $keyword)
                    ->orWhereHas('accountType', function ($query) use ($keyword) {
                        $query->where('name', 'like', $keyword);
                    });
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    public function executeBankFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('bank_name', 'like', $keyword)
                    ->orWhere('account_name', 'like', $keyword)
                    ->orWhere('account_number', 'like', $keyword);
            });
        }

        return $query;
    }

    public function executebusinessTypeFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('name', 'like', $keyword);
            });
        }

        return $query;
    }

    public function accountTypeFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('name', 'like', $keyword);
            });
        }

        return $query;
    }

    public function executeAccountFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('name', 'like', $keyword)
                    ->orWhere('account_number', 'like', $keyword);
            });
        }

        return $query;
    }

    public function executePurchaseStockFilter($query)
    {
        if($this->keyword) {
            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->where('invoice_number', 'like', $keyword);
            });
        }
        return $query;
    }

    public function executeDistributionTransactionProductFilter($query)
    {
        if ($this->keyword) {
            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";

                $q->whereHas('product', function($query) use ($keyword) {
                        $query->where('name', 'like' , $keyword);
                    })->orWhereHas('location', function ($query) use ($keyword){
                        $query->where('location_name', 'like', $keyword);
                    });
            });
        }

        return $query;
    }

    //product return
    public function executeProductReturnRestoreFilter($query, $limitQty = false)
    {

        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = '%' . $this->keyword . '%';

                $q->where('return_inv_code', 'like',  $keyword);
            });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
        });
        return $query;
    }

    //pos
    public function executePOSFilter($query)
    {
        if ($this->keyword) {
            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('order_number', 'like', $keyword)
                    ->orWhereHas('shopper', function($query) use ($keyword) {
                        $query->where('name', 'like' , $keyword)
                            ->orWhere('code', 'like', $keyword);
                    })
                    ->orWhereHas('pointOfSaleProducts', function($query) use ($keyword) {
                        $query->whereRaw("JSON_UNQUOTE(imei) LIKE ?", [$keyword]);
                    });
                });
        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('action_date', '>=', $this->start_date)
                ->whereDate('action_date', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    //pos-return
    public function executePOSReturnFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                $q->where('remark', 'like', $keyword)
                  ->orWhere('pos_return_id', 'like', $keyword)
                    ->orWhereHas('pointOfSale', function($query) use ($keyword) {
                    $query->where('order_number', 'like' , $keyword);
                });
            });

        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('action_date', '>=', $this->start_date)
                ->whereDate('action_date', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }

    ///sc
    public function executeSaleConsultantFilter($query)
    {
        if ($this->keyword) {

            $query->where(function ($q) {
                $keyword = "%{$this->keyword}%";
                    $q->where('name', 'like', $keyword);
            });

        }

        $query->when($this->start_date && $this->end_date, function ($query) {

            $query->whereDate('action_date', '>=', $this->start_date)
                ->whereDate('action_date', '<=', $this->end_date);
        })->orderByDesc('id');

        return $query;
    }
}
