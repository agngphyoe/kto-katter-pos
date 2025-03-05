<tr class="text-center border-b ">
    @foreach ($columns as $column)
        <th class="px-6 animate__animated animate__fadeInTopLeft whitespace-nowrap py-3">
            {{ $column }}
        </th>
    @endforeach
</tr>
