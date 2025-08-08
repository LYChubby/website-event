// resources/js/admin.js
import { initDashboard } from "./admin/admin-dashboard";
import { initCategories } from "./admin/categories";
import { initEventsApproval } from "./admin/events-approval";
import { initOrganizers } from "./admin/organizer-verification";
import { initUsers } from "./admin/users";

document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;

    if (path.includes("/admin/categories")) {
        initCategories();
    } else if (path.includes("/admin/events-approval")) {
        initEventsApproval();
    } else if (path.includes("/admin/organizer")) {
        initOrganizers();
    } else if (path.includes("/admin/users")) {
        initUsers();
    } else {
        initDashboard();
    }
});

// Fungsi global untuk toast notification
window.showToast = function (type, message) {
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
};
