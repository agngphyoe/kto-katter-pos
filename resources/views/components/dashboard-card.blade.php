<div class="bg-[#F8F8F8] mb-6 animate__animated animate__zoomIn  w-full md:w-[200px]  shadow-primary shadow-sm relative rounded-[20px]  pb-8 pt-10">
    <a href="{{$routeName}}">
        <h1 class="text-primary font-semibold text-center text-lg">{{ $title }}</h1>
    </a>
    <div class="w-12 h-12 absolute -top-6 left-[38%] bg-primary text-white rounded-full flex items-center justify-center">
        {{ $slot }}
    </div>
</div>