<div class="bg-white rounded-[20px] mb-5 shadow-xl">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 p-10">
        <div class="col-span-1 md:col-span-1">
            <div class="bg-bgMain p-5 rounded-[20px]">

                <img src="{{ asset('images/purchasecreate.png') }}" class="w-48 h-48 mx-auto" alt="">
            </div>
        </div>
        <div class="col-span-1 md:col-span-2 flex items-center justify-center">
            <div>
                <div class="flex items-center justify-start flex-wrap gap-5">
                    <div class="flex flex-col mb-5">
                        <label for="" class="font-jakarta text-paraColor mb-2">{{ $firstLabel }}</label>
                        <select name="customer_id" id="supplierSelect" class="select2 outline-none w-[200px]">
                            <option value="" selected disabled>{{ $selectBoxName }}</option>

                        </select>

                    </div>
                    <div class="flex flex-col mb-5">
                        <label for="" class="font-jakarta text-paraColor font-semibold mb-2">{{$secondLabel}}</label>
                        <input type="text" name="customer_name" id="code" placeholder="ID123CV#" class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[250px]  text-[16px] outline-primary px-8 py-2 rounded-full">
                    </div>


                </div>
                <div class="flex justify-center ">
                    <div>
                        <h1 class="font-jakarta text-sm text-[#5C5C5C] opacity-50 text-center mb-5"></h1>
                        <button class="bg-noti text-white rounded-full px-5 py-2 font-jakarta w-60" type="submit">{{$buttonText}}</button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>