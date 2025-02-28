<div class="flex items-center justify-between mb-3 font-poppins">
    <h1 class="text-noti font-semibold  font-jakarta">{{ $title }}</h1>

</div>

<div class="flex items-center justify-between font-poppins flex-wrap gap-5 mb-3">
    <div>
        <h1 class="text-primary font-semibold text-sm mb-2">Sale ID</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs  ">{{ $data->order_number ?? '-' }}</h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Total Quantity</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">
            
            {{ number_format($data->origin_quantity) ?? '-' }}
        </h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Payment Type</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ $data->paymentType->bank_name }} </h1>
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Action By</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ $data->user?->name ?? '-' }}</h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-center text-sm">Date</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs ">{{ dateFormat($data->created_at) ?? '-' }}</h1>
    </div>
</div>

<div class="flex items-center justify-between font-poppins flex-wrap gap-5 mb-3 mt-3">
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Total Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ number_format($data->total_amount) ?? '-' }}
        </h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Discount Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ number_format($data->discount_amount) ?? '-' }}
        </h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Net Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ number_format($data->origin_net_amount) }} <span class="text-red-600">(-{{ number_format($data->origin_net_amount - $data->net_amount) }})</span></h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Paid Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ number_format($data->paid_amount) }} </h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Change Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ number_format($data->change_amount) }} </h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm text-center">Sale Staff</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-xs text-center ">{{ $data->saleConsultant->name }} </h1>
    </div>
</div>

<div class=" outline-[1px] outline-dashed outline-primary my-5"></div>
