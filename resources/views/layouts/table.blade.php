<div class="bg-white p-5 rounded-[20px] mt-10">
    <div class="flex items-center justify-between">
        <h1 class="text-noti font-semibold text-lg">{{$title}}</h1>
        <h1 class="text-noti font-poppins font-medium text-xs">See More</h1>
    </div>
    <div class="border border-dashed mt-3 "></div>
      {{-- table start --}}
      <div class="data-table">
        <div class="  bg-white px-4 py-2 rounded-[20px]  ">
           
            <div>

                <div class="relative overflow-x-auto mt-3">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-sm text-primary border-b  font-medium font-poppins  ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{$titleone}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{$titletwo}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                   {{$titlethree}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                  {{$titlefour}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{$titlefive}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                   {{$titlesix}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{$titleseven}}
                                </th>

                            </tr>
                        </thead>
                        <tbody class="text-sm font-normal text-paraColor font-poppins">
                            <tr class="bg-white border-b dark:bg-gray-800 ">
                                <th scope="row"
                                    class="px-6 py-4 font-medium flex items-center gap-2 text-gray-900 whitespace-nowrap ">
                                   <h1 class="text-noti">
                                   {{$subone}}
                                   </h1>
                                </th>
                                <td class="px-6 py-4">
                                  
                                    
                                    <button class="bg-noti px-5 py-1 text-white rounded-full">{{$subtwo}}</button> 
                                </td>
                                <td class="px-6 py-4 text-noti">
                                  
                                   
                                   <button class="outline outline-1 outline-primary text-primary px-5 py-1 rounded-full">  {{$subthree}}</button> 

                                </td>
                                <td class="px-6 py-4">
                                    {{$subfour}}
                                  
                                </td>
                                <td class="px-6 py-4">
                                    {{$subfive}}
                                   
                                </td>
                                <td class="px-6 py-4">
                                   {{$subsix}}
                                    
                                </td>
                                <td class="px-6 py-4">
                                   {{$subseven}}
                                    
                                </td>
                            </tr>
                            {{-- <tr class="bg-white border-b dark:bg-gray-800 ">
                                <th scope="row"
                                    class="px-6 py-4 font-medium flex items-center gap-2 text-gray-900 whitespace-nowrap ">
                                   <h1 class="text-noti">Order No.12456</h1>
                                </th>
                                <td class="px-6 py-4">
                                    <button class="bg-noti px-5 py-1 text-white rounded-full">Urgent</button>
                                </td>
                                <td class="px-6 py-4 text-noti">
                                   <button class="outline outline-1 outline-primary text-primary px-5 py-1 rounded-full">Success</button>

                                </td>
                                <td class="px-6 py-4">
                                   100
                                </td>
                                <td class="px-6 py-4">
                                    300 000 
                                </td>
                                <td class="px-6 py-4">
                                    12 June 2023
                                </td>
                                <td class="px-6 py-4">
                                    Alex Wang
                                </td>



                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 ">
                                <th scope="row"
                                    class="px-6 py-4 font-medium flex items-center gap-2 text-gray-900 whitespace-nowrap ">
                                   <h1 class="text-noti">Order No.12456</h1>
                                </th>
                                <td class="px-6 py-4">
                                    <button class="bg-noti px-5 py-1 text-white rounded-full">Urgent</button>
                                </td>
                                <td class="px-6 py-4 text-noti">
                                   <button class="outline outline-1 outline-primary text-primary px-5 py-1 rounded-full">Success</button>

                                </td>
                                <td class="px-6 py-4">
                                   100
                                </td>
                                <td class="px-6 py-4">
                                    300 000 
                                </td>
                                <td class="px-6 py-4">
                                    12 June 2023
                                </td>
                                <td class="px-6 py-4">
                                    Alex Wang
                                </td>



                            </tr> --}}
                        
                        </tbody>
                    </table>
                </div>

            </div>

            
        </div>
    </div>
    {{-- table end  --}}
</div>