// resources/js/admin/organizer-verification.js
export function initOrganizerVerification() {
    loadOrganizers();
    initSearch();
}

let currentPage = 1;
const perPage = 10;

function loadOrganizers(page = 1, search = "") {
    currentPage = page;
    let url = `/admin/api/organizers?page=${page}&per_page=${perPage}`;

    if (search) {
        url += `&search=${encodeURIComponent(search)}`;
    }

    fetch(url)
        .then((res) => {
            if (!res.ok) throw new Error("Network response was not ok");
            return res.json();
        })
        .then((data) => {
            if (data.success) {
                renderOrganizers(data.data.data); // Sesuaikan dengan struktur response
                renderPagination(data.data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showToast("error", "Gagal memuat data organizer");
        });
}

function renderOrganizers(organizers) {
    const tbody = document.getElementById("organizerTableBody");
    tbody.innerHTML = "";

    if (organizers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="py-8 text-center text-gray-500">
                    <i class="fas fa-user-slash text-3xl mb-2"></i>
                    <p>Tidak ada data organizer</p>
                </td>
            </tr>
        `;
        return;
    }

    organizers.forEach((org) => {
        if (!org.user) return; // Skip jika user tidak ada

        const row = document.createElement("tr");
        row.className = "hover:bg-blue-50 transition-colors duration-200";
        row.innerHTML = `
            <td class="py-4 px-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-blue-600 text-sm"></i>
                    </div>
                    <span class="text-gray-700">${org.user.name}</span>
                </div>
            </td>
            <td class="py-4 px-2 text-gray-600">
                ${org.bank_account_name}<br>
                ${org.bank_account_number} (${org.bank_code})
            </td>
            <td class="py-4 px-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold ${
                    org.is_verified
                        ? "bg-green-100 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${org.is_verified ? "Terverifikasi" : "Belum"}
                </span>
            </td>
            <td class="py-4 px-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold ${
                    org.disbursement_ready
                        ? "bg-green-100 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${org.disbursement_ready ? "Siap" : "Belum"}
                </span>
            </td>
            <td class="py-4 px-2">
                <button onclick="toggleVerification(${
                    org.organizer_info_id
                }, ${!org.is_verified})" 
                        class="px-3 py-2 ${
                            org.is_verified
                                ? "bg-yellow-100 text-yellow-800 hover:bg-yellow-200"
                                : "bg-blue-100 text-blue-800 hover:bg-blue-200"
                        } rounded-lg transition-colors duration-200 text-sm font-medium">
                    ${org.is_verified ? "Batalkan Verifikasi" : "Verifikasi"}
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function toggleVerification(id, newStatus) {
    if (
        confirm(
            `Anda yakin ingin ${
                newStatus ? "memverifikasi" : "membatalkan verifikasi"
            } organizer ini?`
        )
    ) {
        fetch(`/admin/api/organizers/${id}/verification`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                is_verified: newStatus,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    loadOrganizers(
                        currentPage,
                        document.getElementById("organizerSearch").value
                    );
                    showToast("success", data.message);
                }
            });
    }
}

function initSearch() {
    const searchInput = document.getElementById("organizerSearch");
    let searchTimeout;

    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadOrganizers(1, searchInput.value);
        }, 500);
    });
}

document.addEventListener("DOMContentLoaded", initOrganizers);
