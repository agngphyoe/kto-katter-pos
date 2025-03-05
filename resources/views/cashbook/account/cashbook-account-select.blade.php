<option value="" class="px-10" selected disabled>Select Account Type
</option>
@foreach ($accounts as $account)
    <option value="{{ $account->id }}"
        {{ old('account_type_id') == $account->id ? 'selected' : '' }}>
        {{ $account->name }}
    </option>
@endforeach