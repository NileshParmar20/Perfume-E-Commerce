
"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // Get the elements
    const hamburger = document.getElementById("hamburger");
    const navbar = document.getElementById("navbar"); // Correct ID

    if (hamburger && navbar) {
        // Add event listener to the hamburger menu
        hamburger.addEventListener("click", function () {
            this.classList.toggle("toggle");
            navbar.classList.toggle("show-nav"); // Use class toggle for smooth animation
        });
    }
});

// Delete row function
function delete_row(id, img) {
    if (confirm("Are you sure you want to delete?")) {
        window.location.href = `./backend/delete.php?id=${id}&img=${img}`;
    }
}
