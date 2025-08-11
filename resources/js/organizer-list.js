document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    let debounceTimer;

    // Initialize the page
    loadOrganizers();

    // Setup search functionality with debounce
    searchInput.addEventListener("input", function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            loadOrganizers(1, searchInput.value);
        }, 500);
    });
});

let currentPage = 1;
const itemsPerPage = 10;
let totalItems = 0;

async function loadOrganizers(page = 1, searchQuery = "") {
    try {
        currentPage = page;

        // Show loading state
        showLoadingState();

        // Build the API URL
        let url = `/dashboard/api/organizer-list?page=${page}&per_page=${itemsPerPage}`;
        if (searchQuery) {
            url += `&search=${encodeURIComponent(searchQuery)}`;
        }

        // Fetch data
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }

        const data = await response.json();

        // Update the UI
        totalItems = data.total || 0;
        renderOrganizers(data.data);
        renderPagination();
        updatePaginationInfo();
    } catch (error) {
        console.error("Error loading organizers:", error);
        showErrorState("Gagal memuat data organizer");
    }
}

function showLoadingState() {
    const tbody = document.getElementById("userTableBody");
    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="py-12 text-center">
                <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[#5C6AD0]"></div>
                </div>
                <p class="mt-4 text-gray-500">Memuat data organizer...</p>
            </td>
        </tr>
    `;
}

function showErrorState(message) {
    const tbody = document.getElementById("userTableBody");
    tbody.innerHTML = `
        <tr>
            <td colspan="6" class="py-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-700">${message}</h4>
                <button onclick="loadOrganizers()" 
                        class="mt-4 px-4 py-2 bg-[#5C6AD0] text-white rounded-lg hover:bg-[#4a58b8] transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i> Coba Lagi
                </button>
            </td>
        </tr>
    `;
}

function renderOrganizers(organizers) {
    const tbody = document.getElementById("userTableBody");

    if (!organizers || organizers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-[#5C6AD0]/10 rounded-full mb-4">
                        <i class="fas fa-user-slash text-2xl text-[#5C6AD0]"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-700">Tidak ada data organizer</h4>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = organizers
        .map(
            (organizer, index) => `
        <tr class="hover:bg-[#5C6AD0]/5 transition-colors duration-200 cursor-pointer"
        onclick="window.location.href='/dashboard/organizer-list/${organizer.user_id}/events'">
            <!-- No -->
            <td class="py-5 px-6 text-gray-600 font-medium">
                ${(currentPage - 1) * itemsPerPage + index + 1}
            </td>

            <!-- Nama -->
            <td class="py-5 px-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-[#5C6AD0]/10 to-[#684597]/10 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-[#5C6AD0]"></i>
                    </div>
                    <div>
                        <span class="block font-medium text-gray-800">
                            ${organizer.name || "-"}
                        </span>
                    </div>
                </div>
            </td>

            <!-- Status -->
            <td class="py-5 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${
                    organizer.status === "Aktif"
                        ? "bg-green-100/80 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${organizer.status || "-"}
                </span>
            </td>

            <!-- Jumlah Event -->
            <td class="py-5 px-6 text-gray-600 font-medium">
                ${organizer.total_events ?? 0}
            </td>
        </tr>
    `
        )
        .join("");
}


function renderPagination() {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const paginationContainer = document.getElementById("paginationControls");

    if (totalPages <= 1) {
        paginationContainer.innerHTML = "";
        return;
    }

    let paginationHTML = "";

    // Previous button
    paginationHTML += `
        <button onclick="loadOrganizers(${
            currentPage - 1
        }, document.getElementById('searchInput').value)" 
                ${currentPage === 1 ? "disabled" : ""}
                class="px-4 py-2 rounded-lg border ${
                    currentPage === 1
                        ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
                        : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0] border-[#5C6AD0]/20 hover:border-[#5C6AD0]/40"
                }">
            <i class="fas fa-chevron-left"></i>
        </button>
    `;

    // Page numbers
    const visiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(visiblePages / 2));
    let endPage = Math.min(totalPages, startPage + visiblePages - 1);

    if (endPage - startPage + 1 < visiblePages) {
        startPage = Math.max(1, endPage - visiblePages + 1);
    }

    if (startPage > 1) {
        paginationHTML += `
            <button onclick="loadOrganizers(1, document.getElementById('searchInput').value)" 
                    class="px-4 py-2 mx-1 rounded-lg hover:bg-[#5C6AD0]/10 text-[#5C6AD0]">
                1
            </button>
            ${
                startPage > 2
                    ? '<span class="px-2 py-2 text-gray-400">...</span>'
                    : ""
            }
        `;
    }

    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <button onclick="loadOrganizers(${i}, document.getElementById('searchInput').value)" 
                    class="px-4 py-2 mx-1 rounded-lg ${
                        i === currentPage
                            ? "bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white shadow-md"
                            : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0]"
                    }">
                ${i}
            </button>
        `;
    }

    if (endPage < totalPages) {
        paginationHTML += `
            ${
                endPage < totalPages - 1
                    ? '<span class="px-2 py-2 text-gray-400">...</span>'
                    : ""
            }
            <button onclick="loadOrganizers(${totalPages}, document.getElementById('searchInput').value)" 
                    class="px-4 py-2 mx-1 rounded-lg hover:bg-[#5C6AD0]/10 text-[#5C6AD0]">
                ${totalPages}
            </button>
        `;
    }

    // Next button
    paginationHTML += `
        <button onclick="loadOrganizers(${
            currentPage + 1
        }, document.getElementById('searchInput').value)" 
                ${currentPage === totalPages ? "disabled" : ""}
                class="px-4 py-2 rounded-lg border ${
                    currentPage === totalPages
                        ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
                        : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0] border-[#5C6AD0]/20 hover:border-[#5C6AD0]/40"
                }">
            <i class="fas fa-chevron-right"></i>
        </button>
    `;

    paginationContainer.innerHTML = paginationHTML;
}

function updatePaginationInfo() {
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, totalItems);
    const infoElement = document.getElementById("paginationInfo");

    infoElement.innerHTML = `
        <span class="text-gray-600">Menampilkan <span class="font-semibold text-[#5C6AD0]">${startItem}-${endItem}</span> dari <span class="font-semibold">${totalItems}</span> data</span>
    `;
}

// Make functions available globally
window.loadOrganizers = loadOrganizers;
