<button type="button" id="dropdown-toggle" data-dropdown="dropdown-{{ $dropDownId }}"
    class="flex items-center justify-between w-full  text-gray-900 transition duration-75 rounded-lg    gap-3 group "
    aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
    <span
        class="flex-1 ml-3 text-left text-[15px] whitespace-nowrap group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-primary group-hover:via-secondary group-hover:to-primary  "
        sidebar-toggle-item>
        <i {{ $attributes->merge(['class' => 'w-10 text-black opacity-70']) }}></i>{{ $text }}
    </span>
    <i class="fa-solid fa-angle-down text-sm mr-3" onclick="toggleIcon(this)"></i>

</button>
