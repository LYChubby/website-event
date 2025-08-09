// resources/js/admin/organizer-verification.js
export function initOrganizers() {
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

    // Show loading state
    const tbody = document.getElementById("organizerTableBody");
    tbody.innerHTML = `
        <tr>
            <td colspan="5" class="py-12 text-center">
                <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[#5C6AD0]"></div>
                </div>
                <p class="mt-4 text-gray-500">Memuat data organizer...</p>
            </td>
        </tr>
    `;

    fetch(url)
        .then((res) => {
            if (!res.ok) throw new Error("Network response was not ok");
            return res.json();
        })
        .then((data) => {
            if (data.success) {
                renderOrganizers(data.data.items);
                renderPagination(data.data.meta);
                updatePaginationInfo(data.data.meta);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showToast("error", "Gagal memuat data organizer");
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        <i class="fas fa-exclamation-triangle text-3xl text-red-400 mb-2"></i>
                        <p>Gagal memuat data. Silakan coba lagi.</p>
                        <button onclick="loadOrganizers(currentPage)" class="mt-3 px-4 py-2 bg-[#5C6AD0] text-white rounded-lg hover:bg-[#4a58b8] transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i> Muat Ulang
                        </button>
                    </td>
                </tr>
            `;
        });
}

function renderPagination(meta) {
    const container = document.getElementById("organizerPagination");
    container.innerHTML = "";

    // Previous Button
    const prevBtn = document.createElement("button");
    prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prevBtn.className = `px-4 py-2 rounded-lg border transition-all ${
        meta.current_page === 1
            ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
            : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0] border-[#5C6AD0]/20 hover:border-[#5C6AD0]/40"
    }`;
    prevBtn.disabled = meta.current_page === 1;
    prevBtn.addEventListener("click", () => {
        if (meta.current_page > 1) loadOrganizers(meta.current_page - 1);
    });
    container.appendChild(prevBtn);

    // Page Numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(
        1,
        meta.current_page - Math.floor(maxVisiblePages / 2)
    );
    let endPage = Math.min(meta.last_page, startPage + maxVisiblePages - 1);

    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    if (startPage > 1) {
        const firstPageBtn = document.createElement("button");
        firstPageBtn.textContent = "1";
        firstPageBtn.className =
            "px-4 py-2 mx-1 rounded-lg hover:bg-[#5C6AD0]/10 text-[#5C6AD0]";
        firstPageBtn.addEventListener("click", () => loadOrganizers(1));
        container.appendChild(firstPageBtn);

        if (startPage > 2) {
            const ellipsis = document.createElement("span");
            ellipsis.className = "px-2 py-2 text-gray-400";
            ellipsis.textContent = "...";
            container.appendChild(ellipsis);
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = document.createElement("button");
        pageBtn.textContent = i;
        pageBtn.className = `px-4 py-2 mx-1 rounded-lg transition-all ${
            i === meta.current_page
                ? "bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white shadow-md"
                : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0]"
        }`;
        pageBtn.addEventListener("click", () => loadOrganizers(i));
        container.appendChild(pageBtn);
    }

    if (endPage < meta.last_page) {
        if (endPage < meta.last_page - 1) {
            const ellipsis = document.createElement("span");
            ellipsis.className = "px-2 py-2 text-gray-400";
            ellipsis.textContent = "...";
            container.appendChild(ellipsis);
        }

        const lastPageBtn = document.createElement("button");
        lastPageBtn.textContent = meta.last_page;
        lastPageBtn.className =
            "px-4 py-2 mx-1 rounded-lg hover:bg-[#5C6AD0]/10 text-[#5C6AD0]";
        lastPageBtn.addEventListener("click", () =>
            loadOrganizers(meta.last_page)
        );
        container.appendChild(lastPageBtn);
    }

    // Next Button
    const nextBtn = document.createElement("button");
    nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    nextBtn.className = `px-4 py-2 rounded-lg border transition-all ${
        meta.current_page === meta.last_page
            ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
            : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0] border-[#5C6AD0]/20 hover:border-[#5C6AD0]/40"
    }`;
    nextBtn.disabled = meta.current_page === meta.last_page;
    nextBtn.addEventListener("click", () => {
        if (meta.current_page < meta.last_page)
            loadOrganizers(meta.current_page + 1);
    });
    container.appendChild(nextBtn);
}

function updatePaginationInfo(meta) {
    const start = (meta.current_page - 1) * meta.per_page + 1;
    const end = Math.min(meta.current_page * meta.per_page, meta.total);
    const infoElement = document.getElementById("organizerPaginationInfo");

    infoElement.innerHTML = `
        <span class="text-gray-600">Menampilkan <span class="font-semibold text-[#5C6AD0]">${start}-${end}</span> dari <span class="font-semibold">${meta.total}</span> data</span>
    `;
}

function renderOrganizers(organizers) {
    const tbody = document.getElementById("organizerTableBody");
    tbody.innerHTML = "";

    if (organizers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-[#5C6AD0]/10 rounded-full mb-4">
                        <i class="fas fa-user-slash text-3xl text-[#5C6AD0]"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-700">Tidak ada data organizer</h4>
                    <p class="text-gray-500 mt-1">Coba gunakan kata kunci pencarian berbeda</p>
                </td>
            </tr>
        `;
        return;
    }

    organizers.forEach((org) => {
        if (!org.user) return;

        const row = document.createElement("tr");
        row.className =
            "hover:bg-[#5C6AD0]/5 transition-colors duration-200 border-b border-gray-100 last:border-0";
        row.innerHTML = `
            <td class="py-5 px-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-[#5C6AD0]/10 to-[#684597]/10 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-[#5C6AD0]"></i>
                    </div>
                    <div>
                        <span class="block font-medium text-gray-800">${
                            org.user.name
                        }</span>
                        <span class="block text-xs text-gray-500 mt-1">ID: ${
                            org.organizer_info_id
                        }</span>
                    </div>
                </div>
            </td>
            <td class="py-5 px-6">
                <div class="text-gray-700">
                    <span class="font-medium">${org.bank_account_name}</span>
                    <div class="flex items-center mt-1">
                        <span class="bg-[#5C6AD0]/10 text-[#5C6AD0] text-xs px-2 py-1 rounded">${
                            org.bank_code
                        }</span>
                        <span class="ml-2 font-mono">${
                            org.bank_account_number
                        }</span>
                    </div>
                </div>
            </td>
            <td class="py-5 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${
                    org.is_verified
                        ? "bg-green-100/80 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${
                        org.is_verified
                            ? '<i class="fas fa-check-circle mr-1.5"></i> Terverifikasi'
                            : '<i class="fas fa-clock mr-1.5"></i> Belum'
                    }
                </span>
            </td>
            <td class="py-5 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${
                    org.disbursement_ready
                        ? "bg-green-100/80 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${org.disbursement_ready ? "Siap" : "Belum"}
                </span>
            </td>
            <td class="py-5 px-6">
                <button onclick="toggleVerification(${
                    org.organizer_info_id
                }, ${!org.is_verified})" 
                    class="action-button px-4 py-2 rounded-lg transition-all ${
                        org.is_verified
                            ? "bg-amber-100/80 hover:bg-amber-200/80 text-amber-800"
                            : "bg-[#5C6AD0]/10 hover:bg-[#5C6AD0]/20 text-[#5C6AD0]"
                    } font-medium text-sm flex items-center">
                    ${
                        org.is_verified
                            ? '<i class="fas fa-times-circle mr-2"></i> Batalkan'
                            : '<i class="fas fa-check-circle mr-2"></i> Verifikasi'
                    }
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

window.toggleVerification = function (id, newStatus) {
    const confirmationMessage = newStatus
        ? "Anda akan memverifikasi organizer ini. Organizer yang sudah diverifikasi dapat melakukan pencairan dana."
        : "Anda akan membatalkan verifikasi organizer ini. Organizer tidak dapat melakukan pencairan dana sampai diverifikasi kembali.";

    Swal.fire({
        title: "Apakah Anda yakin?",
        html: `<p class="text-gray-700 mb-4">${confirmationMessage}</p>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5C6AD0",
        cancelButtonColor: "#d33",
        confirmButtonText: newStatus ? "Verifikasi" : "Batalkan",
        cancelButtonText: "Kembali",
        background: "white",
        backdrop: "rgba(92, 106, 208, 0.1)",
    }).then((result) => {
        if (result.isConfirmed) {
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
                        Swal.fire({
                            title: "Berhasil!",
                            text: data.message,
                            icon: "success",
                            confirmButtonColor: "#5C6AD0",
                            timer: 2000,
                            timerProgressBar: true,
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat memproses permintaan",
                        icon: "error",
                        confirmButtonColor: "#5C6AD0",
                    });
                });
        }
    });
};

function initSearch() {
    const searchInput = document.getElementById("organizerSearch");
    let searchTimeout;

    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchInput.classList.add("searching");

        searchTimeout = setTimeout(() => {
            loadOrganizers(1, searchInput.value);
            searchInput.classList.remove("searching");
        }, 500);
    });
}
