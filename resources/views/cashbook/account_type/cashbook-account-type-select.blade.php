<option value="" class="px-10" selected disabled>Select Account Type
</option>
@foreach ($accountTypes as $accountType)
    <option value="{{ $accountType->id }}"
        {{ old('account_type_id') == $accountType->id ? 'selected' : '' }}>
        {{ $accountType->name }}
    </option>
@endforeach