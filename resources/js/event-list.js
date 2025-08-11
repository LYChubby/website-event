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
        <div class="col-span-full text-center py-12">
            <div class="animate-spin h-10 w-10 border-t-2 border-b-2 border-[#5C6AD0] mx-auto"></div>
            <p class="mt-4 text-gray-500">Memuat data event...</p>
        </div>
    `;
}

function showEventError(message) {
    document.getElementById("eventCardContainer").innerHTML = `
        <div class="col-span-full text-center py-8 text-red-500">${message}</div>
    `;
}

function renderEventCards(events) {
    const container = document.getElementById("eventCardContainer");
    if (!events || events.length === 0) {
        container.innerHTML = `
            <div class="col-span-full text-center py-12 text-gray-500">
                Tidak ada event ditemukan
            </div>
        `;
        return;
    }

    container.innerHTML = events
        .map((event) => {
            let imageUrl = event.event_image
                ? `/storage/${event.event_image}`
                : `/images/no-image.jpg`;

            let eventDate = event.start_date
                ? new Date(event.start_date).toLocaleDateString("id-ID", {
                      day: "2-digit",
                      month: "short",
                      year: "numeric",
                  })
                : "-";

            return `
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="${imageUrl}" alt="${
                event.name_event || "-"
            }" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold mb-2">${
                            event.name_event || "-"
                        }</h2>
                        <p class="text-sm text-gray-500 mb-2">${eventDate}</p>
                        <p class="text-gray-700 text-sm mb-4">
                            ${(event.description || "").substring(0, 100)}...
                        </p>
                        <a href="/events/${event.event_id}" 
                           class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            `;
        })
        .join("");
}

window.loadEvents = loadEvents;
