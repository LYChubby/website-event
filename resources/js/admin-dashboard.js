document.addEventListener("DOMContentLoaded", () => {
    loadCategories();
    loadEvents();

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
                tbody.innerHTML += `
                    <tr class="border-t">
                        <td class="p-3">${index + 1}</td>
                        <td class="p-3">${cat.name}</td>
                        <td class="p-3 space-x-2">
                            <button onclick="editCategory(${
                                cat.category_id
                            }, '${
                    cat.name
                }')" class="text-blue-600 hover:underline">Edit</button>
                            <button onclick="deleteCategory(${
                                cat.category_id
                            })" class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function loadEvents() {
    fetch("/admin/events")
        .then((res) => res.json())
        .then((response) => {
            const container = document.getElementById("eventApprovalGrid");
            container.innerHTML = "";

            response.data.forEach((ev) => {
                const card = document.createElement("div");
                card.className = "bg-white shadow rounded-xl overflow-hidden";

                card.innerHTML = `
                    <div class="h-40 bg-gray-200">
                        ${
                            ev.event_image
                                ? `<img src="/storage/${ev.event_image}" class="w-full h-full object-cover" />`
                                : ``
                        }
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-600">${
                            ev.name_event
                        }</h3>
                        <p class="text-sm text-gray-600 mb-2">${
                            ev.category?.name ?? "-"
                        }</p>
                        <p class="text-sm text-gray-600 mb-2">${
                            ev.start_date
                        } - ${ev.end_date}</p>
                        <p class="text-sm font-semibold mb-2">Status: <span class="capitalize">${
                            ev.status_approval
                        }</span></p>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button onclick="approveEvent(${
                                ev.event_id
                            })" class="text-green-600 text-sm hover:underline">Setujui</button>
                            <button onclick="rejectEvent(${
                                ev.event_id
                            })" class="text-red-600 text-sm hover:underline">Tolak</button>
                        </div>
                    </div>
                `;

                container.appendChild(card);
            });
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
                loadEvents(); // Refresh tabel
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
                loadEvents(); // Refresh tabel
            });
    }
};

window.openCategoryModal = function (mode = "create") {
    if (mode === "create") {
        document.getElementById("categoryId").value = "";
        document.getElementById("categoryName").value = "";
        document.getElementById("categoryModalTitle").textContent =
            "Tambah Kategori";
    } else if (mode === "edit") {
        document.getElementById("categoryModalTitle").textContent =
            "Edit Kategori";
    }

    document.getElementById("categoryModal").classList.remove("hidden");
    document.getElementById("categoryModal").classList.add("flex");
};

window.closeCategoryModal = function () {
    document.getElementById("categoryModal").classList.add("hidden");
    document.getElementById("categoryModal").classList.remove("flex");
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
        method: "POST", // always POST, spoof method if editing
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
        }).then(() => loadCategories());
    }
};
