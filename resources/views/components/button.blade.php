<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn py-3.5 text-base bg-purple border-purple text-white hover:bg-purple/[0.85] hover:border-purple/[0.85]']) }}>
    {{ $slot }}
</button>
