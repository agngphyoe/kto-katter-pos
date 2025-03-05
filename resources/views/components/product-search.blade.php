<div class="data-serch">
    <div class="  bg-white px-4 py-4 rounded-[20px]   my-5  ">
        <div class="md:flex md:items-center md:justify-between">
            <div class="md:flex md:items-center mb-4 md:mb-0 gap-10">
                <div class="flex items-center mb-4 md:mb-0 gap-4">
                @if($search)
                    <div class="flex items-center outline outline-1 outline-primary rounded-full px-4 py-[7px]">
                        <input type="search" class="outline-none font-poppins outline-transparent" id="searchInput" placeholder="Search...">

                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">

                            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" fill="#00812C" />
                        </svg>
                    </div>
                @endif
                
                @if(isset($locations) && !empty($locations))
                <div class="flex items-center outline-1 outline-primary px-4 py-[7px]">
                    <select name="location_id" id="searchProductLocation" class="outline-none font-poppins outline-transparent   select2">
                        <option value="">| Select Products  locations </option>
                        @forelse($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '-' }}>{{ $location->location_name }}
                        </option>
                        @empty
                        <option value="" disabled>No Locations</option>
                        @endforelse
                    </select>
                </div>
                @endif
                </div>

                
            </div>

            <h1 class="text-noti font-poppins font-medium ">{{ $text }} <span class="text-paraColor ml-6" id="selectedCount"></span></h1>

        </div>


    </div>
</div>