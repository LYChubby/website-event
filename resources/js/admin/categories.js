// resources/js/admin/categories.js
export function initCategories() {
    loadCategories();
    updateStats();
    initCategoryModal();
    initCategorySearch();
}

let currentPage = 1;
const perPage = 10;
let totalCategories = 0;

function loadCategories(page = 1, search = "") {
    currentPage = page;
    let url = `/admin/api/categories?page=${page}&per_page=${perPage}`;

    if (search) {
        url += `&search=${encodeURIComponent(search)}`;
    }

    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            totalCategories = data.total;
            renderCategories(data.data);
            renderPagination();
            updatePaginationInfo();
            updateStats();
        })
        .catch((error) => {
            console.error("Error loading categories:", error);
            showToast("error", "Gagal memuat data kategori");
        });
}

function renderCategories(categories) {
    const tbody = document.getElementById("categoryTableBody");
    tbody.innerHTML = "";

    if (categories.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-16 text-center">
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <div class="w-20 h-20 bg-gradient-to-r from-[#5C6AD0] to-[#684597] rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-tags text-3xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Kategori</h3>
                            <p class="text-gray-500">Tambahkan kategori pertama Anda untuk memulai</p>
                        </div>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    categories.forEach((cat, index) => {
        const row = document.createElement("tr");
        row.className =
            "hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-purple-50/50 transition-all duration-300 group";
        row.innerHTML = `
            <td class="py-6 px-6">
                <div class="w-8 h-8 bg-gradient-to-r from-[#5C6AD0] to-[#684597] rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">
                    ${(currentPage - 1) * perPage + index + 1}
                </div>
            </td>
            <td class="py-6 px-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#5C6AD0]/10 to-[#684597]/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-tag text-[#5C6AD0] text-lg"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800 text-lg">${
                            cat.name
                        }</div>
                        <div class="text-sm text-gray-500">ID: ${
                            cat.category_id
                        }</div>
                    </div>
                </div>
            </td>
            <td class="py-6 px-6">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                    <span class="text-gray-700 font-medium">${
                        cat.events_count || 0
                    } event</span>
                </div>
            </td>
            <td class="py-6 px-6">
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold ${
                    cat.is_active
                        ? "bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200"
                        : "bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border border-gray-300"
                }">
                    <div class="w-2 h-2 rounded-full mr-2 ${
                        cat.is_active ? "bg-emerald-500" : "bg-gray-400"
                    }"></div>
                    ${cat.is_active ? "Aktif" : "Nonaktif"}
                </div>
            </td>
            <td class="py-6 px-6">
                <div class="flex items-center space-x-2 text-gray-600">
                    <i class="fas fa-calendar text-[#5C6AD0]"></i>
                    <span>${new Date(cat.created_at).toLocaleDateString(
                        "id-ID",
                        {
                            day: "numeric",
                            month: "short",
                            year: "numeric",
                        }
                    )}</span>
                </div>
            </td>
            <td class="py-6 px-6">
                <div class="flex items-center space-x-2">
                    <button onclick="editCategory('${cat.category_id}', '${
            cat.name
        }', ${cat.is_active})" 
                        class="group px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-[#5C6AD0] hover:to-[#684597] text-[#5C6AD0] hover:text-white rounded-xl transition-all duration-300 text-sm font-semibold shadow-sm hover:shadow-md flex items-center space-x-2">
                        <i class="fas fa-edit group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Edit</span>
                    </button>
                    <button onclick="deleteCategory('${cat.category_id}')" 
                        class="group px-4 py-2 bg-gradient-to-r from-red-50 to-pink-50 hover:from-red-500 hover:to-red-600 text-red-600 hover:text-white rounded-xl transition-all duration-300 text-sm font-semibold shadow-sm hover:shadow-md flex items-center space-x-2">
                        <i class="fas fa-trash group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function renderPagination() {
    const totalPages = Math.ceil(totalCategories / perPage);
    const paginationContainer = document.getElementById("categoryPagination");
    paginationContainer.innerHTML = "";

    if (totalPages <= 1) return;

    // Previous button
    const prevButton = document.createElement("button");
    prevButton.innerHTML = `<i class="fas fa-chevron-left"></i>`;
    prevButton.className = `px-4 py-2 rounded-xl border-2 transition-all duration-300 ${
        currentPage === 1
            ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
            : "bg-white hover:bg-gradient-to-r hover:from-[#5C6AD0] hover:to-[#684597] text-[#5C6AD0] hover:text-white border-[#5C6AD0] shadow-sm hover:shadow-md"
    }`;
    prevButton.disabled = currentPage === 1;
    prevButton.onclick = () => {
        if (currentPage > 1) {
            loadCategories(currentPage - 1, getSearchQuery());
        }
    };
    paginationContainer.appendChild(prevButton);

    // Page numbers (show max 5 pages)
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, startPage + 4);

    for (let i = startPage; i <= endPage; i++) {
        const pageButton = document.createElement("button");
        pageButton.textContent = i;
        pageButton.className = `px-4 py-2 rounded-xl mx-1 transition-all duration-300 font-semibold ${
            currentPage === i
                ? "bg-gradient-to-r from-[#5C6AD0] to-[#684597] text-white shadow-lg scale-105"
                : "bg-white hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 text-[#5C6AD0] border-2 border-[#5C6AD0] hover:border-[#684597] shadow-sm hover:shadow-md"
        }`;
        pageButton.onclick = () => {
            if (currentPage !== i) {
                loadCategories(i, getSearchQuery());
            }
        };
        paginationContainer.appendChild(pageButton);
    }

    // Next button
    const nextButton = document.createElement("button");
    nextButton.innerHTML = `<i class="fas fa-chevron-right"></i>`;
    nextButton.className = `px-4 py-2 rounded-xl border-2 transition-all duration-300 ${
        currentPage === totalPages
            ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
            : "bg-white hover:bg-gradient-to-r hover:from-[#5C6AD0] hover:to-[#684597] text-[#5C6AD0] hover:text-white border-[#5C6AD0] shadow-sm hover:shadow-md"
    }`;
    nextButton.disabled = currentPage === totalPages;
    nextButton.onclick = () => {
        if (currentPage < totalPages) {
            loadCategories(currentPage + 1, getSearchQuery());
        }
    };
    paginationContainer.appendChild(nextButton);
}

function updatePaginationInfo() {
    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, totalCategories);
    document.getElementById(
        "categoryPaginationInfo"
    ).textContent = `Menampilkan ${start}-${end} dari ${totalCategories} data`;
}

function initCategorySearch() {
    const searchInput = document.getElementById("categorySearch");

    // Debounce search
    let searchTimeout;
    searchInput.addEventListener("input", () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadCategories(1, searchInput.value);
        }, 500);
    });
}

function getSearchQuery() {
    return document.getElementById("categorySearch").value;
}

function updateStats() {
    fetch("/admin/api/categories/stats")
        .then((res) => res.json())
        .then((data) => {
            document.getElementById("totalCategories").textContent =
                data.total_categories || "0";
            document.getElementById("activeCategories").textContent =
                data.active_categories || "0";
            document.getElementById("totalEvents").textContent =
                data.total_events || "0";
        })
        .catch((error) => {
            console.error("Error loading stats:", error);
        });
}

window.openCategoryModal = function (mode = "create") {
    const modal = document.getElementById("categoryModal");
    const modalContent = document.getElementById("modalContent");

    if (mode === "create") {
        document.getElementById("categoryId").value = "";
        document.getElementById("categoryName").value = "";
        document.getElementById("categoryModalTitle").innerHTML =
            '<i class="fas fa-plus mr-3"></i>Tambah Kategori';
        // Set default status to active
        document.querySelector(
            'input[name="is_active"][value="1"]'
        ).checked = true;
    }

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
        modalContent.classList.add("scale-100", "opacity-100");
    }, 10);
};

window.closeCategoryModal = function () {
    const modal = document.getElementById("categoryModal");
    const modalContent = document.getElementById("modalContent");

    modalContent.classList.add("scale-95", "opacity-0");
    modalContent.classList.remove("scale-100", "opacity-100");

    setTimeout(() => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }, 300);
};

window.editCategory = function (id, name, isActive) {
    document.getElementById("categoryId").value = id;
    document.getElementById("categoryName").value = name;

    // Uncheck all radio buttons first
    document.querySelectorAll('input[name="is_active"]').forEach((radio) => {
        radio.checked = false;
    });

    // Check the correct radio button (convert boolean to string)
    const activeValue = isActive ? "1" : "0";
    document.querySelector(
        `input[name="is_active"][value="${activeValue}"]`
    ).checked = true;

    document.getElementById("categoryModalTitle").innerHTML =
        '<i class="fas fa-edit mr-3"></i>Edit Kategori';
    openCategoryModal("edit");
};

function initCategoryModal() {
    document
        .getElementById("categoryForm")
        .addEventListener("submit", async function (e) {
            e.preventDefault();

            const id = document.getElementById("categoryId").value;
            const isEdit = !!id;
            const url = isEdit
                ? `/admin/api/categories/${id}`
                : "/admin/api/categories";

            const formData = new FormData();
            formData.append(
                "name",
                document.getElementById("categoryName").value
            );
            formData.append(
                "is_active",
                document.querySelector('input[name="is_active"]:checked').value
            );

            if (isEdit) {
                formData.append("_method", "PUT");
            }

            try {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        Accept: "application/json",
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || "Terjadi kesalahan");
                }

                if (data.success) {
                    closeCategoryModal();
                    loadCategories(currentPage, getSearchQuery());
                    showToast(
                        "success",
                        data.message ||
                            (isEdit
                                ? "Kategori berhasil diperbarui"
                                : "Kategori berhasil ditambahkan")
                    );
                } else {
                    throw new Error(data.message || "Terjadi kesalahan");
                }
            } catch (error) {
                console.error("Error:", error);
                showToast(
                    "error",
                    error.message || "Terjadi kesalahan saat menyimpan data"
                );
            }
        });
}

window.deleteCategory = function (id) {
    Swal.fire({
        title: "Hapus Kategori?",
        html: `<p class="text-gray-700 mb-4">Kategori yang dihapus tidak dapat dikembalikan. Pastikan tidak ada event yang terkait dengan kategori ini.</p>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5C6AD0",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        backdrop: "rgba(92, 106, 208, 0.1)",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(`/admin/api/categories/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch((error) => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.success) {
                loadCategories(currentPage, getSearchQuery());
                Swal.fire({
                    title: "Terhapus!",
                    text: "Kategori berhasil dihapus",
                    icon: "success",
                    confirmButtonColor: "#5C6AD0",
                    timer: 2000,
                    timerProgressBar: true,
                });
            } else {
                Swal.fire({
                    title: "Gagal!",
                    text: result.value.message || "Gagal menghapus kategori",
                    icon: "error",
                    confirmButtonColor: "#5C6AD0",
                });
            }
        }
    });
};
