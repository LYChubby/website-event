// resources/js/admin/users.js
export function initUsers() {
    loadUsers();
    initUserModal();
    initSearchAndFilter();
}

let currentPage = 1;
const perPage = 10;
let totalUsers = 0;

function loadUsers(page = 1, search = "", role = "") {
    currentPage = page;
    let url = `/admin/api/users?page=${page}&per_page=${perPage}`;

    if (search) {
        url += `&search=${encodeURIComponent(search)}`;
    }

    if (role) {
        url += `&role=${encodeURIComponent(role)}`;
    }

    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            totalUsers = data.total;
            renderUsers(data.data);
            renderPagination();
            updatePaginationInfo();
        })
        .catch((error) => {
            console.error("Error loading users:", error);
        });
}

function renderUsers(users) {
    const tbody = document.getElementById("userTableBody");
    tbody.innerHTML = "";

    if (users.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-8 text-center text-gray-500">
                    <i class="fas fa-user-slash text-3xl mb-2"></i>
                    <p>Tidak ada data user</p>
                </td>
            </tr>
        `;
        return;
    }

    users.forEach((user, index) => {
        const row = document.createElement("tr");
        row.className = "hover:bg-blue-50 transition-colors duration-200";
        row.innerHTML = `
            <td class="py-4 px-2 text-gray-600 font-medium">${
                (currentPage - 1) * perPage + index + 1
            }</td>
            <td class="py-4 px-2">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-[#63A7F4] bg-opacity-10 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-[#63A7F4] text-sm"></i>
                    </div>
                    <span class="text-gray-700">${user.name}</span>
                </div>
            </td>
            <td class="py-4 px-2 text-gray-600">${user.email}</td>
            <td class="py-4 px-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold ${
                    user.role === "admin"
                        ? "bg-blue-100 text-blue-800"
                        : user.role === "organizer"
                        ? "bg-purple-100 text-purple-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${user.role}
                </span>
            </td>
            <td class="py-4 px-2 text-gray-600">${new Date(
                user.created_at
            ).toLocaleDateString()}</td>
            <td class="py-4 px-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold ${
                    user.status === "Aktif"
                        ? "bg-green-100 text-green-800"
                        : "bg-gray-100 text-gray-800"
                }">
                    ${user.status}
                </span>
            </td>
            <td class="py-4 px-2">
                <div class="flex space-x-2">
                   <button onclick="editUser('${user.user_id}', '${
            user.status
        }')" 
                            class="px-3 py-2 text-[#63A7F4] hover:bg-blue-50 rounded-lg transition-colors duration-200 text-sm font-medium">
                        <i class="fas fa-edit mr-1"></i>
                        Edit Status
                    </button>
                    <button onclick="deleteUser('${user.user_id}')" 
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
    const totalPages = Math.ceil(totalUsers / perPage);
    const paginationContainer = document.getElementById("userPagination");
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
            loadUsers(currentPage - 1, getSearchQuery(), getRoleFilter());
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
                loadUsers(i, getSearchQuery(), getRoleFilter());
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
            loadUsers(currentPage + 1, getSearchQuery(), getRoleFilter());
        }
    };
    paginationContainer.appendChild(nextButton);
}

function updatePaginationInfo() {
    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, totalUsers);
    document.getElementById(
        "userPaginationInfo"
    ).textContent = `Menampilkan ${start}-${end} dari ${totalUsers} data`;
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

function getRoleFilter() {
    return document.getElementById("roleFilter").value;
}

window.openUserModal = function (mode = "create") {
    const modal = document.getElementById("userModal");
    const modalContent = document.getElementById("userModalContent");
    const form = document.getElementById("userForm");

    // Hanya reset form jika mode create
    if (mode === "create") {
        form.reset();
        document.getElementById("userId").value = "";
        document.getElementById("passwordFields").style.display = "block";
    }

    if (mode === "create") {
        document.getElementById("userModalTitle").innerHTML =
            '<i class="fas fa-user-plus mr-3"></i>Tambah User';
        document.getElementById("createFields").style.display = "block";
    } else {
        document.getElementById("userModalTitle").innerHTML =
            '<i class="fas fa-user-edit mr-3"></i>Edit Status User';
        document.getElementById("createFields").style.display = "none";
    }

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
        modalContent.classList.add("scale-100", "opacity-100");
    }, 10);
};

window.closeUserModal = function () {
    const modal = document.getElementById("userModal");
    const modalContent = document.getElementById("userModalContent");

    modalContent.classList.add("scale-95", "opacity-0");
    modalContent.classList.remove("scale-100", "opacity-100");

    setTimeout(() => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        // Hanya reset form jika modal tertutup dari mode create
        if (document.getElementById("userId").value === "") {
            document.getElementById("userForm").reset();
        }
    }, 300);
};

window.editUser = function (id, status) {
    document.getElementById("userId").value = id;
    document.getElementById("userModalTitle").innerHTML =
        '<i class="fas fa-user-edit mr-3"></i>Edit Status User';

    document.getElementById("createFields").style.display = "none";

    // Uncheck all status first
    document.querySelectorAll('input[name="status"]').forEach((radio) => {
        radio.checked = false;
    });

    // Set status value
    document.querySelector(
        `input[name="status"][value="${status}"]`
    ).checked = true;

    openUserModal("edit");
};

function initUserModal() {
    document
        .getElementById("userForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            const id = document.getElementById("userId").value;
            const isEdit = !!id;
            const url = isEdit ? `/admin/api/users/${id}` : "/admin/api/users";

            const formData = new FormData();

            if (isEdit) {
                // For edit, only send status
                formData.append(
                    "status",
                    document.querySelector('input[name="status"]:checked').value
                );
                formData.append("_method", "PUT");
            } else {
                // For create, send all fields
                formData.append(
                    "name",
                    document.getElementById("userName").value
                );
                formData.append(
                    "email",
                    document.getElementById("userEmail").value
                );
                formData.append(
                    "role",
                    document.getElementById("userRole").value
                );
                formData.append(
                    "password",
                    document.getElementById("userPassword").value
                );
                formData.append(
                    "status",
                    document.querySelector('input[name="status"]:checked').value
                );
            }

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
                body: formData,
                credentials: "same-origin",
            })
                .then((response) => {
                    console.log("Raw response:", response);
                    return response.json();
                })
                .then((data) => {
                    console.log("Parsed response:", data);
                    if (data.success) {
                        closeUserModal();
                        loadUsers(
                            currentPage,
                            getSearchQuery(),
                            getRoleFilter()
                        );
                        showToast(
                            "success",
                            data.message ||
                                (isEdit
                                    ? "Status user berhasil diperbarui"
                                    : "User berhasil ditambahkan")
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
        .getElementById("userModal")
        .addEventListener("click", function (e) {
            if (e.target === this) {
                closeUserModal();
            }
        });
}

window.deleteUser = function (id) {
    if (confirm("Apakah Anda yakin ingin menghapus user ini?")) {
        fetch(`/admin/api/users/${id}`, {
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
                    loadUsers(currentPage, getSearchQuery(), getRoleFilter());
                    showToast("success", "User berhasil dihapus");
                } else {
                    showToast("error", data.message || "Gagal menghapus user");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showToast("error", "Terjadi kesalahan saat menghapus user");
            });
    }
};

function showToast(type, message) {
    const toast = document.createElement("div");
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium flex items-center ${
        type === "success" ? "bg-green-500" : "bg-red-500"
    }`;
    toast.innerHTML = `
        <i class="fas ${
            type === "success" ? "fa-check-circle" : "fa-exclamation-circle"
        } mr-2"></i>
        ${message}
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
