document.addEventListener("DOMContentLoaded", () => {
    loadEvents();
    loadCategories();

    // Tambahkan ini di DOMContentLoaded
    document.getElementById("eventForm").addEventListener("reset", function () {
        // Clear file info
        document.getElementById("fileInfo").style.display = "none";
        document.getElementById("fileInfo").innerHTML = "";
        document.querySelector('input[name="existing_image"]').value = "";

        // Reset label file upload
        const fileLabel = document.querySelector('label[for="event_image"]');
        const originalText = "Gambar Event";
        fileLabel.textContent = originalText;

        // Clear draft
        clearDraft();
    });

    document
        .getElementById("eventForm")
        .addEventListener("submit", submitEventForm);

    // Search functionality
    document
        .querySelector(".search-input")
        .addEventListener("input", handleSearch);

    // Close modal when clicking outside
    document
        .getElementById("eventModal")
        .addEventListener("click", function (e) {
            if (e.target === this) {
                closeEventModal();
            }
        });
});

// ========== Load Event ==========
function loadEvents(categoryId = "all") {
    showLoading();

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

            if (events.length === 0) {
                container.innerHTML = `
                            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                                <i class="fas fa-calendar-times" style="font-size: 4rem; color: #e5e7eb; margin-bottom: 1rem;"></i>
                                <h3 style="color: #6b7280; font-size: 1.2rem; margin-bottom: 0.5rem;">Belum ada event</h3>
                                <p style="color: #9ca3af;">Klik tombol "Tambah Event" untuk membuat event pertama Anda.</p>
                            </div>
                        `;
                return;
            }

            events.forEach((ev, index) => {
                const card = document.createElement("div");
                card.className = "event-card";
                card.style.animationDelay = `${index * 0.1}s`;

                card.innerHTML = `
                            <a href="/events/${ev.event_id}" class="block">
                                <div class="event-image">
                                    ${
                                        ev.event_image
                                            ? `<img src="/storage/${ev.event_image}" alt="${ev.name_event}" />`
                                            : `<div class="event-image-placeholder">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>`
                                    }
                                </div>
                            </a>
                            <div class="event-content">
                                <a href="/events/${ev.event_id}" class="block">
                                    <h3 class="event-title">${
                                        ev.name_event
                                    }</h3>
                                </a>
                                <div class="event-date">
                                    <i class="fas fa-clock"></i>
                                    ${formatDate(ev.start_date)} - ${formatDate(
                    ev.end_date
                )}
                                </div>
                                <div class="divider"></div>
                                <div class="organizer-info">
                                    <div class="organizer-avatar">${getInitials(
                                        ev.organizer_name || "Organizer"
                                    )}</div>
                                    <span class="organizer-name">${
                                        ev.organizer_name || "Organizer"
                                    }</span>
                                </div>
                                <div class="card-actions">
                                    <button class="action-btn edit-btn" onclick="editEvent(${
                                        ev.event_id
                                    })">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="action-btn delete-btn" onclick="deleteEvent(${
                                        ev.event_id
                                    })">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        `;
                container.appendChild(card);
            });
        })
        .catch((error) => {
            console.error("Error loading events:", error);
            const container = document.getElementById("eventGrid");
            container.innerHTML = `
                        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: #ef4444; margin-bottom: 1rem;"></i>
                            <h3 style="color: #ef4444; font-size: 1.2rem; margin-bottom: 0.5rem;">Gagal memuat event</h3>
                            <p style="color: #6b7280;">Terjadi kesalahan saat memuat data. Silakan refresh halaman.</p>
                        </div>
                    `;
        });
}

// Filter events
function filterEvents(categoryId) {
    document
        .querySelectorAll(".filter-btn")
        .forEach((btn) => btn.classList.remove("active"));
    const activeBtn = document.querySelector(`[data-category="${categoryId}"]`);
    if (activeBtn) {
        activeBtn.classList.add("active");
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

            // Clear existing options
            select.innerHTML = '<option value="">Pilih Kategori</option>';
            filter.innerHTML = ""; // ← clear filter button

            // ✅ Tambahkan kembali tombol SEMUA
            const allBtn = document.createElement("button");
            allBtn.className = "filter-btn active"; // bisa diubah tergantung kondisi aktif
            allBtn.setAttribute("data-category", "all");
            allBtn.innerHTML = '<i class="fas fa-th-large"></i> Semua';
            allBtn.onclick = () => filterEvents("all");
            filter.appendChild(allBtn);

            // Tambahkan kategori lain dari response
            categories.forEach((cat) => {
                const option = document.createElement("option");
                option.value = cat.category_id;
                option.textContent = cat.name;
                select.appendChild(option);

                const btn = document.createElement("button");
                btn.className = "filter-btn";
                btn.setAttribute("data-category", cat.category_id);
                btn.textContent = cat.name;
                btn.onclick = () => filterEvents(cat.category_id);
                filter.appendChild(btn);
            });
        })
        .catch((error) => {
            console.error("Error loading categories:", error);
        });
}

// ========== Modal Handler ==========
window.openEventModal = function () {
    // Reset form terlebih dahulu
    const form = document.getElementById("eventForm");
    form.reset();
    document.getElementById("eventId").value = "";
    document.getElementById("status_approval").value = "pending";

    // Clear file info
    document.getElementById("fileInfo").style.display = "none";
    document.getElementById("fileInfo").innerHTML = "";
    document.querySelector('input[name="existing_image"]').value = "";

    // Reset label file upload
    const fileLabel = document.querySelector('label[for="event_image"]');
    const originalText = "Gambar Event";
    fileLabel.innerHTML = originalText;

    // Set judul modal
    document.getElementById("eventModalTitle").textContent = "Tambah Event";

    // Buka modal
    document.getElementById("eventModal").classList.add("show");

    // Hapus draft setelah reset (jika ada)
    clearDraft();
};

window.closeEventModal = function () {
    document.getElementById("eventModal").classList.remove("show");
};

function formatDateForInput(dateStr) {
    if (!dateStr) return "";
    const date = new Date(dateStr);
    if (isNaN(date)) return "";
    const year = date.getFullYear();
    const month = `0${date.getMonth() + 1}`.slice(-2);
    const day = `0${date.getDate()}`.slice(-2);
    return `${year}-${month}-${day}`;
}

// ========== Edit Event ==========
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

            const fileInfo = document.getElementById("fileInfo");
            const existingImageInput = document.querySelector(
                'input[name="existing_image"]'
            );

            if (ev.event_image) {
                fileInfo.textContent = `File saat ini: ${ev.event_image}`;
                fileInfo.style.display = "block";
                existingImageInput.value = ev.event_image;

                // Tambahkan preview gambar jika mau
                const imgPreview = document.createElement("img");
                imgPreview.src = `/storage/${ev.event_image}`;
                fileInfo.appendChild(imgPreview);
            } else {
                fileInfo.style.display = "none";
                existingImageInput.value = "";
            }

            // ✅ Format tanggal supaya gak reset
            document.getElementById("start_date").value = formatDateForInput(
                ev.start_date
            );
            document.getElementById("end_date").value = formatDateForInput(
                ev.end_date
            );

            document.getElementById("eventModalTitle").textContent =
                "Edit Event";
            document.getElementById("eventModal").classList.add("show");
        })
        .catch((error) => {
            console.error("Error loading event:", error);
            alert("Gagal memuat data event");
        });
};

// ========== Submit Form ==========
function submitEventForm(e) {
    e.preventDefault();

    const id = document.getElementById("eventId").value;
    const isEdit = Boolean(id);
    const url = isEdit ? `/organizer/events/${id}` : "/organizer/events";

    const form = document.getElementById("eventForm");
    const formData = new FormData(form);

    if (isEdit) {
        formData.append("_method", "PUT");
    }

    // Disable submit button to prevent double submission
    const submitBtn = form.querySelector('[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = "Menyimpan...";

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: formData,
    })
        .then((res) => res.json())
        .then((response) => {
            if (response.success || response.data) {
                closeEventModal();
                loadEvents();
                // Show success message
                showNotification(
                    isEdit
                        ? "Event berhasil diperbarui!"
                        : "Event berhasil ditambahkan!",
                    "success"
                );
            } else {
                throw new Error(response.message || "Terjadi kesalahan");
            }
        })
        .catch((error) => {
            console.error("Error submitting form:", error);
            showNotification(
                "Gagal menyimpan event. Silakan coba lagi.",
                "error"
            );
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
}

// ========== Delete Event ==========
window.deleteEvent = function (id) {
    if (confirm("Yakin ingin menghapus event ini?")) {
        fetch(`/organizer/events/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((res) => res.json())
            .then((response) => {
                if (response.success) {
                    loadEvents();
                    showNotification("Event berhasil dihapus!", "success");
                } else {
                    throw new Error(
                        response.message || "Gagal menghapus event"
                    );
                }
            })
            .catch((error) => {
                console.error("Error deleting event:", error);
                showNotification(
                    "Gagal menghapus event. Silakan coba lagi.",
                    "error"
                );
            });
    }
};

// ========== Search Handler ==========
function handleSearch(e) {
    const searchTerm = e.target.value.toLowerCase();
    const eventCards = document.querySelectorAll(".event-card");

    eventCards.forEach((card) => {
        const title = card
            .querySelector(".event-title")
            .textContent.toLowerCase();
        const organizer = card
            .querySelector(".organizer-name")
            .textContent.toLowerCase();

        if (title.includes(searchTerm) || organizer.includes(searchTerm)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

// ========== Utility Functions ==========
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
}

function getInitials(name) {
    return name
        .split(" ")
        .map((word) => word[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);
}

function showLoading() {
    const container = document.getElementById("eventGrid");
    container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f3f4f6; border-top: 4px solid var(--primary-color); border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    <p style="margin-top: 1rem; color: #6b7280; font-size: 1.1rem;">Memuat event...</p>
                </div>
            `;
}

function showNotification(message, type = "info") {
    // Create notification element
    const notification = document.createElement("div");
    notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                max-width: 400px;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                color: white;
                font-weight: 600;
                transform: translateX(100%);
                transition: all 0.3s ease;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            `;

    // Set background color based on type
    if (type === "success") {
        notification.style.background =
            "linear-gradient(135deg, #10b981, #059669)";
    } else if (type === "error") {
        notification.style.background =
            "linear-gradient(135deg, #ef4444, #dc2626)";
    } else {
        notification.style.background =
            "linear-gradient(135deg, var(--primary-color), var(--primary-dark))";
    }

    notification.textContent = message;
    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.style.transform = "translateX(0)";
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = "translateX(100%)";
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// ========== Keyboard Shortcuts ==========
document.addEventListener("keydown", function (e) {
    // Ctrl/Cmd + N to add new event
    if ((e.ctrlKey || e.metaKey) && e.key === "n") {
        e.preventDefault();
        openEventModal();
    }

    // Escape to close modal
    if (e.key === "Escape") {
        if (document.getElementById("eventModal").classList.contains("show")) {
            closeEventModal();
        }
    }
});

// ========== Form Validation ==========
document.getElementById("start_date").addEventListener("change", function () {
    const startDate = this.value;
    const endDateInput = document.getElementById("end_date");

    if (startDate) {
        endDateInput.min = startDate;
        if (endDateInput.value && endDateInput.value < startDate) {
            endDateInput.value = startDate;
        }
    }
});

document.getElementById("end_date").addEventListener("change", function () {
    const endDate = this.value;
    const startDateInput = document.getElementById("start_date");

    if (endDate && startDateInput.value && endDate < startDateInput.value) {
        this.value = startDateInput.value;
        showNotification(
            "Tanggal selesai tidak boleh lebih awal dari tanggal mulai",
            "error"
        );
    }
});

// ========== File Upload Preview ==========
document.getElementById("event_image").addEventListener("change", function (e) {
    const file = e.target.files[0];
    const label = document.querySelector('label[for="event_image"]');
    const originalText = label.textContent || "Gambar Event";

    if (file) {
        // Validasi file
        if (file.size > 5 * 1024 * 1024) {
            showNotification(
                "Ukuran file terlalu besar. Maksimal 5MB.",
                "error"
            );
            this.value = "";
            label.textContent = originalText;
            return;
        }

        if (!file.type.startsWith("image/")) {
            showNotification("File harus berupa gambar.", "error");
            this.value = "";
            label.textContent = originalText;
            return;
        }

        // Tampilkan nama file
        label.innerHTML = `${originalText} <span style="color: var(--primary-color); font-weight: normal;">(${file.name})</span>`;
    } else {
        label.textContent = originalText;
    }
});

// ========== Auto-save Draft (Optional) ==========
let draftTimeout;
const formInputs = document.querySelectorAll(
    "#eventForm input, #eventForm textarea, #eventForm select"
);

formInputs.forEach((input) => {
    input.addEventListener("input", function () {
        clearTimeout(draftTimeout);
        draftTimeout = setTimeout(() => {
            saveDraft();
        }, 1000); // Save draft after 1 second of no typing
    });
});

function saveDraft() {
    const formData = new FormData(document.getElementById("eventForm"));
    const draft = {};
    for (let [key, value] of formData.entries()) {
        if (key !== "_token" && key !== "event_image") {
            draft[key] = value;
        }
    }
    localStorage.setItem("eventDraft", JSON.stringify(draft));
}

function loadDraft() {
    // Hanya load draft jika benar-benar form baru (bukan edit)
    if (!document.getElementById("eventId").value) {
        const draft = localStorage.getItem("eventDraft");
        if (draft) {
            const draftData = JSON.parse(draft);
            Object.keys(draftData).forEach((key) => {
                const input = document.getElementById(key);
                if (input && draftData[key] && input.type !== "file") {
                    input.value = draftData[key];
                }
            });
        }
    }
}

function clearDraft() {
    localStorage.removeItem("eventDraft");
}

// Load draft when opening modal for new event
const originalOpenModal = window.openEventModal;
window.openEventModal = function () {
    originalOpenModal();
    setTimeout(loadDraft, 100); // Small delay to ensure form is reset first
};

// Clear draft when form is successfully submitted
const originalSubmitForm = submitEventForm;
submitEventForm = function (e) {
    originalSubmitForm(e);
    // Clear draft on successful submission (this would be called in the success callback)
};

// ========== Responsive Menu Toggle ==========
function toggleMobileMenu() {
    const headerControls = document.querySelector(".header-controls");
    headerControls.style.display =
        headerControls.style.display === "none" ? "flex" : "none";
}

// Add mobile menu button for very small screens
window.addEventListener("resize", function () {
    const headerControls = document.querySelector(".header-controls");
    if (window.innerWidth > 768) {
        headerControls.style.display = "flex";
    }
});
