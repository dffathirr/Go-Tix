<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= base_url() ?>">
    <title><?= htmlspecialchars($title ?? 'Admin Panel - G0-Tix') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 12px 20px;
            margin-bottom: 5px;
            border-radius: 8px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: #0d6efd;
        }
        .sidebar .nav-link i {
            width: 24px;
        }
        .content-wrapper {
            flex-grow: 1;
            padding: 2rem;
        }
    </style>
    <?= $extraCss ?? '' ?>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column p-3 shadow-lg" style="width: 280px;">
            <a href="admin" class="d-flex align-items-center mb-4 mt-2 text-white text-decoration-none px-3">
                <i class="fa-solid fa-ticket-simple fs-4 me-3 text-primary"></i>
                <span class="fs-4 fw-bold">Admin Panel</span>
            </a>
            <hr class="text-white-50 mt-0">
            <ul class="nav nav-pills flex-column mb-auto mt-2">
                <li class="nav-item">
                    <a href="admin" class="nav-link <?= ($activeMenu === 'dashboard') ? 'active' : '' ?>">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin/movies" class="nav-link <?= ($activeMenu === 'movies') ? 'active' : '' ?>">
                        <i class="fa-solid fa-film"></i> Kelola Film
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin/cinemas" class="nav-link <?= ($activeMenu === 'cinemas') ? 'active' : '' ?>">
                        <i class="fa-solid fa-building"></i> Kelola Bioskop
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admin/bookings" class="nav-link <?= ($activeMenu === 'bookings') ? 'active' : '' ?>">
                        <i class="fa-solid fa-receipt"></i> Laporan Pesanan
                    </a>
                </li>
            </ul>
            <hr class="text-white-50">
            <div class="px-3 py-2">
                <a href="<?= base_url() ?>" class="btn btn-outline-light w-100"><i class="fa-solid fa-arrow-left me-2"></i> Ke Halaman Utama</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-wrapper overflow-auto" style="height: 100vh;">
            <?= $content ?? '' ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $extraJs ?? '' ?>
</body>
</html>
