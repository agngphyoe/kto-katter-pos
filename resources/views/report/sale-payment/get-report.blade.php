@forelse($paymentables as $paymentable)
<tr class="bg-white border-b  ">
    <td scope="row" class="px-6   py-4 whitespace-nowrap ">
        <h1 class="text-noti text-left">
            {{ $paymentable->paymentable?->invoice_number }}
        </h1>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $paymentable->paymentableBy?->name ?? '-' }}
    </td>

    <td class="px-6 py-4 whitespace-nowrap">

        {{ $paymentable->paymentableBy?->phone ?? '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
       
        <x-badge class="{{ $paymentable->payment_status == 'Complete' ? 'bg-[#00812C]' : 'bg-[#FF8A00]' }} text-white px-3">
            {{ $paymentable->payment_status }}
        </x-badge>


    </td>
    <td class="pl-6 pr-12    py-4 text-right text-noti whitespace-nowrap">

        {{ number_format($paymentable->amount) }}
    </td>

    <td class="pl-6 pr-10    py-4 text-right  text-noti  ">

        {{ number_format($paymentable->total_paid_amount) }}
    </td>

    <td class="px-6 py-4    ">

        {{ dateFormat($paymentable->payment_date) }}
    </td>
    <td class="px-6 py-4    ">

        {{ $paymentable->next_payment_date ? dateFormat($paymentable->payment_date) : '-'}}
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="py-5">
        {{-- <img class="mx-auto w-28" src="{{ asset('images/not_found.gif') }}"> --}}
        <h1 class="text-lg font-bold text-center pt-3">Not Found Data</h1>
    </td>
</tr>
@endforelse
