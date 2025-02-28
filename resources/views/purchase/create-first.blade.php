@extends('layouts.master-without-nav')
@section('title', 'Create Purchase')
@section('css')

@endsection
@section('content')
<section class="create-first-purchase">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Create A New Purchase',
    'subTitle' => 'Fill to create a new purchase',
    ])
    {{-- nav end  --}}

    {{-- progress bar start  --}}
    <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">
        <div class="flex items-center  lg:hidden justify-between gap-3 ">
            <div class="flex items-center gap-3 font-jakarta w-full">
                <div class="w-12 h-12 flex flex-shrink-0 items-center justify-center mb-3 outline outline-1 outline-primary text-primary  rounded-full">
                    1
                </div>
                <div class="w-full h-[2px] bg-primary flex-grow "></div>
            </div>
            <div class="flex items-center gap-2 w-full">
                <div class="w-12 h-12 flex shrink-0 items-center opacity-50 justify-center mb-3  outline outline-1 outline-primary text-primary  rounded-full">
                    2
                </div>
                <div class="w-full h-[2px] bg-primary opacity-50 flex-grow "></div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center opacity-50 justify-center mb-3  outline outline-1 outline-primary text-primary rounded-full">
                    3
                </div>

            </div>

        </div>
        <div class="flex items-center font-jakarta block lg:hidden justify-between gap-3 ">
            <div>
                <h1 class="text-primary font-semibold mb-1 text-sm">Supplier</h1>
                <h1 class="text-paraColor text-xs">Supplier Information</h1>
            </div>
            <div>
                <h1 class="text-primary font-semibold mb-1 ml-12 text-sm text-center">Product</h1>
                <h1 class="text-paraColor ml-12 text-xs text-center">Products details to be ordered</h1>
            </div>
            <div>
                <h1 class="text-primary font-semibold mb-1 text-sm text-right">payment</h1>
                <h1 class="text-paraColor text-xs text-right">The final steps to be purchased</h1>
            </div>

        </div>
    </div>
    {{-- progress bar end --}}

    {{-- ..........  --}}
    <form id="submitForm" action="{{ route('purchase-create-second') }}">
        @csrf

        <div class="font-jakarta mx-5 lg:mx-[40px] my-[20px]">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-3">
                    <div class="bg-white rounded-[20px] mb-5 shadow-xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 p-5 lg:p-10">
                            <!-- Content Section -->
                            <div class="col-span-1">
                                <div class="bg-bgMain p-5 rounded-[20px] md:mx-0">
                                    <img src="{{ asset('images/purchasecreate.png') }}" class="w-48 animate__animated animate__bounce h-48 mx-auto" alt="">
                                </div>
                            </div>
                            <div class="col-span-1">
                                <!-- Other Inputs -->
                                <div class="flex flex-col mb-5">
                                    <label for="" class="block mb-2 text-paraColor font-medium text-sm">Supplier Number</label>
                                    <input type="text" name="code" id="code" placeholder="ID123CV#" class="outline outline-1 font-jakarta text-paraColor text-[16px] outline-primary px-8 py-2 rounded-full w-full" readonly>
                                </div>
                                <div class="flex flex-col mb-5">
                                    <label for="" class="block mb-2 text-paraColor font-medium text-sm">Select Supplier</label>
                                    <select name="supplier_id" id="supplierSelect" class="select2 outline-none w-full" required>
                                        <option value="" selected disabled>Supplier</option>
                                        @forelse ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }} ({{ $supplier->user_number }})</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('supplier_id')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <label for="" class="block mb-2 text-paraColor font-medium text-sm">Select Currency</label>
                                    <select name="currency_type" id="currencyTypeSelect" class="select2 outline-none w-full " required>
                                        {{-- @forelse ($types as $key => $value)
                                            <option value="{{ $value }}" {{ $value === 'kyat' ? 'selected' : '' }}>
                                                {{ strtoupper($key) }}
                                            </option>
                                        @empty
                                        @endforelse --}}
                                        <option value="kyat" selected>KYAT</option>
                                    </select>
                                    @error('currency_type')
                                        <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="currencyInputContainer" class="flex flex-col mb-3 hidden">
                                    <label for="currencyInput" class="block mb-2 text-paraColor font-medium text-sm">Enter Currency Rate</label>
                                    <input type="text" id="currencyInput" name="currency_value" placeholder="Enter value" class="outline outline-1 font-jakarta text-paraColor text-[16px] outline-primary px-8 py-2 rounded-full w-full">
                                </div>
                            </div>
                        </div>
                    
                        <!-- Button Section -->
                        <div class="p-5 lg:p-10">
                            <button class="bg-noti text-white rounded-full px-5 py-2 w-full" type="submit" id="submitButton">Next</button>
                        </div>
                    </div>
                    
                    {{-- suppler detail start --}}
                    <div class="bg-white p-5 rounded-[20px] px-8 shadow-xl">
                        <h1 class="text-noti mb-3 font-semibold  text-center ">Supplier Details</h1>
                        <div class="flex items-center justify-center md:justify-between flex-wrap gap-3" id="supplierDetail">

                        </div>
                    </div>
                    {{-- suppler detail end --}}

                </div>
                <div class="col-span-1 hidden lg:block md:col-span-1">
                    <div class="flex justify-between">
                        <div>
                            <h1 class="text-primary font-semibold mb-1 ">Supplier</h1>
                            <h1 class="text-paraColor text-sm">Supplier Information</h1>
                        </div>
                        <div class="">
                            <div class="w-12 h-12 flex items-center justify-center mb-3 outline outline-1 outline-primary rounded-full">1</div>
                            <div class="w-[2px] h-36 bg-primary mx-auto"></div>
                        </div>
                    </div>
                    <div class="flex justify-between my-3">
                        <div>
                            <h1 class="text-primary font-semibold mb-1 opacity-50 ">Product</h1>
                            <h1 class="text-paraColor text-sm">Products details to be ordered</h1>
                        </div>
                        <div class="">
                            <div class="w-12 h-12 flex items-center justify-center mb-3 outline outline-1 opacity-50  outline-primary rounded-full">2</div>
                            <div class="w-[2px] h-36 bg-primary mx-auto opacity-50"></div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <h1 class="text-primary font-semibold mb-1 opacity-50 ">Payment</h1>
                            <h1 class="text-paraColor text-sm">The final steps to be purchased</h1>
                        </div>
                        <div class="">
                            <div class="w-12 h-12 flex items-center justify-center mb-3 outline opacity-50 outline-1 outline-primary rounded-full">3</div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </form>


</section>
@endsection
@section('script')
<script>
    clearLocalStorage();
    $(document).ready(function() {
        $('#supplierSelect').change(function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: `/purchase/supplier/${selectedValue}`,
                method: 'GET',
                data: {
                    supplierId: selectedValue
                },
                success: function(response) {
                    $('#code').val(response.user_number);
                    $('#supplierDetail').html(response.html);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currencyTypeSelect = $('#currencyTypeSelect'); // jQuery selector
        const currencyInputContainer = $('#currencyInputContainer'); // jQuery selector
        const currencyInput = document.querySelector('#currencyInput'); // Vanilla JS for input field

        if (!currencyTypeSelect.length || !currencyInputContainer.length || !currencyInput) {
            console.error('Required elements not found in the DOM.');
            return;
        }

        currencyTypeSelect.on('change', function () {
            const selectedValue = $(this).val(); // Get the selected value
            if (selectedValue !== 'kyat') {
                currencyInputContainer.show(); // Show the input container
                currencyInput.setAttribute('required', 'required'); // Add 'required' attribute
            } else {
                currencyInputContainer.hide(); // Hide the input container
                currencyInput.removeAttribute('required'); // Remove 'required' attribute
            }
        });

        // Trigger change event on page load to handle pre-selected value
        currencyTypeSelect.trigger('change');
    });
</script>
@endsection