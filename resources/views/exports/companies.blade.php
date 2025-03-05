<table>
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Prefix
            </th>
            <th>
                Created By
            </th>
            <th>
                Created At
            </th>

        </tr>
    </thead>
    <tbody>
        <tr></tr>
        @forelse ($companies as $company)
        <tr class="bg-white border-b  ">
            <td class="px-6 py-3">{{ $company->name }}</td>
            <td class="px-6 py-3">{{ $company->prefix }}</td>
            <td class="px-6 py-3">{{ $company->user?->name }}</td>
            <td class="px-6 py-3">{{ dateFormat($company->created_at) }}</td>
        </tr>
        @empty

        @include('layouts.not-found', ['colSpan' => 5])

        @endforelse

    </tbody>
</table>