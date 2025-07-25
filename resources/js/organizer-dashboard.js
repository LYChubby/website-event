document.addEventListener("DOMContentLoaded", () => {
    loadEvents();
    loadCategories();

    document
        .getElementById("eventForm")
        .addEventListener("submit", submitEventForm);
});

// ========== Load Event ==========
function loadEvents(categoryId = "all") {
    fetch("/organizer/events")
        .then((res) => res.json())
        .then((response) => {
            const container = document.getElementById("eventGrid");
            container.innerHTML = "";

            const events =
                categoryId === "all"
                    ? response.data
                    : response.data.filter(
                          (ev) => ev.category_id == categoryId
                      );

            events.forEach((ev) => {
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
                        <h3 class="font-bold text-lg">${ev.name_event}</h3>
                        <p class="text-sm text-gray-600 mb-2">${
                            ev.start_date
                        } - ${ev.end_date}</p>
                        <hr class="my-2" />
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded-full bg-gray-300"></div>
                            <span class="text-sm font-semibold">${
                                ev.organizer_name || "Nama"
                            }</span>
                        </div>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button onclick="editEvent(${
                                ev.event_id
                            })" class="text-blue-600 text-sm hover:underline">Edit</button>
                            <button onclick="deleteEvent(${
                                ev.event_id
                            })" class="text-red-600 text-sm hover:underline">Hapus</button>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        });
}

// Untuk filter kategori
function filterEvents(categoryId) {
    document
        .querySelectorAll(".filter-btn")
        .forEach((btn) => btn.classList.remove("bg-[#78B5FF]", "text-white"));
    const activeBtn = document.querySelector(`[data-category="${categoryId}"]`);
    if (activeBtn) {
        activeBtn.classList.add("bg-[#78B5FF]", "text-white");
    }
    loadEvents(categoryId);
}

// ========== Load Kategori ==========
function loadCategories() {
    fetch("/categories")
        .then((res) => res.json())
        .then((categories) => {
            const select = document.getElementById("category_id");
            const filter = document.getElementById("categoryFilter");

            // Isi dropdown
            select.innerHTML = "";
            categories.forEach((cat) => {
                const option = document.createElement("option");
                option.value = cat.category_id;
                option.textContent = cat.name;
                select.appendChild(option);
            });

            // Isi tombol filter kategori
            categories.forEach((cat) => {
                const btn = document.createElement("button");
                btn.textContent = cat.name;
                btn.className =
                    "filter-btn bg-blue-200 text-blue-700 px-3 py-1 rounded";
                btn.setAttribute("data-category", cat.category_id);
                btn.onclick = () => filterEvents(cat.category_id);
                filter.appendChild(btn);
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
