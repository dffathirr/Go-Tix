<?php 
$title = 'Pembayaran Berhasil - G0-Tix';
$activeMenu = ''; 
?>

    <div class="container py-5 mt-4 text-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="fa-solid fa-check fs-1"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-3 text-dark">Pembayaran Berhasil!</h2>
                        <p class="text-muted mb-4 fs-5">Tiketmu untuk film <strong><?= htmlspecialchars($jadwalDetails['movie_title']) ?></strong> sudah diamankan.</p>
                        
                        <div class="bg-light p-4 rounded-3 text-start mb-4">
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Kode Pesanan</div>
                                <div class="col-7 fw-bold text-end">GTX-<?= str_pad($success, 6, "0", STR_PAD_LEFT) ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Bioskop</div>
                                <div class="col-7 fw-bold text-end"><?= htmlspecialchars($jadwalDetails['cinema']) ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Studio</div>
                                <div class="col-7 fw-bold text-end"><?= htmlspecialchars($jadwalDetails['studio']) ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">Jadwal Tayang</div>
                                <div class="col-7 fw-bold text-end"><?= date('d M Y', strtotime($jadwalDetails['tanggal'])) ?> - <?= htmlspecialchars($jadwalDetails['jam']) ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5 text-muted">Total Bayar</div>
                                <div class="col-7 fw-bold text-end text-primary-dark fs-5">Rp <?= number_format($total_harga, 0, ',', '.') ?></div>
                            </div>
                        </div>

                        <a href="movies" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">KEMBALI KE BERANDA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


