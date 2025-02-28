<div class="fixed animate__animated animate__fadeInLeft  top-0 left-0 z-50  ">
    <div id="sidebar-btn"
        class="sidebar relative   overflow-y-auto  scrollbar scrollbar-w-[4px] scrollbar-h-1 scrollbar-thumb-primary scrollbar-track-gray-100 hidden  md:block  font-poppins  w-[250px] 2xl:w-[300px] h-screen  bg-white ">
        {{-- close btn start  --}}

        <i class="fa-solid fa-xmark absolute top-4 cursor-pointer text-lg right-4 md:hidden " id="close-btn"></i>

        {{-- close btn end --}}

        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/kto_logo.png') }}" class="mx-auto" style="height: 180px; width:180px;"
                alt="">
        </a>

        <div class="ml-[2px] my-[12px] pr-5 flex flex-col gap-5">

            @if (auth()->user()->hasPermissions('dashboard'))
                <div class="flex ml-3 items-center cursor-pointer hover:text-transparent hover:bg-clip-text hover:bg-gradient-to-r hover:from-primary hover:via-secondary hover:to-thirdy "
                    style="">

                    <i class="fa-solid fa-gauge-high w-10 text-black opacity-70"></i>
                    <a href="{{ route('dashboard') }}">
                        <h1 class="text-[15px] ">Dashboard</h1>
                    </a>
                </div>
            @endif

            {{-- Cashbook start --}}
            @if (auth()->user()->hasPermissions('coa-list') ||
                    auth()->user()->hasPermissions('cashbook-settings-list') ||
                    auth()->user()->hasPermissions('business-type-list') ||
                    auth()->user()->hasPermissions('account-type-list') ||
                    auth()->user()->hasPermissions('account-list') ||
                    auth()->user()->hasPermissions('bank-list') ||
                    auth()->user()->hasPermissions('income-list') ||
                    auth()->user()->hasPermissions('expense-list') ||
                    auth()->user()->hasPermissions('other-assets-list'))
                <div>
                    <x-sidebar-main-tag dropDownId="219" class="fa-solid fa-book" text="Cashbook" />

                    <ul id="dropdown-219" class="dropDown-content pt-2 ml-3  hidden   ">

                        {{-- coa start   --}}
                        @if (auth()->user()->hasPermissions('coa-list'))
                            <x-sidebar-tag class="fa-solid fa-book-open" route="{{ route('coa-list') }}"
                                text="Tri Balance" />
                        @endif
                        {{-- Settings start  --}}
                        {{-- @if (auth()->user()->hasPermissions('profit-and-loss'))
                            <x-sidebar-tag class="fa-solid fa-chart-line" route="{{ route('pl-list') }}"
                                text=" Profit and Loss" />
                        @endif --}}
                        {{-- Business Type start  --}}
                        @if (auth()->user()->hasPermissions('business-type-list'))
                            <x-sidebar-tag class="fa-solid fa-business-time" route="{{ route('business-type-list') }}"
                                text=" Business Types" />
                        @endif
                        {{-- Account Type start  --}}
                        @if (auth()->user()->hasPermissions('account-type-list'))
                            <x-sidebar-tag class="fa-solid fa-filter-circle-dollar"
                                route="{{ route('account-type-list') }}" text="Account Types" />
                        @endif
                        {{-- Account start  --}}
                        @if (auth()->user()->hasPermissions('account-list'))
                            <x-sidebar-tag class="fa-solid fa-wallet" route="{{ route('account-list') }}"
                                text="Accounts Name" />
                        @endif
                        {{-- bank start   --}}
                        @if (auth()->user()->hasPermissions('bank-list'))
                            <x-sidebar-tag class="fa-solid fa-business-time" route="{{ route('bank') }}"
                                text="Banks" />
                        @endif
                        {{-- Icome start  --}}
                        @if (auth()->user()->hasPermissions('income-list'))
                            <x-sidebar-tag class="fa-solid fa-money-check" route="{{ route('income-list') }}"
                                text="Income" />
                        @endif
                        {{-- Expense start  --}}
                        @if (auth()->user()->hasPermissions('expense-list'))
                            <x-sidebar-tag class="fa-solid fa-hand-holding-dollar" route="{{ route('expense-list') }}"
                                text="Expense" />
                        @endif
                        {{-- Other start  --}}
                        @if (auth()->user()->hasPermissions('other-assets-list'))
                            <x-sidebar-tag class="fa-solid fa-rectangle-list" route="{{ route('others-list') }}"
                                text="Others" />
                        @endif
                    </ul>
                </div>
            @endif
            {{-- Cashbook End --}}

            {{-- Product Setting start  --}}
            @if (auth()->user()->hasPermissions('brand-list') ||
                    auth()->user()->hasPermissions('category-list') ||
                    auth()->user()->hasPermissions('model-list') ||
                    auth()->user()->hasPermissions('type-list') ||
                    auth()->user()->hasPermissions('design-list'))

                <div>
                    <x-sidebar-main-tag dropDownId="22" class="fa-solid fa-screwdriver-wrench"
                        text="Product Settings" />

                    <ul id="dropdown-22" class="dropDown-content pt-2 ml-3  hidden   ">

                        {{-- category start  --}}
                        @if (auth()->user()->hasPermissions('category-list'))
                            <x-sidebar-tag class="fa-solid fa-network-wired" route="{{ route('category') }}"
                                text="Categories" />
                        @endif

                        {{-- brand start  --}}
                        @if (auth()->user()->hasPermissions('brand-list'))
                            <x-sidebar-tag class="fa-solid fa-box-open" route="{{ route('brand') }}" text="Brands" />
                        @endif


                        {{-- product model start  --}}
                        @if (auth()->user()->hasPermissions('model-list'))
                            <x-sidebar-tag class="fa-solid fa-box" route="{{ route('product-model') }}"
                                text="Models" />
                        @endif

                        {{-- type start  --}}
                        @if (auth()->user()->hasPermissions('type-list'))
                            <x-sidebar-tag class="fa-solid fa-table-cells" route="{{ route('type') }}"
                                text="Types" />
                        @endif

                        {{-- design start  --}}
                        @if (auth()->user()->hasPermissions('design-list'))
                            <x-sidebar-tag class="fa-solid fa-object-group" route="{{ route('design') }}"
                                text="Designs" />
                        @endif

                    </ul>
                </div>
            @endif
            {{-- Setting end  --}}

            {{-- product  --}}
            @if (auth()->user()->hasPermissions('product-list') ||
                    auth()->user()->hasPermissions('product-barcode-list') ||
                    auth()->user()->hasPermissions('product-create') ||
                    auth()->user()->hasPermissions('product-adjustment-list') ||
                    auth()->user()->hasPermissions('product-damage-list') ||
                    auth()->user()->hasPermissions('product-price-history-list') ||
                    auth()->user()->hasPermissions('product-prefix-code'))
                <div class="">
                    <x-sidebar-main-tag dropDownId="6" class="fa-solid fa-layer-group" text="Products" />
                    <ul id="dropdown-6" class=" pt-2 ml-3  hidden   ">
                        {{-- product list --}}
                        @if (auth()->user()->hasPermissions('product-list'))
                            <x-sidebar-tag class="fa-solid fa-list-check" route="{{ route('product-list') }}"
                                text="View" />
                        @endif

                        {{-- product create --}}
                        @if (auth()->user()->hasPermissions('product-create'))
                            <x-sidebar-tag class="fa-solid fa-circle-plus" route="{{ route('product-create') }}"
                                text="Create" />
                                <x-sidebar-tag class="fa-solid fa-circle-plus" route="{{ route('build-new-product') }}"
                                text="Build New Product" />
                        @endif

                        {{-- product barcode --}}
                        @if (auth()->user()->hasPermissions('product-barcode-list'))
                            <x-sidebar-tag class="fa-solid fa-barcode" route="{{ route('get-product-barcodes') }}"
                                text="Barcodes List" />
                        @endif

                        {{-- product stock --}}
                        @if (auth()->user()->hasPermissions('product-adjustment-list'))
                            <x-sidebar-tag class="fa-solid fa-scale-balanced" route="{{ route('product-stock') }}"
                                text="Stock Adjustment" />
                        @endif

                        {{-- product damage --}}
                        @if (auth()->user()->hasPermissions('product-damage-list'))
                            <x-sidebar-tag class="fa-solid  fa-bug " route="{{ route('damage') }}"
                                text="Stock Damage" />
                        @endif

                        {{-- product price history --}}
                        @if (auth()->user()->hasPermissions('product-price-history-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group " route="{{ route('price-history') }}"
                                text="Price
                        Change" />
                        @endif

                        {{-- product prefix code --}}
                        @if (auth()->user()->hasPermissions('product-prefix-code'))
                            <x-sidebar-tag class="fa-solid  fa-hashtag" route="{{ route('product-prefix') }}"
                                text="Prefixed Code" />
                        @endif
                    </ul>
                </div>
            @endif

            {{-- supplier --}}
            @if (auth()->user()->hasPermissions('supplier-list') || auth()->user()->hasPermissions('supplier-create'))
                <div>
                    <x-sidebar-main-tag dropDownId="7" class="fa-solid fa-people-carry-box" text="Suppliers" />
                    <ul id="dropdown-7" class=" pt-2  ml-3 hidden ">

                        {{-- supplier list --}}
                        @if (auth()->user()->hasPermissions('supplier-list'))
                            <x-sidebar-tag class="fa-solid fa-list-check" route="{{ route('supplier-list') }}"
                                text="View" />
                        @endif

                        {{-- supplier create --}}
                        @if (auth()->user()->hasPermissions('supplier-create'))
                            <x-sidebar-tag class="fa-solid  fa-circle-plus" route="{{ route('supplier-create') }}"
                                text="Create" />
                        @endif
                    </ul>
                </div>
            @endif

            {{-- purchase --}}
            @if (auth()->user()->hasPermissions('purchase-list') ||
                    auth()->user()->hasPermissions('purchase-create') ||
                    auth()->user()->hasPermissions('return-purchase-list') ||
                    auth()->user()->hasPermissions('purchase-payment-list'))
                <div>
                    <x-sidebar-main-tag dropDownId="8" class="fa-solid fa-cart-shopping" text="Purchases" />

                    <ul id="dropdown-8" class=" pt-2 ml-3  hidden ">

                        {{-- purchase list --}}
                        @if (auth()->user()->hasPermissions('purchase-list'))
                            <x-sidebar-tag class="fa-solid fa-list-check" route="{{ route('purchase') }}"
                                text="View" />
                        @endif

                        {{-- purchase create --}}
                        @if (auth()->user()->hasPermissions('purchase-create'))
                            <x-sidebar-tag class="fa-solid fa-circle-plus"
                                route="{{ route('purchase-create-first') }}" text="Create" />
                        @endif

                        {{-- purchase return --}}
                        @if (auth()->user()->hasPermissions('return-purchase-list'))
                            <x-sidebar-tag class="fa-solid fa-arrows-rotate" route="{{ route('purchase-return') }}"
                                text="Purchase
                                Return" />
                        @endif

                        {{-- purchase payment list --}}
                        @if (auth()->user()->hasPermissions('purchase-payment-list'))
                            <x-sidebar-tag class="fa-solid fa-coins" route="{{ route('purchase-payment') }}"
                                text="Payables" />
                        @endif
                    </ul>
                </div>
            @endif

            {{-- Inventory  --}}
            @if (auth()->user()->hasPermissions('product-purchase-stock-list') ||
                    auth()->user()->hasPermissions('stock-check-list') ||
                    auth()->user()->hasPermissions('product-transfer-list') ||
                    auth()->user()->hasPermissions('product-receive-list') ||
                    auth()->user()->hasPermissions('product-request-list') ||
                    auth()->user()->hasPermissions('po-transfer-list') ||
                    auth()->user()->hasPermissions('product-return-list') ||
                    auth()->user()->hasPermissions('restore-list'))
                <div class="">
                    <x-sidebar-main-tag dropDownId="20" class="fa-solid fa-warehouse" text="Inventory" />
                    <ul id="dropdown-20" class=" pt-2 ml-3 hidden">

                        {{-- add purchase stock --}}
                        @if (auth()->user()->hasPermissions('product-purchase-stock-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group "
                                route="{{ route('product-purchase-stock-list') }}" text="Add Purchase Stock" />
                        @endif

                        {{-- stocks check --}}
                        @if (auth()->user()->hasPermissions('stock-check-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group "
                                route="{{ route('stock-check-list') }}" text="Stocks Check" />
                        @endif

                        {{-- IMEI History --}}
                        <x-sidebar-tag class="fa-solid  fa fa-layer-group" route="{{ route('imei-history-search') }}"
                            text="IMEI History" />

                        {{-- product transfer --}}
                        @if (auth()->user()->hasPermissions('product-transfer-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group "
                                route="{{ route('product-transfer') }}" text="Stock Transfers" />
                        @endif

                        {{-- product receive --}}
                        @if (auth()->user()->hasPermissions('product-receive-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group "
                                route="{{ route('product-receive') }}" text="Stock Receive" />
                        @endif

                        {{-- product request --}}
                        @if (auth()->user()->hasPermissions('product-request-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group "
                                route="{{ route('product-request') }}" text="PO Request" />
                        @endif

                        {{-- product po transfer --}}
                        @if (auth()->user()->hasPermissions('po-transfer-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group " route="{{ route('po-transfer') }}"
                                text="PO Transfers" />
                        @endif


                        {{-- product return --}}
                        @if (auth()->user()->hasPermissions('product-return-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group " route="{{ route('product-return') }}"
                                text=" Stock Return" />
                        @endif

                        {{-- product retore --}}
                        @if (auth()->user()->hasPermissions('restore-list'))
                            <x-sidebar-tag class="fa-solid  fa fa-layer-group "
                                route="{{ route('product-restore') }}" text=" Stock Restore" />
                        @endif
                    </ul>
                </div>
            @endif



            {{-- pos --}}
            @if (auth()->user()->hasPermissions('pos-list') ||
                    auth()->user()->hasPermissions('pos-create') ||
                    auth()->user()->hasPermissions('pos-return-list') ||
                    auth()->user()->hasPermissions('pos-receivable-list'))
                <div>
                    <x-sidebar-main-tag dropDownId="12" class="fas fa-money-bill-wave" text="Point of Sales" />

                    <ul id="dropdown-12" class=" pt-2 ml-3  hidden">

                        {{-- pos list --}}
                        @if (auth()->user()->hasPermissions('pos-list'))
                            <x-sidebar-tag class="fa-solid  fa-list-check" route="{{ route('pos-list') }}"
                                text="View" />
                        @endif

                        {{-- pos create --}}
                        @if (auth()->user()->hasPermissions('pos-create'))
                            <x-sidebar-tag class="fa-solid  fa-circle-plus" route="{{ route('pos-create') }}"
                                text="Create" />
                        @endif

                        {{-- pos return list --}}
                        @if (auth()->user()->hasPermissions('pos-return-list'))
                            <x-sidebar-tag class="fa-solid fa-arrows-rotate" route="{{ route('pos-return-list') }}"
                                text="Return" />
                        @endif

                        {{-- pos receivable list --}}
                        @if (auth()->user()->hasPermissions('pos-receivable-list'))
                            <x-sidebar-tag class="fa-solid fa-coins" route="{{ route('pos-cashback-list') }}"
                                text="Receivables" />
                        @endif
                    </ul>
                </div>
            @endif

            {{-- sale consultants --}}
            @if (auth()->user()->hasPermissions('sc-list') || auth()->user()->hasPermissions('sc-create'))

                <div>
                    <x-sidebar-main-tag dropDownId="17" class="fas fa-user-check" text="Sale Staffs" />

                    <ul id="dropdown-17" class=" pt-2 ml-3  hidden">

                        {{-- sc list --}}
                        @if (auth()->user()->hasPermissions('sc-list'))
                            <x-sidebar-tag class="fa-solid  fa-list-check" route="{{ route('sc-list') }}"
                                text="View" />
                        @endif

                        {{-- pos create --}}
                        @if (auth()->user()->hasPermissions('sc-create'))
                            <x-sidebar-tag class="fa-solid  fa-circle-plus" route="{{ route('sc-create') }}"
                                text="Create" />
                        @endif


                    </ul>
                </div>
            @endif

            {{-- promotion  --}}
            @if (auth()->user()->hasPermissions('promotion-list') || auth()->user()->hasPermissions('promotion-create'))

                <div>
                    <x-sidebar-main-tag dropDownId="15" class="fa-solid fa-bullhorn" text="Promotions" />
                    <ul id="dropdown-15" class=" pt-2 ml-3  hidden ">

                        {{-- promotion --}}
                        @if (auth()->user()->hasPermissions('promotion-list'))
                            <x-sidebar-tag class="fa-solid  fa-list-check" route="{{ route('promotion') }}"
                                text="View" />
                        @endif

                        {{-- promotion create --}}
                        @if (auth()->user()->hasPermissions('promotion-create'))
                            {{-- @if (!checkPromotionActive()) --}}
                            <x-sidebar-tag class="fa-solid fa-circle-plus"
                                route="{{ route('promotion-create-first') }}" text="Create" />
                            {{-- @endif --}}
                        @endif
                    </ul>
                </div>

            @endif

            {{-- user settings start  --}}
            @if (auth()->user()->hasPermissions('role-list') || auth()->user()->hasPermissions('user-list'))

                <div>
                    <x-sidebar-main-tag dropDownId="16" class="fa-solid fa-gear" text="User Settings" />

                    <ul id="dropdown-16" class="dropDown-content pt-2 ml-3 hidden   ">
                        {{-- Location type start  --}}
                        {{-- @if (auth()->user()->hasPermissions('location-type-list'))
                    <x-sidebar-tag class="fa-solid  fa-map-location-dot" route="{{ route('location-type') }}" text="Location Type" />
                    @endif --}}

                        {{-- Permission in location start  --}}
                        @if (auth()->user()->hasPermissions('location-list'))
                            <x-sidebar-tag class="fa-solid  fa-map-location-dot" route="{{ route('location') }}"
                                text="Location" />
                        @endif

                        {{-- role start  --}}
                        @if (auth()->user()->hasPermissions('role-list'))
                            <x-sidebar-tag class="fa-solid  fa-circle-user" route="{{ route('role') }}"
                                text="Roles" />
                        @endif

                        {{-- user start  --}}
                        @if (auth()->user()->hasPermissions('user-list'))
                            <x-sidebar-tag class="fa-solid  fa-user" route="{{ route('user') }}" text="Users" />
                        @endif

                        {{-- position start  --}}

                        {{-- <x-sidebar-tag class="fa-solid  fa-clipboard-user" route="{{ route('position') }}" text="Positions" /> --}}

                        {{-- staff start  --}}

                        @if (env('APP_NAME') === 'FastMove')
                            <x-sidebar-tag class="fa-solid fa-users" route="{{ route('company-settings-list') }}"
                                text="Company Settings" />
                        @endif
                        {{-- company start  --}}

                    </ul>
                </div>
            @endif

            {{-- user settings end  --}}

            {{-- file import settings start  --}}
            @if (env('APP_NAME') === 'FastMove')
                <div>
                    <x-sidebar-main-tag dropDownId="17" class="fa-solid fa-file-import" text="File Import" />

                    <ul id="dropdown-17" class="dropDown-content pt-2 ml-3 hidden   ">
                        {{-- role start  --}}

                        <x-sidebar-tag class="fa-solid  fa-users" route="{{ route('customer-import-upload') }}"
                            text="Customers" />


                        {{-- user start  --}}

                        <x-sidebar-tag class="fa-solid fa-layer-group" route="{{ route('product-import-upload') }}"
                            text="Products" />
                    </ul>
                </div>
            @endif
            {{-- file import settings end  --}}
            @if (auth()->user()->hasPermissions('product-report') ||
                    auth()->user()->hasPermissions('customer-report') ||
                    auth()->user()->hasPermissions('purchase-report') ||
                    auth()->user()->hasPermissions('purchase-return-report') ||
                    auth()->user()->hasPermissions('sale-report') ||
                    auth()->user()->hasPermissions('sale-payment-report') ||
                    auth()->user()->hasPermissions('sale-return-report') ||
                    auth()->user()->hasPermissions('cash-report') ||
                    auth()->user()->hasPermissions('bank-report'))
                <div
                    class="flex items-center ml-4 justify-between cursor-pointer hover:text-transparent hover:bg-clip-text hover:bg-gradient-to-r hover:from-primary hover:via-secondary hover:to-thirdy mr-5">
                    <div class="flex items-center  ">

                        <i class="fas fa-file-export w-9 text-sm text-black opacity-70"></i>
                        <a href="{{ route('report') }}">
                            <h1 class="text-[15px]">Reports</h1>
                        </a>
                    </div>

                </div>
            @endif

        </div>
    </div>
</div>
