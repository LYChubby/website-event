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
            const tbody = document.getElementById("eventTableBody");
            tbody.innerHTML = "";
            response.data.forEach((ev, index) => {
                tbody.innerHTML += `
                    <tr class="border-t">
                        <td class="p-3">${index + 1}</td>
                        <td class="p-3">${ev.name_event}</td>
                        <td class="p-3">${ev.category.name}</td>
                        <td class="p-3">${ev.start_date} - ${ev.end_date}</td>
                        <td class="p-3">${ev.status_approval}</td>
                        <td class="p-3 space-x-2">
                            <button onclick="approveEvent(${
                                ev.id
                            })" class="text-green-600 hover:underline">Setujui</button>
                            <button onclick="rejectEvent(${
                                ev.id
                            })" class="text-red-600 hover:underline">Tolak</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function approveEvent(id) {
    fetch(`/admin/events/${id}/approve`, { method: "POST" }).then(() =>
        loadEvents()
    );
}

function rejectEvent(id) {
    fetch(`/admin/events/${id}/reject`, { method: "POST" }).then(() =>
        loadEvents()
    );
}

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
