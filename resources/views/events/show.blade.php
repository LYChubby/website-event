<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Search</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Log out
                    </a>
                </form>
            </div>
        </div>
    </x-slot>

    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 py-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Lainnya</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Anak, Keluarga</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="w-full h-64 bg-gray-200 overflow-hidden">
        <img src="{{ asset('storage/' . $event->event_image) }}" alt="{{ $event->name_event }}" class="w-full h-full object-cover">
    </div>

    <!-- Event Detail -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="md:flex">
                <div class="md:w-2/3 p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $event->name_event }}</h1>
                    <p class="text-gray-600 mb-4">{{ $event->venue_name }} | {{ $event->category->name ?? 'Kategori' }}</p>

                    <div class="flex items-center text-gray-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $event->venue_address }}</span>
                    </div>

                    <div class="flex items-center text-gray-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y, H:i') }} –
                            {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }} WIB
                        </span>
                    </div>

                    <div class="flex space-x-4 mb-6">
                        <button type="button" class="flex items-center px-4 py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Bagikan Event
                        </button>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tiket</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700 mb-4">Halo Mama Papa!</p>
                            <p class="text-gray-700 mb-4">{{ $event->description }}</p>
                            <p class="text-lg font-semibold text-gray-800">Harga Tiket: Rp 250.000,- <span class="text-sm text-gray-600">(*Berlaku untuk 1 anak + termasuk activity kit)</span></p>
                            <p class="text-gray-700 mt-2">Yuk pilih jadwal dan daftar sekarang!</p>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/3 bg-gray-50 p-6">
                    <div class="sticky top-6">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Tanggal</h3>
                            <!-- Date picker would go here -->
                            <div class="text-center py-4 text-gray-500">
                                Pilih tanggal tersedia
                            </div>
                        </div>

                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8">
        <div class="container mx-auto px-4 py-6 text-center text-gray-500 text-sm">
            Keamanan dan privasi
        </div>
    </footer>
</x-app-layout>