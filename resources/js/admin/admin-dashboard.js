// resources/js/admin/dashboard.js
export function initDashboard() {
    updateStats();
    loadActivities();
}

function updateStats() {
    fetch("/admin/api/stats")
        .then((res) => res.json())
        .then((data) => {
            document.getElementById("totalCategories").textContent =
                data.categories_count || "0";
            document.getElementById("approvedEvents").textContent =
                data.approved_events_count || "0";
            document.getElementById("pendingEvents").textContent =
                data.pending_events_count || "0";
            document.getElementById("totalUsers").textContent =
                data.users_count || "0";
        })
        .catch((error) => {
            console.error("Error loading stats:", error);
        });
}

function loadActivities() {
    fetch("/admin/api/activities")
        .then((res) => res.json())
        .then((activities) => {
            const container = document.getElementById("activitiesList");
            container.innerHTML = "";

            if (activities.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-info-circle text-3xl mb-2"></i>
                        <p>Tidak ada aktivitas terbaru</p>
                    </div>
                `;
                return;
            }

            activities.forEach((activity) => {
                const activityEl = document.createElement("div");
                activityEl.className =
                    "flex items-start p-4 bg-gray-50 rounded-lg";
                activityEl.innerHTML = `
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-${getActivityIcon(
                                activity.type
                            )} text-blue-500"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">${
                                activity.title
                            }</p>
                            <p class="text-xs text-gray-500">${
                                activity.time
                            }</p>
                        </div>
                        <p class="text-sm text-gray-500">${
                            activity.description
                        }</p>
                    </div>
                `;
                container.appendChild(activityEl);
            });
        })
        .catch((error) => {
            console.error("Error loading activities:", error);
        });
}

function getActivityIcon(type) {
    const icons = {
        user: "user-plus",
        event: "calendar-check",
        category: "tag",
        login: "sign-in-alt",
        default: "bell",
    };
    return icons[type] || icons.default;
}
