document.addEventListener("DOMContentLoaded", () => {
    loadTickets();
    document
        .getElementById("ticketForm")
        .addEventListener("submit", submitTicketForm);
});

function loadTickets() {
    fetch(`/tickets`)
        .then((res) => res.json())
        .then((tickets) => {
            const tbody = document.getElementById("ticketTableBody");
            tbody.innerHTML = "";

            if (tickets.length === 0) {
                tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-ticket-alt text-3xl mb-2 text-gray-300"></i>
                                    <p>Belum ada tiket dibuat</p>
                                </td>
                            </tr>
                        `;
                return;
            }

            tickets.forEach((ticket, index) => {
                const row = document.createElement("tr");
                row.className =
                    "hover:bg-blue-50 transition-colors duration-200";
                row.innerHTML = `
                            <td class="py-4 px-2 text-gray-600 font-medium">${
                                index + 1
                            }</td>
                            <td class="py-4 px-2 font-medium">${
                                ticket.ticket_code_prefix
                            }</td>
                            <td class="py-4 px-2">
                                <span class="px-2 py-1 rounded-full text-xs 
                                    ${
                                        ticket.jenis_ticket === "VVIP"
                                            ? "bg-purple-100 text-purple-800"
                                            : ticket.jenis_ticket === "VIP"
                                            ? "bg-blue-100 text-blue-800"
                                            : ticket.jenis_ticket === "Reguler"
                                            ? "bg-green-100 text-green-800"
                                            : "bg-gray-100 text-gray-800"
                                    }">
                                    ${ticket.jenis_ticket}
                                </span>
                            </td>
                            <td class="py-4 px-2">Rp ${new Intl.NumberFormat(
                                "id-ID"
                            ).format(ticket.price)}</td>
                            <td class="py-4 px-2">${
                                ticket.quantity_available
                            }</td>
                            <td class="py-4 px-2">${
                                ticket.quantity_sold || 0
                            }</td>
                            <td class="py-4 px-2 text-sm">
                                ${new Date(
                                    ticket.start_pesan
                                ).toLocaleDateString("id-ID")}<br>
                                ${new Date(ticket.end_pesan).toLocaleDateString(
                                    "id-ID"
                                )}
                            </td>
                            <td class="py-4 px-2">
                                <div class="flex space-x-2">
                                    <button onclick="editTicket(${
                                        ticket.ticket_id
                                    })" 
                                            class="px-3 py-2 text-[#63A7F4] hover:bg-blue-50 rounded-lg transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </button>
                                    <button onclick="deleteTicket(${
                                        ticket.ticket_id
                                    })" 
                                            class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        `;
                tbody.appendChild(row);
            });
        })
        .catch((error) => {
            console.error("Error loading tickets:", error);
            showToast("error", "Gagal memuat data tiket");
        });
}

window.openTicketModal = function (mode = "create") {
    const modal = document.getElementById("ticketModal");
    const modalContent = document.getElementById("modalContent");

    if (mode === "create") {
        document.getElementById("ticketId").value = "";
        document.getElementById("ticketForm").reset();
        document.getElementById("ticketModalTitle").innerHTML = `
                    <i class="fas fa-plus mr-3 text-[#63A7F4]"></i>
                    <span>Tambah Tiket</span>
                `;
    } else if (mode === "edit") {
        document.getElementById("ticketModalTitle").innerHTML = `
                    <i class="fas fa-edit mr-3 text-[#63A7F4]"></i>
                    <span>Edit Tiket</span>
                `;
    }

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
        modalContent.classList.add("scale-100", "opacity-100");
    }, 10);
};

window.closeTicketModal = function () {
    const modal = document.getElementById("ticketModal");
    const modalContent = document.getElementById("modalContent");

    modalContent.classList.add("scale-95", "opacity-0");
    modalContent.classList.remove("scale-100", "opacity-100");

    setTimeout(() => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }, 300);
};

window.editTicket = function (ticket_id) {
    fetch(`/tickets/${ticket_id}`)
        .then((res) => res.json())
        .then((ticket) => {
            document.getElementById("ticketId").value = ticket.ticket_id;
            document.getElementById("ticketCodePrefix").value =
                ticket.ticket_code_prefix;
            document.getElementById("jenisTicket").value = ticket.jenis_ticket;
            document.getElementById("price").value = ticket.price;
            document.getElementById("quantityAvailable").value =
                ticket.quantity_available;

            // Format datetime-local inputs
            const startDate = new Date(ticket.start_pesan);
            const endDate = new Date(ticket.end_pesan);

            document.getElementById("startPesan").value = startDate
                .toISOString()
                .slice(0, 16);
            document.getElementById("endPesan").value = endDate
                .toISOString()
                .slice(0, 16);

            openTicketModal("edit");
        })
        .catch((error) => {
            console.error("Error fetching ticket:", error);
            showToast("error", "Gagal memuat data tiket");
        });
};

function submitTicketForm(e) {
    e.preventDefault();

    const ticketId = document.getElementById("ticketId").value;
    const isEdit = Boolean(ticketId);
    const url = isEdit ? `/tickets/${ticketId}` : "/tickets";
    const method = isEdit ? "PUT" : "POST";

    const formData = new FormData(e.target);
    if (isEdit) formData.append("_method", "PUT");

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            Accept: "application/json",
        },
        body: formData,
    })
        .then((response) => {
            if (!response.ok) {
                return response.json().then((err) => {
                    throw err;
                });
            }
            return response.json();
        })
        .then((data) => {
            closeTicketModal();
            loadTickets();
            showToast(
                "success",
                isEdit ? "Tiket berhasil diperbarui" : "Tiket berhasil dibuat"
            );
        })
        .catch((error) => {
            console.error("Error submitting ticket:", error);
            const errorMsg =
                error.message || "Terjadi kesalahan saat menyimpan tiket";
            showToast("error", errorMsg);
        });
}

window.deleteTicket = function (ticket_id) {
    if (confirm("Yakin ingin menghapus tiket ini?")) {
        fetch(`/tickets/${ticket_id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then(() => {
                loadTickets();
                showToast("success", "Tiket berhasil dihapus");
            })
            .catch((error) => {
                console.error("Error deleting ticket:", error);
                showToast("error", "Gagal menghapus tiket");
            });
    }
};

// Close modal when clicking outside
// document.getElementById("ticketModal").addEventListener("click", function (e) {
//     if (e.target === this) {
//         closeTicketModal();
//     }
// });

// Close modal with Escape key
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        closeTicketModal();
    }
});

function showToast(type, message) {
    const toast = document.createElement("div");
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium flex items-center space-x-2 z-50 
                             ${
                                 type === "success"
                                     ? "bg-green-500"
                                     : "bg-red-500"
                             }`;
    toast.innerHTML = `
                <i class="fas ${
                    type === "success"
                        ? "fa-check-circle"
                        : "fa-exclamation-circle"
                }"></i>
                <span>${message}</span>
            `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add(
            "opacity-0",
            "translate-x-full",
            "transition-all",
            "duration-300"
        );
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
