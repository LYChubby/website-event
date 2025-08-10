let currentPage = 1;
const perPage = 10;
let totalUsers = 0;

document.addEventListener("DOMContentLoaded", () => {
    loadUsers();
    initSearchAndFilter();
});

async function loadUsers(page = 1, search = "", role = "") {
    try {
        // Show loading state
        showLoadingState();

        let url = `/dashboard/api/organizer-list?page=${page}&per_page=${perPage}`;
        if (search) url += `&search=${encodeURIComponent(search)}`;
        if (role) url += `&role=${encodeURIComponent(role)}`;

        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        // Debugging: Log response structure
        console.log("API Response:", data);

        if (!data || !data.data) {
            throw new Error("Invalid response structure");
        }

        totalUsers = data.total || data.data.total || 0;
        renderUsers(data.data.items || data.data);
        renderPagination();
        updatePaginationInfo();
    } catch (error) {
        console.error("Error loading users:", error);
        showErrorState(error.message);
    }
}

function showLoadingState() {
    const tbody = document.getElementById("userTableBody");
    tbody.innerHTML = `
        <tr>
            <td colspan="7" class="py-12 text-center">
                <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[#5C6AD0]"></div>
                </div>
                <p class="mt-4 text-gray-500">Memuat data user...</p>
            </td>
        </tr>
    `;
}

function showErrorState(message = "Gagal memuat data") {
    const tbody = document.getElementById("userTableBody");
    tbody.innerHTML = `
        <tr>
            <td colspan="7" class="py-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-700">${message}</h4>
                <button onclick="loadUsers(currentPage)" 
                        class="mt-4 px-4 py-2 bg-[#5C6AD0] text-white rounded-lg hover:bg-[#4a58b8] transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i> Coba Lagi
                </button>
            </td>
        </tr>
    `;
}

// Fungsi renderUsers yang lebih robust
function renderUsers(users) {
    const tbody = document.getElementById("userTableBody");

    if (!users || users.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-[#5C6AD0]/10 rounded-full mb-4">
                        <i class="fas fa-user-slash text-2xl text-[#5C6AD0]"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-700">Tidak ada data user</h4>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = users
        .map(
            (user, index) => `
        <tr class="hover:bg-[#5C6AD0]/5 transition-colors duration-200 border-b border-gray-100 last:border-0">
            <td class="py-5 px-6 text-gray-600 font-medium">${
                (currentPage - 1) * perPage + index + 1
            }</td>
            <td class="py-5 px-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-[#5C6AD0]/10 to-[#684597]/10 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user text-[#5C6AD0]"></i>
                    </div>
                    <div>
                        <span class="block font-medium text-gray-800">${
                            user.name || "-"
                        }</span>
                        <span class="block text-xs text-gray-500 mt-1">ID: ${
                            user.user_id || "-"
                        }</span>
                    </div>
                </div>
            </td>
            <td class="py-5 px-6 text-gray-600">${user.email || "-"}</td>
            <td class="py-5 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${
                    user.role === "admin"
                        ? "bg-[#5C6AD0]/10 text-[#5C6AD0]"
                        : user.role === "organizer"
                        ? "bg-[#684597]/10 text-[#684597]"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${user.role || "-"}
                </span>
            </td>
            <td class="py-5 px-6 text-gray-600">${
                user.created_at
                    ? new Date(user.created_at).toLocaleDateString("id-ID")
                    : "-"
            }</td>
            <td class="py-5 px-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${
                    user.status === "Aktif"
                        ? "bg-green-100/80 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${user.status || "-"}
                </span>
            </td>
        </tr>
    `
        )
        .join("");
}

function renderPagination(total) {
    const totalPages = Math.ceil(total / perPage);
    const container = document.getElementById("userPagination");
    container.innerHTML = "";

    if (totalPages <= 1) return;

    // Previous Button
    const prevBtn = document.createElement("button");
    prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prevBtn.className = `px-4 py-2 rounded-lg border transition-all ${
        currentPage === 1
            ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
            : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0] border-[#5C6AD0]/20 hover:border-[#5C6AD0]/40"
    }`;
    prevBtn.disabled = currentPage === 1;
    prevBtn.addEventListener("click", () => {
        if (currentPage > 1)
            loadUsers(currentPage - 1, getSearchQuery(), getRoleFilter());
    });
    container.appendChild(prevBtn);

    // Page Numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    if (startPage > 1) {
        const firstPageBtn = document.createElement("button");
        firstPageBtn.textContent = "1";
        firstPageBtn.className =
            "px-4 py-2 mx-1 rounded-lg hover:bg-[#5C6AD0]/10 text-[#5C6AD0]";
        firstPageBtn.addEventListener("click", () =>
            loadUsers(1, getSearchQuery(), getRoleFilter())
        );
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
            i === currentPage
                ? "bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white shadow-md"
                : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0]"
        }`;
        pageBtn.addEventListener("click", () =>
            loadUsers(i, getSearchQuery(), getRoleFilter())
        );
        container.appendChild(pageBtn);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const ellipsis = document.createElement("span");
            ellipsis.className = "px-2 py-2 text-gray-400";
            ellipsis.textContent = "...";
            container.appendChild(ellipsis);
        }

        const lastPageBtn = document.createElement("button");
        lastPageBtn.textContent = totalPages;
        lastPageBtn.className =
            "px-4 py-2 mx-1 rounded-lg hover:bg-[#5C6AD0]/10 text-[#5C6AD0]";
        lastPageBtn.addEventListener("click", () =>
            loadUsers(totalPages, getSearchQuery(), getRoleFilter())
        );
        container.appendChild(lastPageBtn);
    }

    // Next Button
    const nextBtn = document.createElement("button");
    nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    nextBtn.className = `px-4 py-2 rounded-lg border transition-all ${
        currentPage === totalPages
            ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
            : "hover:bg-[#5C6AD0]/10 text-[#5C6AD0] border-[#5C6AD0]/20 hover:border-[#5C6AD0]/40"
    }`;
    nextBtn.disabled = currentPage === totalPages;
    nextBtn.addEventListener("click", () => {
        if (currentPage < totalPages)
            loadUsers(currentPage + 1, getSearchQuery(), getRoleFilter());
    });
    container.appendChild(nextBtn);
}

function updatePaginationInfo() {
    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, totalUsers);
    const infoElement = document.getElementById("userPaginationInfo");

    infoElement.innerHTML = `
        <span class="text-gray-600">Menampilkan <span class="font-semibold text-[#5C6AD0]">${start}-${end}</span> dari <span class="font-semibold">${totalUsers}</span> data</span>
    `;
}

function initSearchAndFilter() {
    const searchInput = document.getElementById("userSearch");
    const roleFilter = document.getElementById("roleFilter");

    // Debounce search
    let searchTimeout;
    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadUsers(1, searchInput.value, roleFilter.value);
        }, 500);
    });

    roleFilter.addEventListener("change", () => {
        loadUsers(1, searchInput.value, roleFilter.value);
    });
}

function getSearchQuery() {
    return document.getElementById("userSearch").value;
}

// Tambahkan style untuk toast animation
const style = document.createElement("style");
style.textContent = `
    @keyframes progressBar {
        from { width: 100%; }
        to { width: 0; }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    .animate-fade-out {
        animation: fadeOut 0.3s ease-in forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(20px); }
    }
`;
document.head.appendChild(style);

window.loadUsers = loadUsers;
window.initSearchAndFilter = initSearchAndFilter;
window.getSearchQuery = getSearchQuery;
window.currentPage = currentPage;
window.perPage = perPage;
window.totalUsers = totalUsers;
