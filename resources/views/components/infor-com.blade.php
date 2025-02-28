<div class="flex items-center justify-between mb-3 font-poppins">
    <h1 class="text-noti font-semibold  font-jakarta">{{ $title }}</h1>

</div>

<div class="flex items-center justify-between font-poppins flex-wrap gap-5 mb-3">
    <div>
        <h1 class="text-primary font-semibold text-sm mb-2">Purchase ID</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm">{{ $data->invoice_number ?? '-' }}</h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold text-sm mb-2">Currency Type</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-left">{{ strtoupper($data->currency_type->name) }}</h1>
    </div>
    @if ($data->currency_type->value != 'kyat')
        <div>
            <h1 class="text-primary font-semibold text-sm mb-2">Currency Rate</h1>
            <h1 class="text-[#5C5C5C] font-poppins text-sm text-left">{{ $data->currency_rate }}</h1>
        </div>
    @endif
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Total Quantity</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-center">{{ $data->total_purchase_quantity ?? '-' }}</h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Total Buying Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-right">
            @if ($data->currency_type->value == 'kyat')
                {{ number_format($data->total_amount) ?? '-' }}
        </h1>
    @else
        {{ number_format($data->currency_purchase_amount) ?? '-' }}</h1>
        @endif
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Discount Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-right">
            @if ($data->currency_type->value == 'kyat')
                {{ number_format($data->discount_amount) }}
            @else
                {{ number_format($data->currency_discount_amount) }}
            @endif
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">CashDown Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-right">
            {{ number_format($data->cash_down) }} </h1>
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Net Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-right">
            @if ($data->currency_type == 'kyat')
                {{ number_format($data->purchase_amount) }}
            @else
                {{ number_format($data->currency_net_amount) }}
            @endif

            @if ($data->total_purchase_return_amount != 0)
                <span class="text-red-600">
                    (-{{ number_format($data->total_purchase_return_amount) }})
                </span>
            @endif
        </h1>
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Total Paid Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-right">
            {{ number_format($data->total_paid_amount) }} </h1>
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Remaining Amount</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-right">
            @php
                $remaining = \App\Models\Paymentable::where('paymentable_type', 'App\Models\Purchase')
                    ->where('paymentable_id', $data->id)
                    ->orderByDesc('id')
                    ->first();
            @endphp
            {{ number_format($remaining->remaining_amount) }}
        </h1>
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Purchase Type</h1>
        @php
            $buttonColor = $data->action_type == 'Credit' ? '#FF8A00' : '#00812C';
        @endphp

        <button class="text-noti cursor-default outline-noti text-[12px] px-3 ml-6 font-semibold rounded-full text-left"
            style="background-color: {{ $buttonColor }}; color: white;">
            {{ $data->action_type ?? '-' }}
        </button>
    </div>
    <div>
        <h1 class="text-primary font-poppins text-sm font-semibold mb-2">Payment Type</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-left whitespace-nowrap">
            @php
                $payment_type = \App\Models\Bank::find($data->payment_type);
            @endphp
            {{ $payment_type->bank_name ?? '-' }}
        </h1>
    </div>

    <div>
        <h1 class="text-primary font-semibold mb-2 text-sm">Purchased By</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-left whitespace-nowwrap">{{ $data->user?->name ?? '-' }}
        </h1>
    </div>
    <div>
        <h1 class="text-primary font-semibold mb-2 text-center text-sm">Purchase Date</h1>
        <h1 class="text-[#5C5C5C] font-poppins text-sm text-left">{{ dateFormat($data->action_date) ?? '-' }}</h1>
    </div>
</div>

<div class=" outline-[1px] outline-dashed outline-primary my-5"></div>
