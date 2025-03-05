@extends('layouts.master')
@section('title', 'Product Prefix')
@section('mainTitle', 'Product Prefix Lists')

@section('content')
    @php
        use App\Models\ProductPrefix;

    @endphp
    <style>
        #check_status {
            display: none;
        }

        /* Style for the custom toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 37px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 13px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #00812C;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #00812C;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(15px);
            -ms-transform: translateX(15px);
            transform: translateX(15px);
        }

        /* Optional: Add some additional styling */
        .slider.round {
            border-radius: 10px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        .opacity-75 {
            opacity: 0.75;
        }
    </style>
    <section class="md:ml-[270px] font-jakarta my-5 mr-[20px] 2xl:ml-[320px]">
        {{-- table start --}}
        <div class="data-table mt-5">
            <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
                <div class="flex items-center justify-start gap-5 pt-3 px-5">
                    <h1 class="text-paraColor font-semibold  font-jakarta">Product Prefix</h1>
                    @if (!ProductPrefix::exists())
                        <a href="{{ route('product-prefix-create') }}"
                            class="flex items-center text-white   gap-1 border border-primary bg-primary px-2 py-1  rounded-md">
                            <i class="fa-solid fa-plus text-xs "></i>
                            <h1 class="font-medium text-xs  font-jakarta">Add Prefix</h1>
                        </a>
                    @endif
                </div>
                <div>
                    <div class=" overflow-x-auto mt-3 shadow-lg">
                        <table class="w-full text-sm font-poppins text-gray-500 ">
                            <thead class="text-sm font-jakarta  text-primary  bg-gray-50 ">
                                {{-- <x-table-head-component :columns="['Prefix', 'Prefix Length', 'Created By', 'Created At', 'Action', 'Status']" /> --}}
                                <tr class="text-left border-b">
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Prefix
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Prefix Length
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created By
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Created At
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-left">
                                        Prefix Type
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Action
                                    </th>
                                    <th
                                        class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3 text-center">
                                        Standard Mode
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="searchResults" class="text-[13px]">
                                @forelse($product_prefixs as $product_prefix)
                                    <tr class="border-b text-left">
                                        <input type="text" id="productPrefixId" value="{{ $product_prefix->id }}" hidden>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $product_prefix->prefix }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            {{ $product_prefix->prefix_length }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $product_prefix->user?->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ dateFormat($product_prefix->created_at) }}
                                        </td>
                                        <td id="prefixTypeColumn" class="px-6 py-4 whitespace-nowrap">
                                            {{ $product_prefix->prefix_type ?? '-' }}
                                        </td>                                        
                                        @if (auth()->user()->role->name == 'Super Admin')
                                            <td class="px-6 py-4 whitespace-nowrap flex items-center justify-center">
                                                <a
                                                    href="{{ route('product-prefix-edit', ['prefix' => $product_prefix->id]) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1.2em"
                                                        viewBox="0 0 512 512" class="mx-auto">
                                                        <path
                                                            d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"
                                                            fill="#00812C" />
                                                    </svg>
                                                </a>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <label class="toggle-switch">
                                                    <input type="checkbox" id="check_status" name="status"
                                                        value="{{ $product_prefix->status == 'enable' ? 'enable' : 'disable' }}"
                                                        @if ($product_prefix->status == 'enable') checked @endif
                                                        onchange="updateValue(this)">
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        @endif
                                    </tr>
                                @empty

                                    @include('layouts.not-found', ['colSpan' => 7])
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Modal -->
                <div id="modalbox" class="fixed inset-0 flex items-center justify-center backdrop-blur-sm hidden mt-10">
                    <div class="bg-white opacity-75 mb-5 p-10 shadow-2xl rounded-[20px]">
                        <h1 class="font-jarkarta text-center font-medium text-xl mb-5">Select Prefix Format</h1>
                        <div class="flex items-center justify-center gap-10">
                            
                            <!-- Category -->
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="categoryCheckbox" class="w-4 h-4 accent-primary border-gray-300 rounded focus:ring-primary">
                                <label for="categoryCheckbox" class="text-paraColor font-semibold text-sm">Category</label>
                            </div>
                        
                            <!-- Brand -->
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="brandCheckbox" class="w-4 h-4 accent-primary border-gray-300 rounded focus:ring-primary">
                                <label for="brandCheckbox" class="text-paraColor font-semibold text-sm">Brand</label>
                            </div>
                        
                            <!-- Category & Brand -->
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="categoryBrandCheckbox" class="w-4 h-4 accent-primary border-gray-300 rounded focus:ring-primary">
                                <label for="categoryBrandCheckbox" class="text-paraColor font-semibold text-sm">Category & Brand</label>
                            </div>
                        </div>
                
                        <div class="flex flex-col md:items-center text-center md:text-left md:flex-row mt-10 md:justify-center gap-10">
                            <button type="button" id="cancelBtn"
                                class="outline outline-1 text-noti text-sm outline-noti w-full md:w-44 py-2 rounded-2xl">Cancel</button>
                            <button type="submit" id="confirmBtn"
                                class="text-sm bg-noti outline mx-auto md:mx-0 text-white outline-1 w-full outline-noti md:w-44 py-2 rounded-2xl"
                                id="submitButton">Done</button>
                        </div>
                    </div>
                </div>                

            </div>
        </div>
        {{-- table end --}}
    </section>
@endsection
@section('script')
<script>
    function updateValue(checkbox) {
        var status = checkbox.checked ? "enable" : "disable";
        var productId = $("#productPrefixId").val();
        var url = "{{ route('product-prefix-change-status', ['prefix' => ':productId']) }}".replace(':productId', productId);

        if (status === "disable") {
            $("#modalbox").removeClass("hidden");

            $("#confirmBtn").off("click").on("click", function () {
                var prefixType = getSelectedPrefixType();
                if (!prefixType) {
                    toastr.error("Please select a prefix type.");
                    return;
                }

                sendAjaxRequest(url, status, checkbox, prefixType);
                $("#modalbox").addClass("hidden");
            });

            $("#cancelBtn").off("click").on("click", function () {
                checkbox.checked = true;
                $("#modalbox").addClass("hidden");
            });
        } else {
            sendAjaxRequest(url, status, checkbox, null);
        }
    }

    function sendAjaxRequest(url, status, checkbox, prefixType) {
        $.ajax({
            url: url,
            type: 'PUT',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { status: status, prefix_type: prefixType },
            success: function(response) {
                toastr.success(response.message);

                $("#prefixTypeColumn").text(response.prefix_type);
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred');
                checkbox.checked = !checkbox.checked;
            }
        });
    }

    function getSelectedPrefixType() {
        if ($("#categoryCheckbox").is(":checked")) {
            return "Category";
        } else if ($("#brandCheckbox").is(":checked")) {
            return "Brand";
        } else if ($("#categoryBrandCheckbox").is(":checked")) {
            return "All";
        }
        return null;
    }

    $("#modalbox").click(function (event) {
        if (!$(event.target).closest(".bg-white").length) {
            event.stopPropagation();
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const categoryCheckbox = document.getElementById("categoryCheckbox");
        const brandCheckbox = document.getElementById("brandCheckbox");
        const categoryBrandCheckbox = document.getElementById("categoryBrandCheckbox");

        function updateCheckboxState() {
            if (categoryCheckbox.checked) {
                brandCheckbox.disabled = true;
                categoryBrandCheckbox.disabled = true;
            } else if (brandCheckbox.checked) {
                categoryCheckbox.disabled = true;
                categoryBrandCheckbox.disabled = true;
            } else if (categoryBrandCheckbox.checked) {
                categoryCheckbox.disabled = true;
                brandCheckbox.disabled = true;
            } else {
                categoryCheckbox.disabled = false;
                brandCheckbox.disabled = false;
                categoryBrandCheckbox.disabled = false;
            }
        }

        categoryCheckbox.addEventListener("change", updateCheckboxState);
        brandCheckbox.addEventListener("change", updateCheckboxState);
        categoryBrandCheckbox.addEventListener("change", updateCheckboxState);
    });
</script>
@endsection
