<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Product Custom Status Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for product custom status services such
    |
    */

    'productLocationStatus' => [
        'store' => 'Store',
        'wholestatus' => 'Wholesale',
        'retail' => 'Retail'
    ],

    // when store send product to retail and wholesale
    // can make by store
    'productTranStatus' => [
        'pending' => 'Pending',
        'active' => 'Active',
    ],

    // Product Transfer Types
    'productTransferType' => [
        'po_transfer' => 'PO Transfer',
        'new_transfer' => 'New Transfer',
        'return' => 'Return',
    ],

     // Product Request Types
     'productRequestType' => [
        'po_request' => 'PO Request',
        'new_request' => 'New Request',
        'return' => 'Return',
    ],
    // Product Transfer Types
    'status' => [
        'po_transfer' => 'PO Transfer',
        'new_transfer' => 'New Transfer',
    ],

];
