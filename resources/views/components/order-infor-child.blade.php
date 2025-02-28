<div class="bg-white mt-3 py-4 mb-5 px-8 rounded-[20px] ">
    <h1 class="font-jakarta font-semibold text-noti mb-3 text-center">{{$title}}</h1>
    <div class="flex  justify-between mt-3 flex-wrap gap-5">
        <div>
            <h1 class="font-poppins text-primary  font-semibold  text-sm  mb-2">Shop Name <span class="text-paraColor">(ID)</span></h1>
            <div>
                <div class="flex items-center gap-3">
                    @if($customer->image)
                    <img src="{{ asset('customers/image/'.$customer->image) }}" class="w-10 h-10 object-contain" alt="Shop">
                    @else
                    <img src="{{ asset('images/no-image.png') }}" class="w-10 h-10 object-contain" alt="Shop">
                    @endif
                    <h1 class="text-paraColor font-poppins text-[13px] text-center">{{ $customer->name }} <span class="text-noti">({{ $customer->user_number }})</span></h1>

                </div>
            </div>
        </div>
        @php
            $division = \App\Models\Address::where('code', $customer->division)->value('name');
            $township = \App\Models\Address::where('code', $customer->township)->value('name');
        @endphp
        <x-information title="Phone Number" subtitle="{{ $customer->phone }}" />
        <x-information title="Division" subtitle="{{ $division }}" />
        <x-information title="Township" subtitle="{{ $township }}" />
        <x-information title="Address" subtitle="{{ $customer->address ?? '-' }}" />

    </div>
</div>
