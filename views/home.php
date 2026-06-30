<?php 
$title = 'G0-Tix - Pesan Tiket Bioskop & Event';
$activeMenu = 'home'; 
?>
<!-- Main Content -->
    <main class="container py-5">
        
        <!-- Hero Promo Slider -->
        <div id="heroCarousel" class="carousel slide mb-5 shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/promo-highlight-1.png" class="d-block w-100 object-fit-cover hero-img" alt="Promo 1">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/promo-highlight-2.png" class="d-block w-100 object-fit-cover hero-img" alt="Promo 2">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/promo-highlight-3.png" class="d-block w-100 object-fit-cover hero-img" alt="Promo 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3 shadow" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3 shadow" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Sedang Tayang Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div class="section-title d-flex align-items-center">
                <i class="fa-solid fa-clapperboard fs-3 me-3 text-white"></i>
                <h2 class="m-0 fw-bold">Sedang Tayang</h2>
            </div>
            
            <a href="movies#now-playing" class="text-white text-decoration-none fw-medium d-flex align-items-center gap-2 hover-link">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <!-- Movies Slider -->
        <div class="slider-container mb-5">
            <button class="slider-btn slider-btn-prev"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="slider-btn slider-btn-next"><i class="fa-solid fa-chevron-right"></i></button>
            
            <div class="movie-slider gap-4 pb-4">
                <?php if (!empty($ongoingMovies)): ?>
                    <?php foreach ($ongoingMovies as $movie): ?>
                        <?php 
                            $poster = !empty($movie['poster']) ? $movie['poster'] : 'assets/img/poster-ongoing-1.webp'; 
                            $movieTitle = htmlspecialchars($movie['title']);
                            $durasi = htmlspecialchars($movie['durasi']);
                            $rating = htmlspecialchars($movie['rating']);
                            $genre = htmlspecialchars($movie['genre']);
                            
                            $ratingBadge = 'bg-danger text-white';
                            if ($rating == 'SU') $ratingBadge = 'bg-success text-white';
                            elseif ($rating == '13+') $ratingBadge = 'bg-warning text-dark';
                        ?>
                        <div class="slider-item">
                            <a href="movies/<?= encrypt_id($movie['id']) ?>" class="text-decoration-none">
                                <div class="movie-card position-relative rounded-4 overflow-hidden h-100 shadow">
                                    <img src="<?= $poster ?>" alt="<?= $movieTitle ?>" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 2/3;">
                                    <div class="movie-info-overlay position-absolute bottom-0 start-0 w-100 p-3 d-flex flex-column justify-content-end transition-overlay">
                                        <div class="movie-badges d-flex gap-1 flex-wrap mb-2">
                                            <span class="badge bg-dark bg-opacity-75 border border-secondary text-white"><?= $durasi ?></span>
                                            <span class="badge <?= $ratingBadge ?>"><?= $rating ?></span>
                                            <span class="badge bg-secondary bg-opacity-75 text-white">2D</span>
                                        </div>
                                        <h5 class="fw-bold text-white mb-0 text-truncate"><?= strtoupper($movieTitle) ?></h5>
                                        <p class="text-white-50 small mb-0 mt-1 d-none d-md-block"><?= $genre ?></p>
                                        <button class="btn btn-primary btn-sm w-100 mt-3 fw-bold btn-buy rounded-pill opacity-0">Beli Tiket</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-white-50 p-3 w-100 text-center">Belum ada film yang sedang tayang.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Coming Soon Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-top border-secondary pt-5">
            <div class="section-title d-flex align-items-center">
                <i class="fa-solid fa-clock fs-4 me-3 text-white"></i>
                <h3 class="m-0 fw-bold">Coming Soon</h3>
            </div>
            <a href="movies#coming-soon" class="text-white text-decoration-none fw-medium d-flex align-items-center gap-2 hover-link">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="slider-container mb-5">
            <button class="slider-btn slider-btn-prev"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="slider-btn slider-btn-next"><i class="fa-solid fa-chevron-right"></i></button>
            
            <div class="movie-slider gap-4 pb-4">
                <?php if (!empty($comingSoonMovies)): ?>
                    <?php foreach ($comingSoonMovies as $movie): ?>
                        <?php 
                            $poster = !empty($movie['poster']) ? $movie['poster'] : 'assets/img/poster-ongoing-1.webp'; 
                            $movieTitle = htmlspecialchars($movie['title']);
                        ?>
                        <div class="slider-item">
                            <a href="movies/<?= encrypt_id($movie['id']) ?>" class="text-decoration-none">
                                <div class="movie-card position-relative rounded-4 overflow-hidden shadow">
                                    <img src="<?= $poster ?>" alt="<?= $movieTitle ?>" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 2/3; filter: brightness(0.6);">
                                    <div class="position-absolute top-50 start-50 translate-middle text-center w-100 p-3">
                                        <h5 class="fw-bold text-white text-truncate mb-2"><?= strtoupper($movieTitle) ?></h5>
                                        <span class="badge border border-light text-light rounded-pill px-3 py-2">Segera Tayang</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-white-50 p-3 w-100 text-center">Belum ada film yang akan tayang.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>

<?php ob_start(); ?>
    <!-- Custom Slider JS -->
    <script>
        document.querySelectorAll('.slider-container').forEach(container => {
            const slider = container.querySelector('.movie-slider');
            const btnPrev = container.querySelector('.slider-btn-prev');
            const btnNext = container.querySelector('.slider-btn-next');
            
            if(btnPrev && btnNext) {
                btnPrev.addEventListener('click', () => {
                    slider.scrollBy({ left: -slider.offsetWidth * 0.8, behavior: 'smooth' });
                });
                btnNext.addEventListener('click', () => {
                    slider.scrollBy({ left: slider.offsetWidth * 0.8, behavior: 'smooth' });
                });
            }
        });
    </script>
<?php $extraJs = ob_get_clean(); ?>
