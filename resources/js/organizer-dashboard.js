document.addEventListener("DOMContentLoaded", () => {
    loadEvents();
    loadCategories();

    document
        .getElementById("eventForm")
        .addEventListener("submit", submitEventForm);
});

// ========== Load Event ==========
function loadEvents() {
    fetch("/organizer/events")
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
                        <td class="p-3">
                            ${
                                ev.event_image
                                    ? `<img src="/storage/${ev.event_image}" class="w-16 h-16 object-cover rounded" />`
                                    : "-"
                            }
                        </td>
                        <td class="p-3 space-x-2">
                            <button onclick="editEvent(${
                                ev.event_id
                            })" class="text-blue-600 hover:underline">Edit</button>
                            <button onclick="deleteEvent(${
                                ev.event_id
                            })" class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        });
}

// ========== Load Kategori ==========
function loadCategories() {
    fetch("/categories")
        .then((res) => res.json())
        .then((categories) => {
            const select = document.getElementById("category_id");
            select.innerHTML = "";

            categories.forEach((cat) => {
                const option = document.createElement("option");
                option.value = cat.category_id;
                option.textContent = cat.name;
                select.appendChild(option);
            });
        });
}

// ========== Modal Handler ==========
window.openEventModal = function () {
    document.getElementById("eventId").value = "";
    document.getElementById("eventForm").reset();
    document.getElementById("eventModalTitle").textContent = "Tambah Event";
    document.getElementById("eventModal").classList.remove("hidden");
    document.getElementById("eventModal").classList.add("flex");
};

window.closeEventModal = function () {
    document.getElementById("eventModal").classList.add("hidden");
    document.getElementById("eventModal").classList.remove("flex");
};

// ========== Edit ==========
window.editEvent = function (id) {
    fetch(`/organizer/events/${id}`)
        .then((res) => res.json())
        .then((ev) => {
            document.getElementById("eventId").value = ev.event_id;
            document.getElementById("name_event").value = ev.name_event;
            document.getElementById("category_id").value = ev.category_id;
            document.getElementById("description").value = ev.description || "";
            document.getElementById("venue_name").value = ev.venue_name || "";
            document.getElementById("venue_address").value =
                ev.venue_address || "";
            document.getElementById("status_approval").value =
                ev.status_approval || "pending";
            document.getElementById("start_date").value = ev.start_date;
            document.getElementById("end_date").value = ev.end_date;
            document.getElementById("eventModalTitle").textContent =
                "Edit Event";
            document.getElementById("eventModal").classList.remove("hidden");
            document.getElementById("eventModal").classList.add("flex");
        });
};

// ========== Submit Form ==========
function submitEventForm(e) {
    e.preventDefault();

    const id = document.getElementById("eventId").value;
    const isEdit = Boolean(id);
    const url = isEdit ? `/organizer/events/${id}` : "/events";

    const form = document.getElementById("eventForm");
    const formData = new FormData(form);

    if (isEdit) {
        formData.append("_method", "PUT");
    }

    fetch(url, {
        method: "POST", // method override via _method
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: formData,
    })
        .then((res) => res.json())
        .then(() => {
            closeEventModal();
            loadEvents();
        });
}

// ========== Delete ==========
window.deleteEvent = function (id) {
    if (confirm("Yakin ingin menghapus event ini?")) {
        fetch(`/organizer/events/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        }).then(() => loadEvents());
    }
};
