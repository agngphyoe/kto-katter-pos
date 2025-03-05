<li class="ml-4 group ">
    <a href="{{ $route }}" type="button" id="dropdown-toggle" data-dropdown="dropdown-1" class="flex items-center justify-between w-full  text-gray-900 transition duration-75 rounded-lg  px-2 py-2 group-hover:bg-bgMain group-hover:text-primary " aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
        <span class="flex-1 ml-3 text-left text-[14px] whitespace-nowrap " sidebar-toggle-item>

            <i {{ $attributes->merge(['class' => 'text-sm group-hover:text-primary   w-6  text-black opacity-70']) }}></i>

            {{ $text }}
        </span>
    </a>

</li>
