<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header id="top-panel">
    <div class="container">
        <div class="top-panel-flex">
            <!-- Logo -->
            <a class="logo" href="./index.php">
                <h3>Aroma</h3>&nbsp;&nbsp;<span class="logo-icon fas fa-spray-can fa-3x"></span>
            </a>

            <nav class="navbar" id="navbar">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">All Perfumes</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>

                    <!-- Search Form -->
                    <li class="search-container">
                        <form action="search.php" method="GET" class="search-form">
                            <input type="text" name="query" placeholder="Search perfumes..." required>
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </li>

                    <!-- User Account -->
                    <?php if (isset($_SESSION['admin'])): ?>
                        <li><a href="admin_panel.php" class="btn btn-panel">Admin Panel</a></li>
                        <li><a href="backend/logout.php" class="btn btn-danger">Logout</a></li>
                    <?php elseif (isset($_SESSION['user'])): ?>
                        <li class="dropdown">
                            <button class="btn btn-success dropdown-toggle" id="accountDropdown">
                                My Account <i class="fas fa-user"></i>
                            </button>
                            <ul class="dropdown-menu" id="dropdownMenu">
                                <li><a href="user_dashboard.php"><i class="fas fa-user"></i> Profile</a></li>
                                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                                <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="login_page.php" class="btn btn-light">Login</a></li>
                        <li><a href="user_register.php" class="btn btn-success">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <!-- Mobile Menu Button -->
            <div id="hamburger" class="hamburger" onClick="toggleNavbar()">
                <div></div>
            </div>
        </div>
    </div>
</header>

<!-- JavaScript for Dropdown -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const dropdownButton = document.getElementById("accountDropdown");
    const dropdownMenu = document.getElementById("dropdownMenu");

    if (dropdownButton) {
        dropdownButton.addEventListener("click", function() {
            dropdownMenu.classList.toggle("show");
        });

        // Close dropdown if clicked outside
        document.addEventListener("click", function(event) {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove("show");
            }
        });
    }
});
</script>
