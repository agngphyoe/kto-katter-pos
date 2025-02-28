<div class="grid grid-cols-2  md:grid-cols-5 gap-3">
    <div class="text-left">
        <h1 class="text-primary font-poppins text-sm font-semibold mb-2 ">Supplier Name</h1>
        <div class="flex items-center gap-3">
            <img src="{{ asset('/suppliers/image/' . $supplier->image) }}" class="w-10" alt="">
            <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $supplier->name ?? '-' }}</h1>
        </div>
    </div>
    <div class="md:text-left">
        <h1 class=" text-primary font-poppins text-sm font-semibold mb-2">Supplier ID</h1>
        <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $supplier->user_number ?? '-' }}</h1>
    </div>
    <div class="md:text-left">
        <h1 class=" text-primary font-poppins text-sm font-semibold mb-2">Phone Number</h1>
        <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $supplier->phone ?? '-' }}</h1>
    </div>
    <div class="md:text-left">
        <h1 class=" text-primary font-poppins text-sm font-semibold mb-2">Country</h1>
        <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $supplier->country->name ?? '-' }}</h1>
    </div>
    <div class="md:text-left">
        <h1 class=" text-primary font-poppins text-sm font-semibold mb-2">Address</h1>
        <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $supplier->address ?? '-' }}</h1>
    </div>
</div>
