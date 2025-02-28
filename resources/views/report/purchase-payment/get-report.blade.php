@forelse($paymentables as $paymentable)
    <tr class="bg-white border-b text-left ">
        <td scope="row" class="px-6 py-4 whitespace-nowrap ">
            <h1 class="text-noti text-left">
                {{ $paymentable->paymentable_id }}
            </h1>
        </td>

        <td scope="row" class="px-6 py-4 whitespace-nowrap ">
            <h1 class="text-noti text-left">
                {{ $paymentable->paymentable?->invoice_number }}
            </h1>
        </td>

        <td scope="row" class="px-6 py-4 whitespace-nowrap ">
            <h1 class="text-left">
                {{ $paymentable->paymentableBy?->user_number }}
            </h1>
        </td>

        <td class="px-6 py-4 whitespace-nowrap ">

            {{ $paymentable->paymentableBy?->name ?? '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            {{ $paymentable->paymentable->action_type ?: '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-center">

            {{ $paymentable->paymentable->total_quantity }}
        </td>

        <td class="px-6 py-4 text-right whitespace-nowrap">

            {{ number_format($paymentable->paymentable?->total_amount - $paymentable->paymentable?->discount_amount) }}
        </td>

        <td class="px-6 py-4 text-right whitespace-nowrap">

            {{ number_format($paymentable->paymentable?->total_paid_amount) }}
        </td>

        <td class="px-6 py-4 text-right whitespace-nowrap">

            {{ number_format($paymentable->paymentable?->remaining_amount) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap ">

            {{ $paymentable->paymentable->due_date ?: '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">

            <x-badge
                class="{{ $paymentable->payment_status == 'Complete' ? 'bg-[#00812C]' : 'bg-[#FF8A00]' }} text-white px-3">
                {{ $paymentable->payment_status }}
            </x-badge>


        </td>

        <td class="px-6 py-4 whitespace-nowrap ">

            {{ dateFormat($paymentable->payment_date) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap ">

            {{ $paymentable->user?->name }}
        </td>

    </tr>
@empty

    @include('layouts.not-found', ['colSpan' => 13])
@endforelse
