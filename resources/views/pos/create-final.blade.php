@extends('layouts.master-without-nav')
@section('title', 'POS Receipt')
@section('css')

@endsection
@section('content')
<section class="create-third">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Payment',
    'subTitle' => 'Fill Payment Data',
    ])
    {{-- nav end  --}}

    <x-just-modal modal="myShopperModal" class="lg:w-[600px]" cancelBtnId="shopper_cancel_btn" doneBtnId="customer_done_btn">
        <form action="" method="post">
            
            <div class="flex md:flex-row justify-center flex-col gap-5">
                <div>
                    <label for="c_name" class=" block mb-2 text-paraColor font-semibold text-sm">Name</label>
                    <input type="text" name="name" id="shopper_name" placeholder="Enter Name" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" required>
                    <div><span id="name_error_msg" style="color: red"></span></div>
                    @error('name')
                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class=" block mb-2 text-paraColor font-semibold text-sm">Phone</label>
                    <input type="number" name="phone" id="shopper_phone" placeholder="Enter Phone" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" required>
                    <div><span id="phone_error_msg" style="color: red"></span></div>
                    @error('phone')
                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <div class="flex md:flex-row justify-center flex-col gap-5 mt-3">
                <div>
                    <label for="address" class=" block mb-2 text-paraColor font-semibold text-sm">Address</label>
                    <input type="text" name="address" id="shopper_address" placeholder="Address" class="outline w-[220px] outline-1 outline-primary px-4 py-2 rounded-2xl text-sm" required>
                    <div><span id="address_error_msg" style="color: red"></span></div>
                    @error('address')
                    <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                    @enderror
                </div>
            </div>
        </form>
    </x-just-modal>

    {{-- main start  --}}
    <div class="">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 md:gap-10 lg:mx-[30px] mx-[20px] my-[20px] lg:my-[20px]">
            {{-- payment start  --}}
            <div class="md:col-span-1 lg:col-span-4 mb-5 flex items-center justify-center">

                <form id="submitForm" action="{{ route('pos-store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="products" id="pos_order_products">
                    <input type="number" name="location_id" value="{{ $location_id }}" hidden>

                    <div class=" w-[360px]  ">
                        <div class="bg-white h-[800px] outline outline-1 outline-primary  relative  rounded-[20px]">
                            <div>
                                <h1 class="font-jakarta font-semibold text-noti text-center p-2">Payment</h1>
                            </div>
                            <div class="flex items-center absolute -left-2 -right-2  ">
                                <div class="w-4 h-4 bg-bgMain rounded-full border-r-2 border-r-primary border-t-primary">
                                </div>
                                <div class=" outline-1 outline-dashed  text-paraColor opacity-50 w-full"></div>
                                <div class="w-4 h-4 bg-bgMain rounded-full border border-l-primary"></div>

                            </div>
                            <div class="px-5 py-8 font-poppins">

                                <div class="mb-3 flex flex-col md:flex-row md:items-center md:justify-between">                               
                                    <div class="flex gap-5">                                     
                                        <select name="shopper_id" id="shopper_select" class="outline outline-1 mr-3 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full select2" required>
                                            <option value="" class="px-10" selected disabled>Select Shopper</option>
                                            @foreach ($shoppers as $shopper)
                                                <option value="{{ $shopper->id }}" {{ $shopper->name == 'POSCustomer' ? 'selected' : '' }}>{{ $shopper->name }}</option>
                                            @endforeach
                                            
                                        </select>
                                        @error('shopper_id')
                                        <p class="text-red-600 text-xs mt-1"></p>
                                        @enderror
                                        
                                        <div class=" md:block">
                                            <x-just-create-button modal="myShopperModal" />
                                        </div>
                                    </div>
                                </div>

                                    {{-- Discount Input --}}
                                    <div class="flex flex-col mb-2">
                                        <label for="discount_amount" class="mb-2 text-paraColor font-semibold text-sm ">Discount Amount (MMK)</label>
                                        <input type="number" name="discount_amount" id="discount_amount" class="outline outline-1  font-jakarta text-paraColor w-full  text-[16px] outline-primary px-8 py-2 rounded-full" value="0" required>
                                    </div>

                                    {{-- Paid Input --}}
                                    <div class="flex flex-col mt-0 mb-2">
                                        <label for="" class="mb-2 text-paraColor font-semibold text-sm ">Paid Amount</label>
                                        <input type="number" name="paid_amount" class="outline outline-1 text-sm font-jakarta text-paraColor w-full  text-[16px] outline-primary px-8 py-2 rounded-full" id="paid_amount_input" min="0" required />
                                        @error('paid_amount')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Bank Select --}}
                                    <div class="flex flex-col mt-0 mb-1">
                                        <label for="" class="mb-2 text-paraColor font-semibold text-sm ">Choose Payment</label>
                                        <select name="bank_id" id="" class="outline outline-1 mr-3 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full select2" required>
                                            
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                            @endforeach
                                            
                                        </select>
                                        @error('bank_id')
                                        <p class="text-red-600 text-xs mt-1"></p>
                                        @enderror
                                    </div>

                                    {{-- Sale Staff --}}
                                    <div class="flex flex-col mt-0 mb-1">
                                        <label for="" class="mb-2 text-paraColor font-semibold text-sm ">Sale Staff</label>
                                        <select name="sale_consultant_id" id="" class="outline outline-1 mr-3 font-jakarta text-paraColor  text-[16px] outline-paraColor px-14 py-2 rounded-full select2" required>
                                            <option value=""selected disabled>Choose Sale Staff</option>
                                            @foreach ($saleConsultants as $saleConsultant)
                                                <option value="{{ $saleConsultant->id }}">{{ $saleConsultant->name }}</option>
                                            @endforeach
                                            
                                        </select>
                                        @error('bank_id')
                                        <p class="text-red-600 text-xs mt-1"></p>
                                        @enderror
                                    </div>

                                    <input type="number" name="change_amount" id="change_amount_input" hidden>
                                    <div class="border-2 border-dashed my-4"></div>


                                <div class="bottom-1 right-5 left-5 absolute">                                  
                                    {{-- total quantity --}}
                                    <div class="flex items-center justify-between mb-5 text-sm">
                                        <h1 class="text-noti font-medium">Total Quantity</h1>
                                        <h1 class="text-paraColor font-medium" id="totalQuantity"></h1>
                                        <input type="hidden" name="total_quantity" id="totalQuantityInput">
                                    </div>

                                    {{-- Total Amount --}}
                                    <div class="flex items-center justify-between mb-3 text-sm">
                                        <h1 class="text-noti font-medium ">Total Amount</h1>
                                        <h1 class="text-paraColor font-medium"><span id="totalAmount"></span>
                                        </h1>
                                        <input type="hidden" name="total_amount" id="totalAmountInput">
                                    </div>

                                    {{-- Discount Amount  --}}
                                    <div class="flex items-center justify-between mb-5 text-sm">
                                        <h1 class="text-noti font-medium ">Discount Amount</h1>
                                        <h1 class="text-paraColor font-medium"><span id="discount_amount_label">0</span>
                                        </h1>
                                    </div>

                                    {{-- Balance Amount  --}}
                                    <div class="flex items-center justify-between mb-5 text-sm" id="cash_down">
                                        <h1 class="text-noti font-medium">Balance Amount</h1>
                                        <h1 class="text-paraColor font-medium"><span id="net_amount_label">0</span>
                                        </h1>
                                    </div>

                                    {{-- Paid Amount  --}}
                                    <div class="flex items-center justify-between mb-5 text-sm" id="cash_down">
                                        <h1 class="text-noti font-medium">Paid Amount</h1>
                                        <h1 class="text-paraColor font-medium"><span id="paid_amount_label">0</span>
                                        </h1>
                                    </div>

                                    {{-- Change Amount  --}}
                                    <div class="flex items-center justify-between mb-5 text-sm" id="cash_down">
                                        <h1 class="text-noti font-medium">Change Amount</h1>
                                        <h1 class="text-paraColor font-medium"><span id="change_amount_label">0</span>
                                        </h1>
                                    </div>

                                    <div class="text-center mt-4">
                                        <a href="{{ URL::previous() }}" type="button" class="bg-gray-300 text-white rounded-full w-52 text-lg font-semibold py-3">Back</a>
                                        <button id="submitButton" class="bg-noti text-white rounded-full w-52 text-lg font-semibold py-3 mt-4" type="submit" id="done">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            {{-- payment end --}}

        </div>
    </div>
    {{-- main end --}}

</section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        handleReload();
    });
</script>

<script>

    $(document).ready(function() {

        var items = JSON.parse(localStorage.getItem('selectedProductsForPOS')) || [];
        var totalQuantity = JSON.parse(localStorage.getItem('totalOrderQuantityForPOSOrder')) || [];
        var totalRetailPrice = JSON.parse(localStorage.getItem('totalAmountForPOSOrder')) || [];

        $('#totalAmount').text(Number(totalRetailPrice).toLocaleString());
        $('#totalAmountInput').val(totalRetailPrice);
        $('#net_amount_label').text(Number(totalRetailPrice).toLocaleString());
        $('#net_amount_input').val(totalRetailPrice);
        $('#totalQuantity').text(Number(totalQuantity).toLocaleString());
        $('#totalQuantityInput').val(totalQuantity);
    });
</script>

<script>
    $('#discount_amount').on('input', function() {
        const total_price = $('#totalAmountInput').val();
        
        const discount_amount = Number($(this).val());
        const formatted_discount_amount = discount_amount.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        $('#discount_amount_label').html(formatted_discount_amount);
        localStorage.setItem('discount_amount', discount_amount);

        var net_amount = total_price - discount_amount;
        const formatted_net_amount = net_amount.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        $('#net_amount_label').html(formatted_net_amount);
        localStorage.setItem('net_amount', net_amount);
    })

    $('#paid_amount_input').on('input', function() {
        const net_amount = JSON.parse(localStorage.getItem('net_amount')) || 0;
        var paid_amount = parseFloat($(this).val().replace(/,/g, ''));
        var change_amount = 0;

        if(isNaN(paid_amount) || paid_amount === ''){
            paid_amount = 0;
            $(this).val('');
        }else{
            change_amount = paid_amount - net_amount;
        }

        var formatted_paid_amount = paid_amount.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        $('#paid_amount_label').html(formatted_paid_amount);
        localStorage.setItem('paid_amount', paid_amount);
        
        var formatted_change_amount = change_amount.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        $('#change_amount_label').html(formatted_change_amount);
        $('#change_amount_input').val(change_amount);
        localStorage.setItem('change_amount', change_amount);
    });

    // handleReload();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalTriggers = document.querySelectorAll('.modal-trigger');
        const modalCloses = document.querySelectorAll('.modal-close');

        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const targetId = this.getAttribute('data-modal-target');
                const targetModal = document.getElementById(targetId);
                targetModal.classList.remove('hidden');
            });
        });

        modalCloses.forEach(closeButton => {
            closeButton.addEventListener('click', function() {
                const modal = this.closest('.modal');
                modal.classList.add('hidden');
            });
        });

        localStorage.removeItem('paid_amount');
        localStorage.removeItem('discount_amount');
        localStorage.removeItem('change_amount');

        let totalAmount = localStorage.getItem('totalAmountForPOSOrder');
        localStorage.setItem('net_amount', totalAmount);

    });
</script>

<script>
    $('#customer_done_btn').on('click', function() {

        var name = $('#shopper_name').val();
        var phone = $('#shopper_phone').val();
        var address = $('#shopper_address').val();

        $.ajax({
            url: "{{ route('shopper-store') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                phone: phone,
                address: address,
            },
            success: function(response) {
                // console.log(response.data);
                $('#shopper_select').empty();

                $('#shopper_select').append('<option value="" class="px-10" selected disabled>Select Shopper</option>');

                response.data.forEach(function(shopper) {
                    $('#shopper_select').append('<option value="' + shopper.id + '">' + shopper.name + '</option>');
                });

                $('#shopper_cancel_btn').click();
                $('#shopper_error_msg').css('display', 'none');
            },
            error: function(xhr, status, error) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    var errorMessage = response.errors.name[0];
                    $('#shopper_error_msg').text('*' + errorMessage);
                    $('#shopper_error_msg').css('display', 'block');
                } catch (e) {
                    console.error('An error occurred:', e);
                }
            }
        });
    });
</script>

<script>
    function handleReload() {
        var pos_order_products = JSON.parse(localStorage.getItem('selectedProductsForPOS'));
        document.getElementById('pos_order_products').value = JSON.stringify(pos_order_products);        
    }
    handleReload();
</script>

<script>
    // Disable the button immediately after submitting the form
    document.getElementById('submitForm').addEventListener('submit', function(event) {        
        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.innerHTML = "Processing...";
        submitButton.style.opacity = '0.5';
    });
</script>

@endsection