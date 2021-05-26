@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium uppercase text-sm text-gray-400']) }}>
    {{ $value ?? $slot }}
</label>
