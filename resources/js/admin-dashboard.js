document.addEventListener("DOMContentLoaded", () => {
    loadCategories();
    loadEvents();
    updateStats();

    document
        .getElementById("categoryForm")
        .addEventListener("submit", submitCategoryForm);
});

function loadCategories() {
    fetch("/categories")
        .then((res) => res.json())
        .then((categories) => {
            const tbody = document.getElementById("categoryTableBody");
            tbody.innerHTML = "";
            categories.forEach((cat, index) => {
                const row = document.createElement("tr");
                row.className =
                    "hover:bg-blue-50 dark:hover:bg-blue-100 transition-colors duration-200";
                row.innerHTML = `
                            <td class="py-4 px-2 text-gray-600 dark:text-gray-400 font-medium">${
                                index + 1
                            }</td>
                            <td class="py-4 px-2">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-[#63A7F4] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-tag text-[#63A7F4] text-sm"></i>
                                    </div>
                                    <span class="text-gray-700">${
                                        cat.name
                                    }</span>
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <div class="flex space-x-2">
                                    <button onclick="editCategory(${
                                        cat.category_id
                                    }, '${cat.name}')" 
                                            class="px-3 py-2 text-[#63A7F4] hover:bg-blue-50 dark:hover:bg-blue-500 rounded-lg transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                    <button onclick="deleteCategory(${
                                        cat.category_id
                                    })" 
                                            class="px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-500 rounded-lg transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        `;
                tbody.appendChild(row);
            });
            updateStats();
        })
        .catch((error) => {
            console.error("Error loading categories:", error);
            // Fallback jika fetch gagal - tampilkan pesan error atau data dummy
        });
}

function loadEvents() {
    fetch("/admin/events")
        .then((res) => res.json())
        .then((response) => {
            const container = document.getElementById("eventApprovalGrid");
            const noEventsMessage = document.getElementById("noEventsMessage");
            container.innerHTML = "";

            if (!response.data || response.data.length === 0) {
                noEventsMessage.classList.remove("hidden");
                return;
            }

            noEventsMessage.classList.add("hidden");

            response.data.forEach((ev) => {
                const card = document.createElement("div");
                card.className = card.className =
                    "bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300";

                const statusClass =
                    ev.status_approval === "pending"
                        ? "status-pending"
                        : ev.status_approval === "approved"
                        ? "status-approved"
                        : "status-rejected";

                card.innerHTML = `
                            <a href="/events/${ev.event_id}" class="block">
                                <div class="h-48 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                    ${
                                        ev.event_image
                                            ? `<img src="/storage/${ev.event_image}" class="w-full h-full object-cover" alt="${ev.name_event}" />`
                                            : `<div class="text-center">
                                            <i class="fas fa-calendar-alt text-4xl text-blue-300 mb-2"></i>
                                            <p class="text-blue-500 font-medium">No Image</p>
                                        </div>`
                                    }
                                </div>
                            </a>
                            <div class="p-6">
                                <a href="/events/${ev.event_id}" class="block">
                                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-700 mb-2 line-clamp-2">${
                                        ev.name_event
                                    }</h3>
                                </a>
                                
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-tag text-gray-400 mr-2"></i>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">${
                                        ev.category?.name ?? "-"
                                    }</span>
                                </div>
                                
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">${
                                        ev.start_date
                                    } - ${ev.end_date}</span>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <span class="status-badge ${statusClass}">${
                    ev.status_approval
                }</span>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button onclick="approveEvent(${
                                        ev.event_id
                                    })" 
                                            class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-xl transition-all duration-300 text-sm font-semibold">
                                        <i class="fas fa-check mr-1"></i>
                                        Setujui
                                    </button>
                                    <button onclick="rejectEvent(${
                                        ev.event_id
                                    })" 
                                            class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-xl transition-all duration-300 text-sm font-semibold">
                                        <i class="fas fa-times mr-1"></i>
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        `;

                container.appendChild(card);
            });
            updateStats();
        })
        .catch((error) => {
            console.error("Error loading events:", error);
            document
                .getElementById("noEventsMessage")
                .classList.remove("hidden");
        });
}

function updateStats() {
    // Update kategori count
    fetch("/categories")
        .then((res) => res.json())
        .then((categories) => {
            document.getElementById("totalCategories").textContent =
                categories.length;
        })
        .catch(() => {
            document.getElementById("totalCategories").textContent = "0";
        });

    // Update events stats
    fetch("/admin/events")
        .then((res) => res.json())
        .then((response) => {
            if (response.data) {
                const approved = response.data.filter(
                    (e) => e.status_approval === "approved"
                ).length;
                const pending = response.data.filter(
                    (e) => e.status_approval === "pending"
                ).length;

                document.getElementById("approvedEvents").textContent =
                    approved;
                document.getElementById("pendingEvents").textContent = pending;
            }
        })
        .catch(() => {
            document.getElementById("approvedEvents").textContent = "0";
            document.getElementById("pendingEvents").textContent = "0";
        });
}

window.approveEvent = function (id) {
    if (confirm("Yakin ingin menyetujui event ini?")) {
        fetch(`/admin/events/${id}/approve`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((res) => res.json())
            .then(() => {
                alert("Event berhasil disetujui.");
                loadEvents();
            })
            .catch((error) => {
                console.error("Error approving event:", error);
                alert("Terjadi kesalahan saat menyetujui event.");
            });
    }
};

window.rejectEvent = function (id) {
    if (confirm("Yakin ingin menolak event ini?")) {
        fetch(`/admin/events/${id}/reject`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((res) => res.json())
            .then(() => {
                alert("Event berhasil ditolak.");
                loadEvents();
            })
            .catch((error) => {
                console.error("Error rejecting event:", error);
                alert("Terjadi kesalahan saat menolak event.");
            });
    }
};

window.openCategoryModal = function (mode = "create") {
    const modal = document.getElementById("categoryModal");
    const modalContent = document.getElementById("modalContent");

    if (mode === "create") {
        document.getElementById("categoryId").value = "";
        document.getElementById("categoryName").value = "";
        document.getElementById("categoryModalTitle").innerHTML =
            '<i class="fas fa-plus mr-3"></i>Tambah Kategori';
    } else if (mode === "edit") {
        document.getElementById("categoryModalTitle").innerHTML =
            '<i class="fas fa-edit mr-3"></i>Edit Kategori';
    }

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    // Animate modal
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

window.editCategory = function (category_id, name) {
    document.getElementById("categoryId").value = category_id;
    document.getElementById("categoryName").value = name;
    openCategoryModal("edit");
};

function submitCategoryForm(e) {
    e.preventDefault();
    const id = document.getElementById("categoryId").value;
    const name = document.getElementById("categoryName").value;

    const isEdit = Boolean(id);
    const url = isEdit ? `/categories/${id}` : "/categories";

    const formData = new FormData();
    formData.append("name", name);
    if (isEdit) formData.append("_method", "PUT");

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: formData,
    })
        .then((res) => res.json())
        .then(() => {
            closeCategoryModal();
            loadCategories();
        })
        .catch((error) => {
            console.error("Error submitting category form:", error);
            alert("Terjadi kesalahan saat menyimpan kategori.");
        });
}

window.deleteCategory = function (category_id) {
    if (confirm("Yakin ingin menghapus kategori ini?")) {
        fetch(`/categories/${category_id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then(() => {
                loadCategories();
            })
            .catch((error) => {
                console.error("Error deleting category:", error);
                alert("Terjadi kesalahan saat menghapus kategori.");
            });
    }
};

// Close modal when clicking outside
document
    .getElementById("categoryModal")
    .addEventListener("click", function (e) {
        if (e.target === this) {
            closeCategoryModal();
        }
    });

// Close modal with Escape key
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        closeCategoryModal();
    }
});
