@props(['value', 'required'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-white/80']) }}>
    {{ $value ?? $slot }}

    @isset($required)
        <span class="text-red-600 dark:text-red-500">*</span>
    @endisset
</label>
