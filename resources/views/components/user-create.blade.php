<div class="grid grid-cols-1 xl:grid-cols-2 xl:gap-20 mb-6">
    <div class="col-span-1 border-b border-primary border-opacity-50 pb-4 mb-6 xl:mb-0">
        <div class="flex items-center justify-between">
            <h1 class="text-paraColor font-medium">{{ $product1 }}</h1>
            <ul class="flex items-center gap-4">
                <li class="relative">
                    <input class="sr-only peer" type="radio" value="yes" name="answer" id="allow">
                    <label
                        class="flex px-6 py-1 outline outline-1 outline-primary text-primary rounded-full cursor-pointer  hover:bg-green-50 peer-checked:bg-primary  peer-checked:text-white peer-checked:border-transparent"
                        for="allow">Allow</label>

                   

                <li class="relative">
                    <input class="sr-only peer" type="radio" value="no" name="answer" id="deny">
                    <label
                        class="flex px-6 py-1 outline outline-1 outline-noti text-noti rounded-full cursor-pointer  hover:bg-orange-100 peer-checked:bg-noti  peer-checked:text-white peer-checked:border-transparent"
                        for="deny">Deny</label>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-span-1 border-b border-primary border-opacity-50 pb-4">
        <div class="flex items-center justify-between">
            <h1 class="text-paraColor font-medium">{{ $product2 }}</h1>
            <ul class="flex items-center gap-4">
                <li class="relative">
                    <input class="sr-only peer" type="radio" value="yes1" name="answer1" id="allow1">
                    <label
                        class="flex px-6 py-1 outline outline-1 outline-primary text-primary rounded-full cursor-pointer  hover:bg-green-50 peer-checked:bg-primary  peer-checked:text-white peer-checked:border-transparent"
                        for="allow1">Allow</label>

                   

                <li class="relative">
                    <input class="sr-only peer" type="radio" value="no1" name="answer1" id="deny1">
                    <label
                        class="flex px-6 py-1 outline outline-1 outline-noti text-noti rounded-full cursor-pointer  hover:bg-orange-100 peer-checked:bg-noti  peer-checked:text-white peer-checked:border-transparent"
                        for="deny1">Deny</label>
                </li>
            </ul>
        </div>
    </div>
</div>
