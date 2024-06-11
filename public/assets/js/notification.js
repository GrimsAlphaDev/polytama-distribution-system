document.addEventListener("DOMContentLoaded", function () {
    const notification = document.getElementById("notification");
    const notificationClose = document.getElementById("notification-close");

    // Show notification
    notification.classList.add("show", "alert-show");

    // Hide notification after 3 seconds
    setTimeout(function () {
        notification.classList.remove("show", "alert-show");
    }, 5000);
    // });

    notificationClose.addEventListener("click", function () {
        notification.classList.remove("show", "alert-show");
    });
});
