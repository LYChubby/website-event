// resources/js/admin/dashboard.js
export function initDashboard() {
    updateStats();
    loadActivities();
}

function updateStats() {
    fetch("/admin/api/stats")
        .then((res) => res.json())
        .then((data) => {
            // Add smooth counting animation to numbers
            animateCounter("totalCategories", data.categories_count || 0);
            animateCounter("approvedEvents", data.approved_events_count || 0);
            animateCounter("pendingEvents", data.pending_events_count || 0);
            animateCounter("totalUsers", data.users_count || 0);
        })
        .catch((error) => {
            console.error("Error loading stats:", error);
            // Set fallback values
            document.getElementById("totalCategories").textContent = "0";
            document.getElementById("approvedEvents").textContent = "0";
            document.getElementById("pendingEvents").textContent = "0";
            document.getElementById("totalUsers").textContent = "0";
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
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-info-circle text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-600 mb-1">Tidak ada aktivitas</h3>
                        <p class="text-sm text-gray-400">Tidak ada aktivitas terbaru</p>
                    </div>
                `;
                return;
            }

            activities.forEach((activity, index) => {
                const activityEl = document.createElement("div");
                activityEl.className = "activity-item";
                activityEl.style.animationDelay = `${index * 0.1}s`;
                activityEl.innerHTML = `
                    <div class="flex items-start space-x-4">
                        <div class="activity-icon activity-icon-${
                            activity.type
                        }">
                            <i class="fas fa-${getActivityIcon(
                                activity.type
                            )} text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-base font-semibold text-gray-800 truncate">${
                                    activity.title
                                }</h4>
                                <span class="text-xs font-medium text-gray-500 whitespace-nowrap">${
                                    activity.time
                                }</span>
                            </div>
                            <p class="text-sm text-gray-600">${
                                activity.description
                            }</p>
                        </div>
                    </div>
                `;
                container.appendChild(activityEl);
            });
        })
        .catch((error) => {
            console.error("Error loading activities:", error);
            const container = document.getElementById("activitiesList");
            container.innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-600 mb-1">Gagal memuat aktivitas</h3>
                    <p class="text-sm text-gray-400">Terjadi kesalahan saat memuat data</p>
                </div>
            `;
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

function animateCounter(elementId, targetValue) {
    const element = document.getElementById(elementId);
    if (!element) return;

    const startValue = 0;
    const duration = 1000; // 1 second (reduced from 1.5s for faster feel)
    const startTime = performance.now();

    function updateCounter(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        // Use easing function for smooth animation
        const easeOutQuad = progress * (2 - progress);
        const currentValue = Math.floor(
            startValue + (targetValue - startValue) * easeOutQuad
        );

        element.textContent = currentValue.toString();

        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = targetValue.toString();
        }
    }

    requestAnimationFrame(updateCounter);
}
