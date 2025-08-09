// JavaScript functionality from your original file will be included here
document.addEventListener("DOMContentLoaded", () => {
    loadTickets();
    loadTicketStatistics();
    document
        .getElementById("ticketForm")
        .addEventListener("submit", submitTicketForm);

    setInterval(() => {
        loadTickets();
        loadTicketStatistics();
    }, 30000);
});

function loadTicketStatistics() {
    const eventId = document.getElementById("eventId").value;

    fetch(`/events/${eventId}/tickets`)
        .then((res) => res.json())
        .then((response) => {
            const tickets = response.data;

            let totalTickets = 0;
            let availableTickets = 0;
            let soldTickets = 0;

            tickets.forEach((ticket) => {
                totalTickets +=
                    parseInt(ticket.quantity_available) +
                    parseInt(ticket.quantity_sold);
                availableTickets += parseInt(ticket.quantity_available);
                soldTickets += parseInt(ticket.quantity_sold);
            });

            const soldPercentage =
                totalTickets > 0
                    ? Math.round((soldTickets / totalTickets) * 100)
                    : 0;

            document.getElementById("totalTickets").textContent =
                totalTickets.toLocaleString();
            document.getElementById("availableTickets").textContent =
                availableTickets.toLocaleString();
            document.getElementById("soldTickets").textContent =
                soldTickets.toLocaleString();
            document.getElementById(
                "soldPercentage"
            ).textContent = `${soldPercentage}%`;

            const percentageElement = document.getElementById("soldPercentage");
            if (soldPercentage >= 80) {
                percentageElement.classList.add("text-red-600");
                percentageElement.classList.remove("text-purple-600");
            } else {
                percentageElement.classList.add("text-purple-600");
                percentageElement.classList.remove("text-red-600");
            }
        })
        .catch((error) => {
            console.error("Error loading ticket statistics:", error);
        });
}

function loadTickets() {
    const eventId = document.getElementById("eventId").value;

    fetch(`/events/${eventId}/tickets`)
        .then((res) => res.json())
        .then((response) => {
            const tickets = response.data;
            const tbody = document.getElementById("ticketTableBody");
            tbody.innerHTML = "";

            if (tickets.length === 0) {
                tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="text-center py-12 text-gray-500">
                                    <div class="flex flex-col items-center space-y-4">
                                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                            <i class="fas fa-ticket-alt text-3xl text-gray-300"></i>
                                        </div>
                                        <p class="text-lg font-medium">Belum ada tiket dibuat</p>
                                        <p class="text-sm">Klik tombol "Tambah Tiket" untuk mulai menambahkan tiket</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                return;
            }

            tickets.forEach((ticket, index) => {
                const row = document.createElement("tr");
                row.className =
                    "hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200 group";
                row.innerHTML = `
                            <td class="py-6 px-6 text-gray-600 font-bold">${
                                index + 1
                            }</td>
                            <td class="py-6 px-6 font-bold text-gray-800">${
                                ticket.ticket_code_prefix
                            }</td>
                            <td class="py-6 px-6">
                                <span class="px-3 py-2 rounded-full text-xs font-bold
                                    ${
                                        ticket.jenis_ticket === "VVIP"
                                            ? "bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-200"
                                            : ticket.jenis_ticket === "VIP"
                                            ? "bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200"
                                            : ticket.jenis_ticket === "Reguler"
                                            ? "bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200"
                                            : "bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200"
                                    }">
                                    ${ticket.jenis_ticket}
                                </span>
                            </td>
                            <td class="py-6 px-6 font-bold text-gray-800">Rp ${new Intl.NumberFormat(
                                "id-ID"
                            ).format(ticket.price)}</td>
                            <td class="py-6 px-6 font-semibold text-green-600">${
                                ticket.quantity_available
                            }</td>
                            <td class="py-6 px-6 font-semibold text-orange-600">${
                                ticket.quantity_sold || 0
                            }</td>
                            <td class="py-6 px-6 text-sm text-gray-600">
                                <div class="space-y-1">
                                    <div class="font-medium">${new Date(
                                        ticket.start_pesan
                                    ).toLocaleDateString("id-ID")}</div>
                                    <div class="text-xs text-gray-500">${new Date(
                                        ticket.end_pesan
                                    ).toLocaleDateString("id-ID")}</div>
                                </div>
                            </td>
                            <td class="py-6 px-6">
                                <div class="flex space-x-2">
                                    <button onclick="editTicket(${
                                        ticket.ticket_id
                                    })" 
                                        class="group px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl hover:from-blue-600 hover:to-indigo-600 transition-all duration-200 text-sm font-bold shadow-md hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-edit mr-2 group-hover:rotate-12 transition-transform duration-200"></i> Edit
                                    </button>
                                    <button onclick="deleteTicket(${
                                        ticket.ticket_id
                                    })" 
                                        class="group px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl hover:from-red-600 hover:to-pink-600 transition-all duration-200 text-sm font-bold shadow-md hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-trash mr-2 group-hover:rotate-12 transition-transform duration-200"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        `;
                tbody.appendChild(row);
            });

            loadTicketStatistics();
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
                    <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <span class="bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">Tambah Tiket</span>
                `;
    } else if (mode === "edit") {
        document.getElementById("ticketModalTitle").innerHTML = `
                    <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <span class="bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">Edit Tiket</span>
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
            loadTicketStatistics();
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
    // Create a custom confirmation dialog
    const confirmDialog = document.createElement("div");
    confirmDialog.className =
        "fixed inset-0 bg-black/50 glass z-50 flex items-center justify-center p-4";
    confirmDialog.innerHTML = `
                <div class="glass bg-white/95 p-8 rounded-3xl max-w-md w-full shadow-2xl border border-white/50 transform scale-95 opacity-0 transition-all duration-300">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-trash text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Konfirmasi Hapus</h3>
                        <p class="text-gray-600 mb-8">Yakin ingin menghapus tiket ini? Tindakan ini tidak dapat dibatalkan.</p>
                        <div class="flex gap-4">
                            <button onclick="this.closest('.fixed').remove()" class="flex-1 px-6 py-3 border-2 border-gray-300 rounded-2xl text-gray-700 font-bold hover:bg-gray-50 transition-all duration-200">
                                Batal
                            </button>
                            <button onclick="confirmDelete(${ticket_id})" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white font-bold rounded-2xl hover:from-red-600 hover:to-pink-600 transition-all duration-200">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `;

    document.body.appendChild(confirmDialog);
    setTimeout(() => {
        confirmDialog
            .querySelector(".glass.bg-white\\/95")
            .classList.remove("scale-95", "opacity-0");
        confirmDialog
            .querySelector(".glass.bg-white\\/95")
            .classList.add("scale-100", "opacity-100");
    }, 10);

    window.confirmDelete = function (id) {
        fetch(`/tickets/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then(() => {
                loadTickets();
                loadTicketStatistics();
                showToast("success", "Tiket berhasil dihapus");
                confirmDialog.remove();
            })
            .catch((error) => {
                console.error("Error deleting ticket:", error);
                showToast("error", "Gagal menghapus tiket");
                confirmDialog.remove();
            });
    };
};

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        closeTicketModal();
    }
});

function showToast(type, message) {
    const toast = document.createElement("div");
    toast.className = `fixed top-6 right-6 px-8 py-4 rounded-2xl shadow-2xl text-white font-bold flex items-center space-x-3 z-50 transform translate-x-full transition-all duration-300 glass border border-white/20
                ${
                    type === "success"
                        ? "bg-gradient-to-r from-green-500 to-emerald-500"
                        : "bg-gradient-to-r from-red-500 to-pink-500"
                }`;

    toast.innerHTML = `
                <div class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fas ${
                        type === "success"
                            ? "fa-check"
                            : "fa-exclamation-triangle"
                    } text-sm"></i>
                </div>
                <span>${message}</span>
            `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove("translate-x-full");
        toast.classList.add("translate-x-0");
    }, 10);

    setTimeout(() => {
        toast.classList.add("translate-x-full", "opacity-0");
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}
