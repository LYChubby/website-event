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
                <td colspan="6" class="py-8 text-center text-gray-500">
                    <i class="fas fa-tags text-3xl mb-2"></i>
                    <p>Tidak ada data kategori</p>
                </td>
            </tr>
        `;
        return;
    }

    categories.forEach((cat, index) => {
        const row = document.createElement("tr");
        row.className = "hover:bg-blue-50 transition-colors duration-200";
        row.innerHTML = `
            <td class="py-4 px-2 text-gray-600 font-medium">${
                (currentPage - 1) * perPage + index + 1
            }</td>
            <td class="py-4 px-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-[#63A7F4] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-tag text-[#63A7F4] text-sm"></i>
                    </div>
                    <span class="text-gray-700">${cat.name}</span>
                </div>
            </td>
            <td class="py-4 px-2 text-gray-600">${cat.events_count || 0}</td>
            <td class="py-4 px-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold ${
                    cat.is_active
                        ? "bg-green-100 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${cat.is_active ? "Aktif" : "Nonaktif"}
                </span>
            </td>
            <td class="py-4 px-2 text-gray-600">${new Date(
                cat.created_at
            ).toLocaleDateString()}</td>
            <td class="py-4 px-2">
                <div class="flex space-x-2">
                    <button onclick="editCategory('${cat.id}', '${cat.name}', ${
            cat.is_active
        })" 
                            class="px-3 py-2 text-[#63A7F4] hover:bg-blue-50 rounded-lg transition-colors duration-200 text-sm font-medium">
                        <i class="fas fa-edit mr-1"></i>
                        Edit
                    </button>
                    <button onclick="deleteCategory('${cat.id}')" 
                            class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 text-sm font-medium">
                        <i class="fas fa-trash mr-1"></i>
                        Hapus
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
    prevButton.className = `px-3 py-1 rounded-lg border ${
        currentPage === 1
            ? "bg-gray-100 text-gray-400 cursor-not-allowed"
            : "hover:bg-blue-50 text-blue-600"
    }`;
    prevButton.disabled = currentPage === 1;
    prevButton.onclick = () => {
        if (currentPage > 1) {
            loadCategories(currentPage - 1, getSearchQuery());
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
                loadCategories(i, getSearchQuery());
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
    document.querySelector(
        `input[name="is_active"][value="${isActive ? "1" : "0"}"]`
    ).checked = true;
    document.getElementById("categoryModalTitle").innerHTML =
        '<i class="fas fa-edit mr-3"></i>Edit Kategori';
    openCategoryModal("edit");
};

function initCategoryModal() {
    document
        .getElementById("categoryForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            const id = document.getElementById("categoryId").value;
            const isEdit = !!id;
            const url = isEdit
                ? `/admin/api/categories/${id}`
                : "/admin/api/categories";
            const method = isEdit ? "PUT" : "POST";

            const formData = new FormData(this);
            if (isEdit) formData.append("_method", "PUT");

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
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
                        showToast("error", data.message || "Terjadi kesalahan");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showToast("error", "Terjadi kesalahan saat menyimpan data");
                });
        });

    // Close modal when clicking outside
    document
        .getElementById("categoryModal")
        .addEventListener("click", function (e) {
            if (e.target === this) {
                closeCategoryModal();
            }
        });
}

window.deleteCategory = function (id) {
    if (confirm("Apakah Anda yakin ingin menghapus kategori ini?")) {
        fetch(`/admin/api/categories/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    loadCategories(currentPage, getSearchQuery());
                    showToast("success", "Kategori berhasil dihapus");
                } else {
                    showToast(
                        "error",
                        data.message || "Gagal menghapus kategori"
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showToast("error", "Terjadi kesalahan saat menghapus kategori");
            });
    }
};
