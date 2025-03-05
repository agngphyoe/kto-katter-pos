@forelse($purchase_returns as $purchase_return)
    <tr class="bg-white border-b text-left">
        <td scope="row" class="px-6 py-4 whitespace-nowrap">
            <h1 class="text-noti text-left">
                {{ $purchase_return->purchase_return_number ?? '-' }}
            </h1>
        </td>

        <td scope="row" class="px-6 py-4 whitespace-nowrap">
            <h1 class="text-left">
                {{ $purchase_return->purchase->invoice_number ?? '-' }}
            </h1>
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ $purchase_return->purchase->supplier->name ?? '-' }}
        </td>

        <td class="px-6 py-4 font-medium">
            {{ $purchase_return->purchase->action_type ?? '-' }}
        </td>

        <td class="px-6 py-4 font-medium text-center">
            {{ number_format($purchase_return->return_quantity) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ $purchase_return->remark ?? '-' }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ dateFormat($purchase_return->return_date) }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            {{ $purchase_return->user->name ?? '-' }}
        </td>

        @if (!isset($is_export) || !$is_export)
            <td class="px-6 py-4">
                <div class="flex items-center ">
                    <div class="flex items-center gap-5 icon-container">
                        <button class="bg-bgMain h-9 w-9 flex items-center justify-center rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 128 512">
                                <path
                                    d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"
                                    fill="#00812C" class="centered-svg" />
                            </svg>
                        </button>
                        <div>

                        </div>
                        <div class="flex items-center hover-icons ">
                            <div class="flex flex-col gap-6">

                                <a href="{{ route('purchase-return-detail', ['id' => $purchase_return->id]) }}"
                                    class="bg-white outline outline-1 outline-primary h-8 w-8 flex items-center justify-center rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                        <path
                                            d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"
                                            fill="#00812C" />
                                    </svg>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>


            </td>
        @endif



    </tr>
@empty
    @include('layouts.not-found', ['colSpan' => 11])
@endforelse
