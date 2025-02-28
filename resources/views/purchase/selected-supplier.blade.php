  
    <x-information title="Phone Number" subtitle="{{ $supplier->phone ?? '-'}}"/>
    <x-information title="Country" subtitle="{{ $supplier->country?->name ?? '-'}}"/>
    <x-information title="Address" subtitle="{{ $supplier->address ?? '-'}}"/>
