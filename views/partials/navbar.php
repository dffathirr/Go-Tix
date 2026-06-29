<?php
$activeMenu = isset($activeMenu) ? $activeMenu : 'home';
?>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top custom-navbar shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3 text-white" href="">G0<span class="text-primary-light">-TIX</span></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 fw-medium">
                <li class="nav-item">
                    <a class="nav-link <?= $activeMenu === 'home' ? 'active text-white' : '' ?>" href="">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activeMenu === 'movies' ? 'active text-white' : '' ?>" href="movies">Movies</a>
                </li>

            </ul>
            
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <!-- Search Form -->
                <form class="position-relative search-form d-none d-lg-block">
                    <input type="text" class="form-control rounded-pill bg-dark border-0 text-white ps-4 pe-5" placeholder="Cari film...">
                    <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y text-white-50"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                
                <!-- Location -->
                <div class="dropdown">
                    <button class="btn btn-location rounded-pill d-flex align-items-center gap-2 px-3 fw-medium" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-location-dot"></i> Bogor <i class="fa-solid fa-chevron-down small"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item active" href="#">Bogor</a></li>
                        <li><a class="dropdown-item" href="#">Jakarta</a></li>
                        <li><a class="dropdown-item" href="#">Depok</a></li>
                        <li><a class="dropdown-item" href="#">Tangerang</a></li>
                        <li><a class="dropdown-item" href="#">Bekasi</a></li>
                    </ul>
                </div>
                
                <!-- Auth Buttons -->
                <div class="d-flex gap-2 align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-light rounded-pill px-4 fw-medium dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user me-2"></i><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item text-danger" href="auth/logout"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <button type="button" class="btn btn-outline-light rounded-pill px-4 fw-medium" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthView('login')">Login</button>
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-medium text-primary-dark" data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthView('register')">Register</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>
