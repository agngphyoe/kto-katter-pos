@extends('layouts.master-without-nav')
@section('title', 'Reconciliation Details')

@section('content')
    <section class="Transfer__Detail">
        @include('layouts.header-section', [
            'title' => 'Reconciliation Details',
            'subTitle' => 'View reconciliation details',
        ])

        <div class="lg:mx-[30px] mx-[10px] my-[10px] lg:my-[20px]">

            <div class="bg-white p-5 rounded-[20px] mt-5">
                <div class="relative overflow-x-auto shadow-lg">
                    <table class="w-full text-sm text-center text-gray-500">
                        <thead class="text-sm text-primary bg-gray-50 font-medium font-poppins">
                            <tr class="text-left border-b">
                                <th class="px-6 py-3 whitespace-nowrap">Reconcilication ID</th>
                                <th class="px-6 py-3 whitespace-nowrap">Location Name</th>
                                <th class="px-6 py-3 whitespace-nowrap">Product Name</th>
                                <th class="px-6 py-3 whitespace-nowrap">Code</th>
                                <th class="px-6 py-3 whitespace-nowrap text-center">Software Qty</th>
                                <th class="px-6 py-3 whitespace-nowrap text-center">Ground Qty</th>
                                <th class="px-6 py-3 whitespace-nowrap text-center">Discrepancy</th>
                                <th class="px-6 py-3 whitespace-nowrap text-center">Reconcile By</th>
                                <th class="px-6 py-3 whitespace-nowrap text-center">Reconcile Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reconciliation->products as $product)
                                @php
                                    $discrepancy = $product->pivot->real_qty - $product->pivot->inv_qty;
                                    $isDiscrepant = $discrepancy !== 0;
                                @endphp
                                <tr class="text-left border-b font-medium {{ $isDiscrepant ? 'text-red-600' : '' }}">
                                    <th class="px-6 py-4 whitespace-nowrap {{ $isDiscrepant ? 'text-red-600' : '' }}">
                                        {{ $reconciliation->reconciliation_id }}
                                    </th>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $reconciliation->location->location_name }}
                                    </td>
                                    <td scope="row"
                                        class="px-6 py-4 whitespace-nowrap font-medium {{ $isDiscrepant ? 'text-red-600' : 'text-gray-900' }}">
                                        <div class="flex items-center gap-2">
                                            @if ($product->image)
                                                <img src="{{ asset('products/image/' . $product->image) }}"
                                                    class="w-10 h-10 object-cover">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}"
                                                    class="w-10 h-10 object-cover">
                                            @endif

                                            <h1 class="{{ $isDiscrepant ? 'text-red-600' : 'text-[#5C5C5C]' }} font-medium">
                                                {{ $product->name }}
                                            </h1>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap {{ $isDiscrepant ? 'text-red-600' : '' }}">
                                        {{ $product->code }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        {{ $product->pivot->inv_qty }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        {{ $product->pivot->real_qty }}
                                    </td>
                                    <td
                                        class="px-6 py-3 whitespace-nowrap text-center {{ $isDiscrepant ? 'text-red-600' : 'text-primary' }}">
                                        @if ($discrepancy > 0)
                                            +{{ $discrepancy }}
                                        @elseif ($discrepancy < 0)
                                            {{ $discrepancy }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-left">
                                        {{ $reconciliation->createdBy->name }}
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-left">
                                        {{ $reconciliation->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-center mt-5 gap-5">
                <a href="{{ route('export-reconcile', ['id' => $reconciliation->id]) }}">
                    <x-button-component class="bg-primary text-white" type="button">
                        Export
                    </x-button-component>
                </a>
                <a href="{{ url()->previous() }}">
                    <x-button-component class="bg-noti text-white" type="button">
                        Back
                    </x-button-component>
                </a>
            </div>
        </div>
    </section>
@endsection
