@if(auth()->user()->hasPermissions($permissionName))
    <a href="{{ route($routeName) }}" class="flex items-center text-white   gap-1 border border-primary bg-primary px-3 py-1  rounded-md">
        <i class="fa-solid fa-plus text-xs "></i>
        <h1 class="font-medium text-xs  font-jakarta">Add {{$text}}</h1>
    </a>
@endif