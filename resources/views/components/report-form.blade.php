<form>

    <div class=" flex items-center  font-jakarta justify-center mx-10  mt-20">
        <div>
            <div class="bg-white mb-5  p-10 shadow-2xl rounded-[20px]">
                <h1 class="text-noti font-semibold mb-8 text-[20px] text-center">{{$title}}</h1>
                <div class="flex md:flex-row flex-col  gap-10">
                    <div class="flex items-center justify-center flex-wrap gap-5">
                        <div class="flex flex-col mb-5">
                            <label for="" class="font-jakarta text-[16px] text-paraColor font-semibold mb-2"></label>
                            <input type="text" placeholder="ID123CV#" class="outline outline-1 text-sm font-jakarta text-paraColor w-[300px]  text-[16px] outline-primary px-8 py-2 rounded-full">
                        </div>
                        <div class="flex flex-col mb-5">
                            <label for="" class="font-jakarta text-[16px] text-paraColor font-semibold mb-2"></label>
                            <input type="text" name="" id="" class="custom_input outline outline-1 text-sm font-jakarta text-paraColor w-[300px]   outline-primary px-8 py-2 rounded-full">

                        </div>


                    </div>

                </div>
                <div class="flex items-center justify-center">
                    <div class="flex flex-col mb-5">
                        <label for="" class="font-jakarta text-[16px] text-paraColor font-semibold mb-2">Date Range</label>
                        <div class="outline outline-1 text-sm font-jakarta text-paraColor w-[300px]  text-[16px] outline-primary pl-8  py-2 rounded-full">
                            <input type="text" name="daterange" id="" placeholder="From Date To Date" class="w-[230px] outline-none">
                            <i class="fa-regular fa-calendar-minus text-lg text-primary"></i>
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-center flex-wrap gap-10 mt-10 mb-3">
                    <a href="{{ route('damage-create-first') }}" class="">
                        <x-button-component class="outline w-[300px]   outline-1 outline-noti text-noti" type="button">
                            Back
                        </x-button-component>
                    </a>

                    <x-button-component class="bg-noti w-[300px] text-white" type="submit" id="doneButton">
                        Export
                    </x-button-component>
                </div>


            </div>


        </div>

    </div>
</form>