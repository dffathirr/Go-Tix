<?php 
$title = htmlspecialchars($movieDetail['title']) . ' - Detail Film';
$activeMenu = 'movies'; 
?>

    <!-- Hero Detail Section -->
    <section class="position-relative overflow-hidden pt-5 pb-5 hero-movie-wrapper">
        <!-- Blurred Background -->
        <div class="position-absolute top-0 start-0 w-100 h-100 hero-movie-bg" style="background-image: url('<?= htmlspecialchars($movieDetail['poster']) ?>');"></div>
        <div class="position-absolute top-0 start-0 w-100 h-100 hero-movie-overlay"></div>
        
        <div class="container position-relative z-index-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="movies" class="text-white-50 text-decoration-none">Film</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= strtoupper(htmlspecialchars($movieDetail['title'])) ?></li>
                </ol>
            </nav>

            <div class="row align-items-center g-5">
                <div class="col-md-4 col-lg-3 text-center text-md-start">
                    <img src="<?= htmlspecialchars($movieDetail['poster']) ?>" alt="<?= htmlspecialchars($movieDetail['title']) ?>" class="img-fluid rounded-4 shadow-lg border border-secondary border-opacity-25 hero-poster" style="aspect-ratio: 2/3; object-fit: cover; width: 100%;">
                </div>
                <div class="col-md-8 col-lg-9">
                    <h1 class="fw-bold display-4 text-white mb-2"><?= htmlspecialchars($movieDetail['title']) ?></h1>
                    <p class="fs-5 text-white-50 mb-3"><?= htmlspecialchars($movieDetail['genre']) ?></p>
                    
                    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
                        <div class="d-flex align-items-center text-warning fw-bold fs-5 gap-1">
                            <i class="fa-solid fa-star"></i> 4.5
                        </div>
                        <div class="text-white d-flex align-items-center gap-1">
                            <i class="fa-regular fa-clock text-white-50"></i> <?= htmlspecialchars($movieDetail['durasi']) ?>
                        </div>
                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill"><?= htmlspecialchars($movieDetail['rating']) ?></span>
                        <span class="badge bg-secondary bg-opacity-75 fs-6 px-3 py-2 rounded-pill border border-light border-opacity-25">2D</span>
                    </div>

                    <div class="d-flex gap-3">
                        <button class="btn btn-light rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2">
                            <i class="fa-solid fa-play"></i> Lihat Trailer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content (Tabs) -->
    <div class="container py-4 mb-5">
        <?php
        $isJadwalActive = isset($_GET['date']) ? true : false;
        $detailTabClass = $isJadwalActive ? '' : 'active';
        $jadwalTabClass = $isJadwalActive ? 'active' : '';
        $detailPaneClass = $isJadwalActive ? '' : 'show active';
        $jadwalPaneClass = $isJadwalActive ? 'show active' : '';
        ?>
        <ul class="nav nav-tabs custom-tabs mb-4 border-0 border-bottom border-secondary border-opacity-25" id="movieTab" role="tablist">
            <li class="nav-item flex-grow-1 text-center" role="presentation">
                <button class="nav-link <?= $detailTabClass ?> w-100 text-uppercase fw-bold pb-3" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-tab-pane" type="button" role="tab">Detail</button>
            </li>
            <li class="nav-item flex-grow-1 text-center" role="presentation">
                <button class="nav-link <?= $jadwalTabClass ?> w-100 text-uppercase fw-bold pb-3" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal-tab-pane" type="button" role="tab">Jadwal</button>
            </li>
        </ul>

        <div class="tab-content" id="movieTabContent">
            <!-- DETAIL TAB -->
            <div class="tab-pane fade <?= $detailPaneClass ?>" id="detail-tab-pane" role="tabpanel" tabindex="0">
                <div class="row">
                    <div class="col-lg-8">
                        <h4 class="fw-bold mb-3">Sinopsis</h4>
                        <p class="text-white-50 lh-lg mb-5">
                            <?= isset($movieDetail['sinopsis']) && !empty($movieDetail['sinopsis']) ? htmlspecialchars($movieDetail['sinopsis']) : 'Sinopsis untuk film ini belum tersedia. Nantikan update cerita lengkapnya segera!' ?>
                        </p>
                        
                        <div class="row mb-5">
                            <div class="col-sm-6 mb-4 mb-sm-0">
                                <h5 class="fw-bold fs-6 mb-2 text-white-50">Produser</h5>
                                <p class="fw-medium fs-5"><?= isset($movieDetail['produser']) && !empty($movieDetail['produser']) ? htmlspecialchars($movieDetail['produser']) : '-' ?></p>
                            </div>
                            <div class="col-sm-6">
                                <h5 class="fw-bold fs-6 mb-2 text-white-50">Sutradara</h5>
                                <p class="fw-medium fs-5"><?= isset($movieDetail['sutradara']) && !empty($movieDetail['sutradara']) ? htmlspecialchars($movieDetail['sutradara']) : '-' ?></p>
                            </div>
                        </div>

                        <h4 class="fw-bold mb-3">Pemeran</h4>
                        <div class="d-flex gap-3 overflow-x-auto pb-3 cast-list">
                            <?php
                            $pemeranList = isset($movieDetail['pemeran']) && !empty(trim($movieDetail['pemeran'])) 
                                ? array_map('trim', explode(',', $movieDetail['pemeran'])) 
                                : [];
                            
                            if (!empty($pemeranList)):
                                foreach ($pemeranList as $pemeran):
                                    // Generate initials (max 2 characters)
                                    $words = explode(' ', $pemeran);
                                    $initials = '';
                                    foreach ($words as $w) {
                                        if (!empty($w)) {
                                            $initials .= strtoupper(substr($w, 0, 1));
                                        }
                                    }
                                    if (strlen($initials) > 2) {
                                        $initials = substr($initials, 0, 2);
                                    }
                            ?>
                                <div class="cast-item text-center">
                                    <div class="cast-circle bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4 mb-2 mx-auto"><?= $initials ?></div>
                                    <small class="text-white-50"><?= htmlspecialchars($pemeran) ?></small>
                                </div>
                            <?php 
                                endforeach;
                            else:
                            ?>
                                <div class="text-white-50">Daftar pemeran belum tersedia.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JADWAL TAB -->
            <div class="tab-pane fade <?= $jadwalPaneClass ?>" id="jadwal-tab-pane" role="tabpanel" tabindex="0">
                <?php if (strtolower($movieDetail['type']) === 'ongoing'): ?>
                <!-- Date Selector Slider -->
                <div class="date-selector-container w-100 d-flex gap-4 overflow-x-auto pb-3 mb-4 px-1 align-items-center">
                    <?php if (!empty($availableDates)): ?>
                        <?php 
                        $prevMonth = null;
                        $isFirstDate = true;
                        foreach ($availableDates as $date): 
                            $currentMonth = date('M Y', strtotime($date['tanggal']));
                            $displayMonth = str_replace(
                                ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                $currentMonth
                            );
                            
                            if ($prevMonth !== null && $prevMonth !== $currentMonth):
                        ?>
                            <div class="d-flex flex-column align-items-center justify-content-center px-2 mx-1 flex-shrink-0">
                                <div class="d-flex align-items-center gap-2 text-white-50 fw-bold fs-5">
                                    <i class="fa-solid fa-circle" style="font-size: 6px;"></i>
                                    <span><?= $displayMonth ?></span>
                                    <i class="fa-solid fa-circle" style="font-size: 6px;"></i>
                                </div>
                            </div>
                        <?php 
                            endif;
                            $prevMonth = $currentMonth;
                            
                            $isActive = ($selectedDateId == $date['id']);
                            $day = date('d', strtotime($date['tanggal']));
                            $dayName = date('D', strtotime($date['tanggal']));
                            $dayMap = ['Sun'=>'Min', 'Mon'=>'Sen', 'Tue'=>'Sel', 'Wed'=>'Rab', 'Thu'=>'Kam', 'Fri'=>'Jum', 'Sat'=>'Sab'];
                            $hari = isset($dayMap[$dayName]) ? $dayMap[$dayName] : substr($date['hari'], 0, 3);
                            
                            // Check if first date
                            if ($isFirstDate) {
                                $hari = 'Hari ini';
                                $isFirstDate = false;
                            }
                            
                            $btnStyle = $isActive ? 'background-color: #009688; border: none; min-width: 85px;' : 'background-color: var(--primary-dark); border: none; min-width: 85px;';
                        ?>
                            <a href="movies/<?= encrypt_id($movieDetail['id']) ?>?date=<?= encrypt_id($date['id']) ?>" class="text-decoration-none flex-shrink-0">
                                <button class="btn d-flex flex-column align-items-center justify-content-center p-3 rounded-3 shadow-sm w-100" style="<?= $btnStyle ?>">
                                    <small class="fw-medium <?= $isActive ? 'text-white' : 'text-white-50' ?> mb-1"><?= htmlspecialchars($hari) ?></small>
                                    <span class="fs-4 fw-bold <?= $isActive ? 'text-white' : 'text-white-50' ?>"><?= $day ?></span>
                                </button>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-white-50 p-2">Belum ada jadwal tayang.</div>
                    <?php endif; ?>
                </div>



                <!-- Cinema List Accordion -->
                <div class="accordion custom-accordion" id="cinemaAccordion">
                    <?php if (!empty($schedules)): ?>
                        <?php $i = 1; foreach ($schedules as $cinemaName => $cinemaSchedules): ?>
                        <div class="accordion-item mb-3 shadow-sm border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $i > 1 ? 'collapsed' : '' ?> rounded-3 fw-bold fs-5 shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#cinema<?= $i ?>" aria-expanded="<?= $i === 1 ? 'true' : 'false' ?>">
                                    <?= htmlspecialchars($cinemaName) ?>
                                </button>
                            </h2>
                            <div id="cinema<?= $i ?>" class="accordion-collapse collapse <?= $i === 1 ? 'show' : '' ?>" data-bs-parent="#cinemaAccordion">
                                <div class="accordion-body px-3 pt-3 pb-4">
                                    <div class="d-flex gap-3 flex-wrap" data-cinema="<?= htmlspecialchars($cinemaName) ?>">
                                        <?php foreach ($cinemaSchedules as $jadwal): ?>
                                            <?php $isDisabled = (strtolower($jadwal['status']) !== 'available') ? 'disabled' : ''; ?>
                                            <button class="btn time-pill <?= $isDisabled ?>" data-id="<?= htmlspecialchars(encrypt_id($jadwal['id_jadwal'])) ?>"><?= htmlspecialchars($jadwal['waktu']) ?></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4 text-white-50">
                            <i class="fa-solid fa-calendar-xmark fs-1 mb-3 opacity-50"></i>
                            <p>Tidak ada jadwal tersedia untuk tanggal ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php else: ?>
                <!-- Empty State for Coming Soon Movies -->
                <div class="d-flex flex-column align-items-center justify-content-center py-5 text-center my-4">
                    <div class="bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 150px; height: 150px;">
                        <i class="fa-solid fa-ticket text-white-50 opacity-50" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2 fs-4">Film Belum Tayang, nih</h5>
                    <p class="text-white-50 fs-6">Kalau udah, nanti balik ke sini untuk beli tiket, ya.</p>
                </div>
                <?php endif; ?>

                <?php if (strtolower($movieDetail['type']) === 'ongoing'): ?>
                <!-- Booking Summary Bar (Hidden by default) -->
                <div id="bookingSummary" class="booking-summary-bar position-sticky bottom-0 mb-4 z-3 bg-light text-dark p-3 rounded-4 shadow-lg mt-4 d-none flex-column flex-md-row justify-content-between align-items-md-center gap-3 border border-secondary border-opacity-25" style="bottom: 20px !important;">
                    <?php
                        $displayDate = '';
                        if (!empty($availableDates) && $selectedDateId) {
                            $selectedDateObj = array_filter($availableDates, function($d) use ($selectedDateId) { return $d['id'] == $selectedDateId; });
                            if ($selectedDateObj) {
                                $selectedDateObj = array_values($selectedDateObj)[0];
                                $displayDate = date('d M Y', strtotime($selectedDateObj['tanggal']));
                            }
                        }
                    ?>
                    <div>
                        <h5 class="fw-bold mb-1 fs-6">SUMMARY : <span id="summaryLocation" class="text-primary-dark fw-normal"></span> | Date: <span id="summaryDate" class="text-primary-dark fw-normal"><?= htmlspecialchars($displayDate) ?></span></h5>
                        <p class="mb-0 text-muted small">Movie: <span class="fw-bold text-dark"><?= htmlspecialchars($movieDetail['title']) ?></span> | Class: 2D | Time: <span id="summaryTime" class="fw-bold text-dark fs-5">16:40</span></p>
                    </div>
                    <a href="javascript:void(0)" id="pickSeatBtn" class="text-decoration-none" <?= !isset($_SESSION['user_id']) ? 'data-bs-toggle="modal" data-bs-target="#authModal" onclick="switchAuthView(\'login\')"' : '' ?>>
                        <button class="btn btn-primary fw-bold px-4 py-3 rounded-3 ticket-btn d-flex align-items-center justify-content-center gap-2 shadow" style="background-color: #E22B2B; border-color: #E22B2B;">
                            <i class="fa-solid fa-ticket-simple"></i> PICK YOUR SEATS
                        </button>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php ob_start(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timePills = document.querySelectorAll('.time-pill:not(.disabled)');
            const bookingSummary = document.getElementById('bookingSummary');
            const summaryTime = document.getElementById('summaryTime');
            const summaryLocation = document.getElementById('summaryLocation');

            timePills.forEach(pill => {
                pill.addEventListener('click', (e) => {
                    const target = e.target;
                    
                    // If already active, unselect it
                    if (target.classList.contains('active')) {
                        target.classList.remove('active', 'bg-primary-light', 'text-white');
                        bookingSummary.classList.add('d-none');
                        bookingSummary.classList.remove('d-flex');
                        return;
                    }
                    
                    // Remove active from all
                    timePills.forEach(p => p.classList.remove('active', 'bg-primary-light', 'text-white'));
                    
                    // Add active to clicked
                    target.classList.add('active', 'bg-primary-light', 'text-white');
                    
                    // Update summary
                    summaryTime.textContent = target.textContent;
                    const cinemaName = target.closest('.d-flex').getAttribute('data-cinema');
                    summaryLocation.textContent = cinemaName;
                    
                    // Update Pick Your Seats link
                    const jadwalId = target.getAttribute('data-id');
                    const pickSeatBtn = document.getElementById('pickSeatBtn');
                    if (pickSeatBtn) {
                        <?php if (isset($_SESSION['user_id'])): ?>
                            pickSeatBtn.href = "booking?jadwal=" + jadwalId;
                        <?php else: ?>
                            pickSeatBtn.href = "javascript:void(0)";
                        <?php endif; ?>
                    }
                    
                    // Show summary bar
                    bookingSummary.classList.remove('d-none');
                    bookingSummary.classList.add('d-flex');
                    
                    // Scroll to summary smoothly
                    bookingSummary.scrollIntoView({ behavior: 'smooth', block: 'end' });
                });
            });
            
            // The date buttons are now links so they handle their own navigation
        });
    </script>
<?php $extraJs = ob_get_clean(); ?>
