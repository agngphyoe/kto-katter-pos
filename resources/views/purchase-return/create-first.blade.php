@extends('layouts.master-without-nav')
@section('title', 'Purchase Return Create')
@section('css')

@endsection
@section('content')
<section class="purchase__Return__create_second">
    {{-- nav start  --}}
    @include('layouts.header-section', [
    'title' => 'Purchase A New Purchase Return',
    'subTitle' => 'Fill these to know the supplier you want to return',
    ])
    {{-- nav end  --}}

    {{-- ........  --}}
    {{-- main start  --}}
    <div>

        {{-- form start  --}}
        <div class="m-5 lg:m-10">
            <div class="bg-white rounded-[20px] mb-5 shadow-xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 p-5 lg:p-10">
                    <div class="col-span-1">
                        <div class="bg-bgMain p-5 rounded-[20px]  md:mx-0">

                            <img src="{{ asset('images/return.png') }}" class="w-[600px] animate__animated animate__bounce h-48 mx-auto" alt="">
                        </div>
                    </div>
                    <div class="col-span-1">
                        <form id="myForm" action="{{ url('purchase-return/create-second/') }}" method="GET">
                            @csrf
                            <!-- <input type="hidden" name="_method" value="DELETE"> -->
                            <div class="flex  flex-col mb-5">

                                <label for="" class="block mb-2 font-jakarta text-paraColor font-medium text-sm">Select
                                    Supplier <span class="text-red-600">*</span></label>
                                <select name="supplier_id" id="supplierSelect" class="select2 outline-none w-full">
                                    <option value="" selected disabled>Supplier</option>
                                    @forelse ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}
                                        ({{ $supplier->user_number }})</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('supplier_id')
                                <p class="text-red-600 text-xs mt-1">* {{ $message }}</p>
                                @enderror

                            </div>
                            <div class="flex flex-col mb-5">

                                <label for="" class="block mb-2 font-jakarta text-paraColor font-medium text-sm">Supplier
                                    Number</label>
                                <input type="text" name="code" id="code" placeholder="ID123CV#" class="outline outline-1 font-jakarta text-paraColor   text-[16px] outline-primary px-8 py-2 rounded-full w-full" readonly>

                            </div>
                            <div>
                                <button class="bg-noti font-jakarta text-white rounded-full px-5 py-2 w-full " type="submit" id="done">Done</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        {{-- form end --}}

        {{-- .........  --}}
        {{-- detail start  --}}
        <div class="mx-5 lg:mx-10">
            <div class="bg-white rounded-[20px]">
                <div class="p-5 ">
                    <h1 class="text-noti font-semibold font-jakarta text-center mb-4">Supplier Details</h1>
                    <div id="supplierDetail"></div>
                </div>
            </div>
        </div>
        {{-- detail end --}}
    </div>
    {{-- main end --}}
</section>
@endsection
@section('script')

{{-- get supplier ID --}}
<script>
    $(document).ready(function() {
        $('#supplierSelect').change(function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: `/purchase-return/supplier/${selectedValue}`,
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
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault();
    
        var supplierSelect = document.getElementById('supplierSelect');
        var supplierId = supplierSelect.value;
    
        if (supplierId) {
            var formAction = "{{ url('purchase-return/create-second') }}/" + supplierId;
            this.action = formAction;
            this.submit();
        } else {
            alert('Please select a supplier.');
        }
    });
    </script>

@endsection