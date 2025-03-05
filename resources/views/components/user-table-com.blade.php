{{-- table start --}}
  <div class="data-table mt-5">
    <div class="  bg-white px-4 py-2 font-poppins rounded-[20px]  ">
        <div class="flex items-center justify-between pt-3 px-5">
            <h1 class="text-paraColor font-semibold  font-jakarta">{{$title}}</h1>
           
            <h1 class="text-noti font-medium text-sm">{{$subtitle}}</h1>
        </div>
        <div>
            <div class="relative overflow-x-auto mt-3">
                <table class="w-full text-sm text-left font-poppins text-gray-500 ">
                    <thead class="text-[15px]  border-y text-primary  ">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                               {{$col1}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                             {{$col2}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                             {{$col3}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                             {{$col4}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                            {{$col5}}
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="bg-white  ">
                            <td scope="row"
                                class="px-6 py-2 font-medium  text-gray-900 whitespace-nowrap ">
                               
                                {{$user->name}}
                            </td>
                            <td class="px-6 py-2">
                              {{$user->name}}
                            </td>
                            <td class="px-6 py-2 text-noti">
                             {{$user->name}}

                            </td>
                            <td class="px-6 py-2">
                             {{$user->name}}
                            
                            </td>
                            <td class="px-6 py-2">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-trash-can text-noti"></i>
                                    <i class="fa-regular fa-eye text-noti"></i>
                                    <i class="fa-solid fa-pencil text-noti"></i>
                                </div>
                            
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        
                    </tbody>
                </table>
            </div>

        </div>

        
    </div>
</div>
{{-- table end  --}}