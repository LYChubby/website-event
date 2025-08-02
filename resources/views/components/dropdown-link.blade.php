<a {{ $attributes->merge(['class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 transition-colors duration-200']) }} href="{{ $href }}">
    {{ $slot }}
</a>