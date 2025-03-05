<div class="relative overflow-x-auto shadow-lg ">
    <table class="w-full  text-sm text-left  text-gray-500 pt-5 ">
        <thead class=" font-jakarta text-sm bg-gray-50    text-primary  ">
            <tr class="">
                <th scope="col" class="px-6 py-3">
                    Customer Name <span class="text-[#5C5C5C] font-medium">(ID)</span>
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone Number
                </th>
                <th scope="col" class="px-6 py-3">
                    Division
                </th>
                <th scope="col" class="px-6 py-3">
                    Township
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>

            </tr>
        </thead>
        <tbody class="font-poppins text-[13px]">
            <tr class="bg-white  ">
                <th scope="row" class="px-6 py-2 font-medium  text-gray-900 whitespace-nowrap ">
                    <div class="flex items-center gap-2">
                        <div>
                            @if($customer->image)
                            <img src="{{asset('customers/image/'.$customer->image)}}" class="w-10 h-10  object-contain ">
                            @else
                            <img src="{{ asset('images/no-image.png') }}" class="w-10 ">
                            @endif
                        </div>
                        <h1 class="text-[#5C5C5C] font-medium  "> {{ $customer->name }}<span class="text-noti ">({{ $customer->user_number}})</span></h1>
                    </div>


                </th>
                <td class="px-6 py-2">
                   {{ $customer->phone }}
                </td>
                <td class="px-6 py-2 ">
                    @php
                        $division = \App\Models\Address::where('code', $customer->division)->first();
                    @endphp
                    {{ $division->name ?? '-'}}

                </td>
                <td class="px-6 py-2">
                    @php
                        $township = \App\Models\Address::where('code', $customer->township)->first();
                    @endphp
                    {{ $township->name ?? '-'}}

                </td>
                <td class="px-6 py-2 ">
                    {{ $customer->address ?? '-'}}
                </td>



            </tr>
        </tbody>
    </table>
</div>
