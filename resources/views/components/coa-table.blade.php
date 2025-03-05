<div class="  bg-white px-4 py-3 rounded-[20px] my-5">
    <div class=" overflow-x-auto shadow-xl mt-3">
        <table class="w-full text-sm text-center text-gray-500 ">
            <thead class="font-poppins text-black ">
                <tr class="border-y font-semibold">
                    <td class="text-left px-6 py-4 border-r" colspan="3">
                        TestingType
                    </td>
                    <td class="text-center px-6 py-4 border-r" colspan="2">
                    One
                    </td>
                    <td class="text-center px-6 py-4" colspan="2">
                       Two
                        </td>
                </tr>
            </thead>
            <thead class="text-sm   font-jakarta text-primary  bg-gray-50 ">
                <x-table-head-component :columns="[
           
            'Account No',
            'Account Name',
            'Date',
            'Cash In (MMK)',
            'Cash Out (MMK)',
            'Cash In (MMK)',
            'Cash Out (MMK)'
            ]" />
            </thead>
            <tbody id="searchResults" class="text-sm text-left animate__animated animate__slideInUp font-normal text-paraColor font-poppins">
               {{$slot}}
            </tbody>
        </table>
    </div>
   

</div>