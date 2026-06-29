<?php 
$title = 'Movies - G0-Tix';
$activeMenu = 'movies'; 
?>

    <!-- Main Content -->
    <main class="container py-5">
        
        <!-- Breadcrumb & Title -->
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="../index.php" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Film</li>
                </ol>
            </nav>
            <h1 class="fw-bold mb-4 display-6">Film</h1>
        </div>

        <!-- Filter Bar & Tabs -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 mb-5">
            <!-- Tabs -->
            <ul class="nav nav-pills custom-movie-tabs gap-2" id="movieTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 fw-medium" id="now-playing-tab" data-bs-toggle="pill" data-bs-target="#now-playing" type="button" role="tab" aria-controls="now-playing" aria-selected="true">Lagi Tayang</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 fw-medium" id="coming-soon-tab" data-bs-toggle="pill" data-bs-target="#coming-soon" type="button" role="tab" aria-controls="coming-soon" aria-selected="false">Akan Tayang</button>
                </li>
            </ul>

            <!-- Controls -->
            <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center">
                <!-- Search Input Mobile -->
                <div class="position-relative d-lg-none w-100">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-white-50"></i>
                    <input type="text" class="form-control bg-dark border-0 text-white rounded-pill ps-5" placeholder="Cari film">
                </div>

                <!-- Sort Dropdown -->
                <div class="d-flex align-items-center gap-2">
                    <span class="text-white-50 small text-nowrap">Tanggal tayang:</span>
                    <div class="dropdown">
                        <button class="btn btn-link text-white text-decoration-none p-0 d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown">
                            terbaru <i class="fa-solid fa-chevron-down small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item active" href="#">terbaru</a></li>
                            <li><a class="dropdown-item" href="#">terlama</a></li>
                            <li><a class="dropdown-item" href="#">A-Z</a></li>
                        </ul>
                    </div>
                </div>

                <!-- View Toggle (Grid / List) -->
                <div class="d-flex bg-dark rounded-3 p-1">
                    <button class="btn btn-sm btn-dark text-white rounded-2 px-3"><i class="fa-solid fa-border-all"></i></button>
                    <button class="btn btn-sm text-white-50 bg-transparent border-0 px-3"><i class="fa-solid fa-list"></i></button>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="movieTabsContent">
            
            <!-- Now Playing Tab -->
            <div class="tab-pane fade show active" id="now-playing" role="tabpanel" aria-labelledby="now-playing-tab">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php if (!empty($ongoingMovies)): ?>
                        <?php foreach ($ongoingMovies as $movie): ?>
                            <?php 
                                $poster = !empty($movie['poster']) ? $movie['poster'] : 'assets/img/poster-ongoing-1.webp'; 
                                $title = htmlspecialchars($movie['title']);
                                $durasi = htmlspecialchars($movie['durasi']);
                                $rating = htmlspecialchars($movie['rating']);
                                
                                $ratingBadge = 'bg-danger text-white';
                                if ($rating == 'SU') $ratingBadge = 'bg-success text-white';
                                elseif ($rating == '13+') $ratingBadge = 'bg-warning text-dark';
                            ?>
                            <div class="col">
                                <a href="movies/<?= encrypt_id($movie['id']) ?>" class="text-decoration-none">
                                    <div class="movie-card position-relative rounded-4 overflow-hidden shadow bg-dark h-100">
                                        <img src="<?= $poster ?>" alt="<?= $title ?>" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 2/3;">
                                        <div class="transition-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3">
                                            <div class="mt-auto d-flex flex-column align-items-center mb-2">
                                                <h5 class="fw-bold text-white text-truncate w-100 text-center mb-2"><?= strtoupper($title) ?></h5>
                                                <div class="movie-badges d-flex flex-wrap gap-2 justify-content-center">
                                                    <span class="badge bg-secondary bg-opacity-50 text-light fw-medium"><?= $durasi ?></span>
                                                    <span class="badge <?= $ratingBadge ?> fw-bold"><?= $rating ?></span>
                                                    <span class="badge bg-secondary bg-opacity-50 text-light fw-medium">2D</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm w-100 mt-3 fw-bold btn-buy rounded-pill opacity-0">Beli Tiket</button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5 text-white-50">Belum ada film yang tayang.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Coming Soon Tab -->
            <div class="tab-pane fade" id="coming-soon" role="tabpanel" aria-labelledby="coming-soon-tab">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php if (!empty($comingSoonMovies)): ?>
                        <?php foreach ($comingSoonMovies as $movie): ?>
                            <?php 
                                $poster = !empty($movie['poster']) ? $movie['poster'] : 'assets/img/poster-ongoing-1.webp'; 
                                $title = htmlspecialchars($movie['title']);
                                $durasi = htmlspecialchars($movie['durasi']);
                                $rating = htmlspecialchars($movie['rating']);
                                
                                $ratingBadge = 'bg-danger text-white';
                                if ($rating == 'SU') $ratingBadge = 'bg-success text-white';
                                elseif ($rating == '13+') $ratingBadge = 'bg-warning text-dark';
                            ?>
                            <div class="col">
                                <a href="movies/<?= encrypt_id($movie['id']) ?>" class="text-decoration-none">
                                    <div class="movie-card position-relative rounded-4 overflow-hidden shadow bg-dark h-100">
                                        <img src="<?= $poster ?>" alt="<?= $title ?>" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 2/3; filter: brightness(0.8);">
                                        <div class="transition-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3">
                                            <div class="mt-auto d-flex flex-column align-items-center mb-2">
                                                <h5 class="fw-bold text-white text-truncate w-100 text-center mb-2"><?= strtoupper($title) ?></h5>
                                                <div class="movie-badges d-flex flex-wrap gap-2 justify-content-center">
                                                    <span class="badge bg-secondary bg-opacity-50 text-light fw-medium"><?= $durasi ?></span>
                                                    <span class="badge <?= $ratingBadge ?> fw-bold"><?= $rating ?></span>
                                                    <span class="badge bg-secondary bg-opacity-50 text-light fw-medium">2D</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5 text-white-50">Belum ada film yang akan tayang.</div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>

<?php ob_start(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.location.hash) {
                const targetTab = document.querySelector(`button[data-bs-target="${window.location.hash}"]`);
                if (targetTab) {
                    const tab = new bootstrap.Tab(targetTab);
                    tab.show();
                }
            }
        });
    </script>
<?php $extraJs = ob_get_clean(); ?>
