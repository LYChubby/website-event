document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchEventInput");
    let debounceTimer;

    loadEvents();

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                loadEvents(searchInput.value);
            }, 500);
        });
    }
});

async function loadEvents(searchQuery = "") {
    try {
        showEventLoading();

        // Ambil organizer_id dari URL
        const pathParts = window.location.pathname.split("/");
        const userId = pathParts[pathParts.indexOf("organizer-list") + 1];

        let url = `/dashboard/api/organizer-list/${userId}/events`;
        if (searchQuery) {
            url += `?search=${encodeURIComponent(searchQuery)}`;
        }

        const response = await fetch(url);
        if (!response.ok) throw new Error("Gagal memuat data");

        const data = await response.json();
        renderEventCards(data.data);
    } catch (error) {
        console.error(error);
        showEventError("Gagal memuat data event");
    }
}

function showEventLoading() {
    document.getElementById("eventCardContainer").innerHTML = `
        <div class="col-span-full">
            <div class="bg-white rounded-2xl p-12 border border-gray-200 shadow-sm text-center">
                <div class="animate-spin h-12 w-12 border-4 border-gray-200 border-t-[#5C6AD0] rounded-full mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg font-medium">Memuat data event...</p>
                <p class="text-gray-400 text-sm mt-2">Mohon tunggu sebentar</p>
            </div>
        </div>
    `;
}

function showEventError(message) {
    document.getElementById("eventCardContainer").innerHTML = `
        <div class="col-span-full">
            <div class="bg-red-50 rounded-2xl p-12 border border-red-200 text-center">
                <div class="text-red-400 mb-4">
                    <i class="fas fa-exclamation-triangle text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-red-600 mb-2">Oops! Terjadi Kesalahan</h3>
                <p class="text-red-500">${message}</p>
                <button onclick="loadEvents()" class="mt-4 px-6 py-2 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-colors duration-300">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        </div>
    `;
}

function renderEventCards(events) {
    const container = document.getElementById("eventCardContainer");
    if (!events || events.length === 0) {
        container.innerHTML = `
            <div class="col-span-full">
                <div class="bg-white rounded-2xl p-16 border border-gray-200 shadow-sm text-center">
                    <div class="text-gray-300 mb-6">
                        <i class="fas fa-calendar-times text-6xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-4">Tidak Ada Event Ditemukan</h3>
                    <p class="text-gray-500 text-lg mb-6">Event dari organizer ini belum tersedia atau coba kata kunci lain</p>
                    <button onclick="document.getElementById('searchEventInput').value = ''; loadEvents();" 
                        class="px-6 py-3 bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white rounded-xl hover:from-[#4A5BC4] hover:to-[#5A3F85] transition-all duration-300">
                        <i class="fas fa-refresh mr-2"></i>Reset Pencarian
                    </button>
                </div>
            </div>
        `;
        return;
    }

    container.innerHTML = events
        .map((event, index) => {
            let imageUrl = event.event_image
                ? `/storage/${event.event_image}`
                : null;

            let eventDate = event.start_date
                ? new Date(event.start_date).toLocaleDateString("id-ID", {
                      day: "2-digit",
                      month: "short",
                      year: "numeric",
                  })
                : "-";

            return `
                <div class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-500 border border-gray-100 hover:border-[#5C6AD0]/30 hover:transform hover:scale-[1.02] animate-fade-in" style="animation-delay: ${
                    index * 100
                }ms;">
                    <!-- Image Container dengan overlay gradient -->
                    <div class="relative overflow-hidden">
                        ${
                            imageUrl
                                ? `
                            <img src="${imageUrl}" alt="${
                                      event.name_event || "-"
                                  }" 
                                class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-700">
                        `
                                : `
                            <div class="w-full h-52 bg-gradient-to-br from-[#5C6AD0] to-[#684597] flex items-center justify-center">
                                <div class="text-center text-white/70">
                                    <i class="fas fa-image text-3xl mb-2"></i>
                                    <p class="text-sm">Tidak ada gambar</p>
                                </div>
                            </div>
                        `
                        }
                        
                        <!-- Overlay gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Floating badge -->
                        <div class="absolute top-4 right-4">
                            <span class="bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg animate-pulse">
                                Event
                            </span>
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Event Title -->
                        <h2 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-[#5C6AD0] transition-colors duration-300 line-clamp-2">
                            ${event.name_event || "-"}
                        </h2>
                        
                        <!-- Event Date dengan icon -->
                        <div class="flex items-center mb-3 text-gray-600">
                            <i class="fas fa-calendar-alt mr-2 text-[#5C6AD0] group-hover:text-[#4A5BC4] transition-colors duration-300"></i>
                            <p class="text-sm font-medium">${eventDate}</p>
                        </div>
                        
                        <!-- Event Description -->
                        <p class="text-gray-500 text-sm mb-6 leading-relaxed line-clamp-3">
                            ${(
                                event.description ||
                                "Tidak ada deskripsi tersedia"
                            ).substring(0, 120)}${
                (event.description || "").length > 120 ? "..." : ""
            }
                        </p>
                        
                        <!-- Action Button dengan gradient -->
                        <a href="/events/${event.event_id}"
                            class="group/btn inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white font-semibold rounded-xl hover:from-[#4A5BC4] hover:to-[#5A3F85] transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="mr-2">Lihat Detail</span>
                            <i class="fas fa-arrow-right group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            `;
        })
        .join("");
}

window.loadEvents = loadEvents;

// Add CSS untuk animasi fade-in
const style = document.createElement("style");
style.textContent = `
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
`;
document.head.appendChild(style);
