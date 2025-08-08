<!-- resources/views/components/page-header.blade.php -->
@props([
'bgColor' => 'bg-white', // default warna background
'darkBgColor' => 'dark:bg-[#684597]', // warna mode dark
])

<header {{ $attributes->merge([
    'class' => "$bgColor $darkBgColor shadow"
]) }}>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</header>