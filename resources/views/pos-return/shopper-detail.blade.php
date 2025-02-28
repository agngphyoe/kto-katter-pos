<div class="grid grid-cols-3 gap-3" >
    <div class="">
        <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Shopper Name</h1>
        <div class="flex items-center gap-3">
            {{-- <img src="{{ asset('/customers/image/'.$customer->image)}}" class="w-10" alt=""> --}}
            <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $shopper->name ?? '-'}}<span class="text-noti"> ({{ $shopper->code ?? '-'}})</span></h1>
        </div>
    </div>
    <div class="text-center">
        <h1 class=" text-primary font-poppins text-sm font-semibold mb-2">Phone Number</h1>
        <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $shopper->phone ?? '-'}}</h1>
    </div>
    
    <div class="md:text-center">
        <h1 class=" text-primary font-poppins text-sm font-semibold mb-2">Address</h1>
        <h1 class="text-[#5C5C5C]  font-poppins text-[13px]">{{ $shopper->address ?? '-'}}</h1>
    </div>
</div>
