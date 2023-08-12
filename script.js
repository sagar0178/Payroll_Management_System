// Custom JavaScript for sub-menu toggling
$(document).ready(function () {
    $(".sub-menu-toggler").click(function () {
        $(this).next(".sub-menu").slideToggle();
        $(this).toggleClass("active");
    });
});

// JavaScript function to go back to the previous page
function goBack() {
    // Redirect the user to dashboard.php
    window.location.href = 'admin_dashboard.php';
}


