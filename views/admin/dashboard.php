<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Dashboard Overview</h2>
    <div class="text-muted"><i class="fa-regular fa-clock me-1"></i> <?= date('d F Y') ?></div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-film fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted fw-bold mb-1">Total Film</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($stats['total_movies']) ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-building fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted fw-bold mb-1">Total Bioskop</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($stats['total_cinemas']) ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-receipt fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted fw-bold mb-1">Total Pesanan</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($stats['total_bookings']) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 text-center text-muted">
        <i class="fa-solid fa-chart-line fs-1 mb-3 text-secondary opacity-50"></i>
        <h5>Selamat Datang di Panel Admin</h5>
        <p class="mb-0">Pilih menu di sebelah kiri untuk mengelola data aplikasi Go-Tix.</p>
    </div>
</div>
