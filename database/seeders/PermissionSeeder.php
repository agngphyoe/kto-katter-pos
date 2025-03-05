<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups = [
            [
                'name' => 'Dashboard',
                'permissions' => [
                    'dashboard',
                    'sale-dashboard',
                    'shop-dashboard',
                    'purchase-dashboard',
                    'payable-dashboard',
                    'product-quantity-dashboard',
                    'stock-dashboard'
                ]
            ],
            [
                'name' => 'Cashboook',
                'permissions' => [
                    'coa-list',
                ]
            ],
            [
                'name' => 'Business Type',
                'permissions' => [
                    'business-type-list',
                    'business-type-create',
                    'business-type-edit',
                    'business-type-delete',
                    'business-type-detail',
                    'business-type-export',
                    'business-type-print',
                ]
            ],
            [
                'name' => 'Account Type',
                'permissions' => [
                    'account-type-list',
                    'account-type-create',
                    'account-type-edit',
                    'account-type-delete',
                    'account-type-detail',
                    'account-type-export',
                    'account-type-print',
                ]
            ],
            [
                'name' => 'Account',
                'permissions' => [
                    'account-list',
                    'account-create',
                    'account-edit',
                    'account-delete',
                    'account-detail',
                    'account-export',
                    'account-print',
                ]
            ],
            [
                'name' => 'Bank',
                'permissions' => [
                    'bank-list',
                    'bank-create',
                    'bank-edit',
                    'bank-delete',
                    'bank-detail',
                    'bank-export',
                    'bank-print',
                ]
            ],
            [
                'name' => 'Income',
                'permissions' => [
                    'income-list',
                    'income-create',
                    'income-edit',
                    'income-delete',
                    'income-detail',
                    'income-export',
                    'income-print',
                ]
            ],
            [
                'name' => 'Expense',
                'permissions' => [
                    'expense-list',
                    'expense-create',
                    'expense-edit',
                    'expense-delete',
                    'expense-detail',
                    'expense-export',
                    'expense-print',
                ]
            ],
            // [
            //     'name' => 'Other Assets',
            //     'permissions' => [
            //         'other-assets-list',
            //         'other-assets-create',
            //         'other-assets-edit',
            //         'other-assets-delete',
            //         'other-assets-detail',
            //         'other-assets-export',
            //         'other-assets-print',
            //     ]
            // ],
            [
                'name' => 'Category',
                'permissions' => [
                    'category-list',
                    'category-create',
                    'category-edit',
                    'category-delete',
                    'category-detail',
                    'category-export',
                    'category-print'
                ]
            ],
            [
                'name' => 'Brand',
                'permissions' => [
                    'brand-list',
                    'brand-create',
                    'brand-edit',
                    'brand-delete',
                    'brand-detail',
                    'brand-export',
                    'brand-print'
                ]
            ],
            [
                'name' => 'Model',
                'permissions' => [
                    'model-list',
                    'model-create',
                    'model-edit',
                    'model-delete',
                    'model-detail',
                    'model-export',
                    'model-print'
                ]
            ],
            [
                'name' => 'Type',
                'permissions' => [
                    'type-list',
                    'type-create',
                    'type-edit',
                    'type-delete',
                    'type-detail',
                    'type-export',
                    'type-print'
                ]
            ],
            [
                'name' => 'Design',
                'permissions' => [
                    'design-list',
                    'design-create',
                    'design-edit',
                    'design-delete',
                    'design-detail',
                    'design-export',
                    'design-print',
                ]
            ],
            [
                'name' => 'Product',
                'permissions' => [
                    'product-list',
                    'product-create',
                    'product-edit',
                    'product-delete',
                    'product-detail',
                    'product-export',
                    'product-print',
                    'export-product-report',
                    'product-barcode-list',
                    'product-barcode-print',
                ]
            ],

            [
                'name' => 'Stock Adjustment',
                'permissions' => [
                    'product-adjustment-list',
                    'product-adjustment-create',
                    'product-adjustment-edit',
                    'product-adjustment-delete',
                    'product-adjustment-detail',
                    'product-adjustment-export',
                ]
            ],

            [
                'name' => 'Stock Damage',
                'permissions' => [
                    'product-damage-list',
                    'product-damage-create',
                    'product-damage-edit',
                    'product-damage-delete',
                    'product-damage-detail',
                    'product-damage-export',
                ]
            ],

            [
                'name' => 'Price Histories',
                'permissions' => [                   
                    'product-price-history-list',
                    'product-price-history-create',
                ]
            ],

            [
                'name' => 'Prefix Code',
                'permissions' => [                  
                    'product-prefix-code',
                ]
            ],

            [
                'name' => 'Add Purchase Stock',
                'permissions' => [
                    'product-purchase-stock-list',
                    'product-purchase-stock-add',
                    'product-purchase-stock-histories',
                ]
            ],

            [
                'name' => 'Stocks Check',
                'permissions' => [
                    'stock-check-list',
                ]
            ],

            [
                'name' => 'Stock Transfers',
                'permissions' => [
                    'product-transfer-list',
                    'product-transfer-create',
                    'product-transfer-edit',
                    'product-transfer-delete',
                    'product-transfer-detail',
                ]
            ],

            [
                'name' => 'Stock Receive',
                'permissions' => [
                    'product-receive-list',
                    'product-receive-edit',
                    'product-receive-delete',
                    'product-receive-detail',
                ]
            ],

            [
                'name' => 'PO Request',
                'permissions' => [
                    'product-request-list',
                    'product-request-create',
                    'product-request-edit',
                    'product-request-delete',
                    'product-request-detail',
                ]
            ],

            [
                'name' => 'PO Transfers',
                'permissions' => [
                    'po-transfer-list',
                    'po-transfer-create',
                    'po-transfer-edit',
                    'po-transfer-delete',
                    'po-transfer-detail',
                ]
            ],

            [
                'name' => 'Stock Return',
                'permissions' => [
                    'product-return-list',
                    'product-return-create',
                    'product-return-edit',
                    'product-return-delete',
                    'product-return-detail',
                ]
            ],

            [
                'name' => ' Stock Restore',
                'permissions' => [
                    'restore-list',
                    'restore-edit',
                    'restore-detail',
                ]
            ],
            
            [
                'name' => 'Supplier',
                'permissions' => [
                    'supplier-list',
                    'supplier-create',
                    'supplier-edit',
                    'supplier-delete',
                    'supplier-detail',
                    'supplier-export',
                    'supplier-print',
                ]
            ],

            [
                'name' => 'Purchase',
                'permissions' => [
                    'purchase-list',
                    'purchase-create',
                    'purchase-edit',
                    'purchase-delete',
                    'purchase-detail',
                    'purchase-export',
                    'purchase-print',
                ]
            ],
            [
                'name' => 'Purchase Return',
                'permissions' => [
                    'return-purchase-list',
                    'return-purchase-create',
                    'return-purchase-edit',
                    'return-purchase-delete',
                    'return-purchase-detail',
                    'return-purchase-export',
                    'return-purchase-print',
                ]
            ],
            [
                'name' => 'Payables',
                'permissions' => [
                    'purchase-payment-list',
                    'purchase-payment-create',
                    'payment-edit',
                    'payment-delete',
                    'payment-detail',
                    'payment-export',
                    'payment-print',
                ]
            ],

            [
                'name' => 'Customer',
                'permissions' => [
                    'customer-list',
                    'customer-create',
                    'customer-edit',
                    'customer-delete',
                    'customer-detail',
                    'customer-export',
                    'customer-print',
                    'customer-sale-list',
                    'export-customer-report',
                ]
            ],

            [
                'name' => 'POS',
                'permissions' => [
                    'pos-list',
                    'pos-create',
                    'pos-delete',
                    'pos-details',
                    'pos-return-list',
                    'pos-return-create',
                    'pos-export',
                    'pos-print'
                ]
            ],

            [
                'name' => 'Sale Consultant',
                'permissions' => [
                    'sc-list',
                    'sc-create',
                    'sc-edit',
                    'sc-delete',
                    'sc-details',
                    'sc-export',
                ]
            ],

            [
                'name' => 'Promotion',
                'permissions' => [
                    'promotion-list',
                    'promotion-create',
                    'promotion-edit',
                    'promotion-delete',
                    'promotion-detail',
                    'promotion-export',
                    'promotion-print'
                ]
            ],

            [
                'name' => 'Location',
                'permissions' => [
                    'location-list',
                    'location-create',
                    'location-edit',
                    'location-delete',
                    'location-detail',
                    'location-export',
                    'location-print'
                ]
            ],

            [
                'name' => 'Role',
                'permissions' => [
                    'role-list',
                    'role-create',
                    'role-edit',
                    'role-delete',
                    'role-detail',
                    'role-export',
                    'role-print'
                ]
            ],

            [
                'name' => 'User',
                'permissions' => [
                    'user-list',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'user-detail',
                    'user-export',
                    'user-print',
                    'change-status'
                ]
            ],
            [
                'name' => 'Reports',
                'permissions' => [
                    'product-report',
                    'customer-report',
                    'purchase-report',
                    'purchase-return-report',
                    'sale-report',                 
                    'sale-return-report',
                    'payable-report',
                    'bank-report',
                ]
            ]

            // add more groups here
        ];

        foreach ($permissionGroups as $group) {

            $newGroup = PermissionGroup::firstOrCreate([
                'name' => $group['name'],
            ]);

            foreach ($group['permissions'] as $permissionName) {

                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                    'permission_group_id' => $newGroup->id,
                ]);
            }
        }
    }
}
