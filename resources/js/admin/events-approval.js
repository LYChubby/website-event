export function initEventsApproval() {
    loadEvents();
    initEventSearch();
}

let currentPage = 1;
const perPage = 9;
let totalEvents = 0;

function loadEvents(page = 1, search = "", status = "pending") {
    currentPage = page;
    let url = `/admin/api/events?page=${page}&per_page=${perPage}&status=${status}`;

    if (search) {
        url += `&search=${encodeURIComponent(search)}`;
    }

    fetch(url, {
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            totalEvents = data.total;
            renderEvents(data.data);
            renderPagination();
            updatePaginationInfo();
            updateStats();
        })
        .catch((error) => {
            console.error("Error loading events:", error);
            showToast("error", "Gagal memuat data event");
            document
                .getElementById("noEventsMessage")
                .classList.remove("hidden");
        });
}

function renderEvents(events) {
    const container = document.getElementById("eventApprovalGrid");
    const noEventsMessage = document.getElementById("noEventsMessage");
    container.innerHTML = "";

    if (!events || events.length === 0) {
        noEventsMessage.classList.remove("hidden");
        return;
    }

    noEventsMessage.classList.add("hidden");

    events.forEach((event) => {
        const card = document.createElement("div");
        card.className =
            "bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300";

        const statusClass =
            event.status_approval === "pending"
                ? "status-pending"
                : event.status_approval === "approved"
                ? "status-approved"
                : "status-rejected";

        card.innerHTML = `
            <a href="/events/${event.event_id}" class="block">
                <div class="h-48 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                    ${
                        event.event_image
                            ? `<img src="/storage/${event.event_image}" class="w-full h-full object-cover" alt="${event.name_event}">`
                            : `<div class="text-center">
                            <i class="fas fa-calendar-alt text-4xl text-blue-300 mb-2"></i>
                            <p class="text-blue-500 font-medium">No Image</p>
                        </div>`
                    }
                </div>
            </a>
            <div class="p-6">
                <a href="/events/${event.event_id}" class="block">
                    <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">${
                        event.name_event
                    }</h3>
                </a>
                
                <div class="flex items-center mb-3">
                    <i class="fas fa-tag text-gray-400 mr-2"></i>
                    <span class="text-sm text-gray-600">${
                        event.category?.name || "-"
                    }</span>
                </div>
                
                <div class="flex items-center mb-3">
                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                    <span class="text-sm text-gray-600">
                        ${new Date(event.start_date).toLocaleDateString()} - 
                        ${new Date(event.end_date).toLocaleDateString()}
                    </span>
                </div>
                
                <div class="flex items-center justify-between mb-4">
                    <span class="status-badge ${statusClass}">${
            event.status_approval
        }</span>
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-user mr-1"></i>
                        ${event.organizer?.name || "Unknown"}
                    </span>
                </div>
                
                <div class="flex space-x-2">
                    <button onclick="approveEvent(${event.event_id})" 
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-xl transition-all duration-300 text-sm font-semibold">
                        <i class="fas fa-check mr-1"></i>
                        Setujui
                    </button>
                    <button onclick="rejectEvent(${event.event_id})" 
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-xl transition-all duration-300 text-sm font-semibold">
                        <i class="fas fa-times mr-1"></i>
                        Tolak
                    </button>
                </div>
            </div>
        `;

        container.appendChild(card);
    });
}

function renderPagination() {
    const totalPages = Math.ceil(totalEvents / perPage);
    const paginationContainer = document.getElementById("eventPagination");
    paginationContainer.innerHTML = "";

    if (totalPages <= 1) return;

    // Previous button
    const prevButton = document.createElement("button");
    prevButton.innerHTML = `<i class="fas fa-chevron-left"></i>`;
    prevButton.className = `px-3 py-1 rounded-lg border ${
        currentPage === 1
            ? "bg-gray-100 text-gray-400 cursor-not-allowed"
            : "hover:bg-blue-50 text-blue-600"
    }`;
    prevButton.disabled = currentPage === 1;
    prevButton.onclick = () => {
        if (currentPage > 1) {
            loadEvents(currentPage - 1, getSearchQuery(), getStatusFilter());
        }
    };
    paginationContainer.appendChild(prevButton);

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement("button");
        pageButton.textContent = i;
        pageButton.className = `px-3 py-1 rounded-lg mx-1 ${
            currentPage === i
                ? "bg-blue-600 text-white"
                : "hover:bg-blue-50 text-blue-600"
        }`;
        pageButton.onclick = () => {
            if (currentPage !== i) {
                loadEvents(i, getSearchQuery(), getStatusFilter());
            }
        };
        paginationContainer.appendChild(pageButton);
    }

    // Next button
    const nextButton = document.createElement("button");
    nextButton.innerHTML = `<i class="fas fa-chevron-right"></i>`;
    nextButton.className = `px-3 py-1 rounded-lg border ${
        currentPage === totalPages
            ? "bg-gray-100 text-gray-400 cursor-not-allowed"
            : "hover:bg-blue-50 text-blue-600"
    }`;
    nextButton.disabled = currentPage === totalPages;
    nextButton.onclick = () => {
        if (currentPage < totalPages) {
            loadEvents(currentPage + 1, getSearchQuery(), getStatusFilter());
        }
    };
    paginationContainer.appendChild(nextButton);
}

function updatePaginationInfo() {
    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, totalEvents);
    document.getElementById(
        "eventPaginationInfo"
    ).textContent = `Menampilkan ${start}-${end} dari ${totalEvents} data`;
}

function initEventSearch() {
    const searchInput = document.getElementById("eventSearch");

    // Debounce search
    let searchTimeout;
    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadEvents(1, searchInput.value, getStatusFilter());
        }, 500);
    });
}

function getSearchQuery() {
    return document.getElementById("eventSearch").value;
}

function getStatusFilter() {
    // Anda bisa menambahkan dropdown filter status jika diperlukan
    return "pending"; // Default filter pending events
}

function updateStats() {
    fetch("/admin/api/events/stats", {
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("approvedEvents").textContent =
                data.approved || "0";
            document.getElementById("pendingEvents").textContent =
                data.pending || "0";
            document.getElementById("rejectedEvents").textContent =
                data.rejected || "0";
        })
        .catch((error) => {
            console.error("Error loading stats:", error);
        });
}

window.approveEvent = function (eventId) {
    if (confirm("Yakin ingin menyetujui event ini?")) {
        fetch(`/admin/api/events/${eventId}/approve`, {
            method: "PUT",
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((err) => {
                        throw err;
                    });
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    showToast("success", "Event berhasil disetujui");
                    loadEvents(
                        currentPage,
                        getSearchQuery(),
                        getStatusFilter()
                    );
                } else {
                    throw new Error(data.message || "Gagal menyetujui event");
                }
            })
            .catch((error) => {
                console.error("Error approving event:", error);
                showToast(
                    "error",
                    error.message || "Terjadi kesalahan saat menyetujui event"
                );
            });
    }
};

window.rejectEvent = function (eventId) {
    if (confirm("Yakin ingin menolak event ini?")) {
        fetch(`/admin/api/events/${eventId}/reject`, {
            method: "PUT",
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((err) => {
                        throw err;
                    });
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    showToast("success", "Event berhasil ditolak");
                    loadEvents(
                        currentPage,
                        getSearchQuery(),
                        getStatusFilter()
                    );
                } else {
                    throw new Error(data.message || "Gagal menolak event");
                }
            })
            .catch((error) => {
                console.error("Error rejecting event:", error);
                showToast(
                    "error",
                    error.message || "Terjadi kesalahan saat menolak event"
                );
            });
    }
};
