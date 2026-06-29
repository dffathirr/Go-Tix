<?php 
$title = 'Pilih Kursi - G0-Tix';
$activeMenu = ''; 
ob_start();
?>
    <style>
        .seat-btn {
            width: 45px;
            height: 45px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            border-radius: 8px 8px 4px 4px;
            transition: all 0.2s;
        }
        .seat-btn.selected {
            background-color: #E22B2B;
            color: white;
            border-color: #E22B2B;
        }
        .seat-available {
            border: 2px solid #00B171;
            color: #00B171;
            background-color: transparent;
        }
        .seat-available:hover {
            background-color: #00B171;
            color: white;
        }
        .seat-booked {
            background-color: #d3d3d3;
            color: #fff;
            border: 2px solid #d3d3d3;
            cursor: not-allowed;
            opacity: 0.7;
        }
        .screen-curve {
            height: 40px;
            background: linear-gradient(to bottom, #d1d5db 0%, transparent 100%);
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
            margin-bottom: 30px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-top: 5px;
            font-size: 0.8rem;
            letter-spacing: 5px;
            color: #6b7280;
            font-weight: bold;
        }
    </style>
<?php $extraCss = ob_get_clean(); ?>

    <div class="container py-4">
        <!-- Movie Info Header -->
        <div class="d-flex align-items-center mb-4 gap-3">
            <a href="movies/<?= encrypt_id($jadwalDetails['movie_id']) ?>?date=<?= encrypt_id($jadwalDetails['date_id']) ?>" class="btn btn-outline-dark rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-arrow-left"></i></a>
            <div>
                <h3 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($jadwalDetails['movie_title']) ?></h3>
                <p class="text-muted mb-0"><?= htmlspecialchars($jadwalDetails['cinema']) ?> | <?= htmlspecialchars($jadwalDetails['studio']) ?> | <?= htmlspecialchars($jadwalDetails['jam']) ?></p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Seat Selection Area -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 h-100">
                    <h5 class="fw-bold mb-4">Pilih Kursi</h5>
                    
                    <div class="screen-curve">LAYAR BIOSKOP</div>
                    
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5 mx-auto" style="max-width: 500px;">
                        <?php foreach($seats as $seat): ?>
                            <?php 
                                $isBooked = ($seat['status'] == 'booked');
                                $seatClass = $isBooked ? 'seat-booked disabled' : 'seat-available';
                            ?>
                            <button 
                                type="button" 
                                class="btn seat-btn <?= $seatClass ?>" 
                                data-id="<?= $seat['id'] ?>" 
                                data-name="<?= htmlspecialchars($seat['seat']) ?>"
                                <?= $isBooked ? 'disabled' : '' ?>
                            >
                                <?= htmlspecialchars($seat['seat']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Legend -->
                    <div class="d-flex justify-content-center gap-4 mt-auto">
                        <div class="d-flex align-items-center gap-2"><div class="rounded-circle border" style="width:15px;height:15px; border-color: #00B171 !important; border-width: 2px !important;"></div> <small>Tersedia</small></div>
                        <div class="d-flex align-items-center gap-2"><div class="rounded-circle" style="width:15px;height:15px; background-color: #E22B2B;"></div> <small>Dipilih</small></div>
                        <div class="d-flex align-items-center gap-2"><div class="rounded-circle bg-secondary bg-opacity-25" style="width:15px;height:15px;"></div> <small>Terisi</small></div>
                    </div>
                </div>
            </div>
            
            <!-- Booking Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Jadwal Tayang</span>
                        <span class="fw-bold text-end"><?= date('d M Y', strtotime($jadwalDetails['tanggal'])) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Harga Tiket</span>
                        <span class="fw-bold text-end" id="hargaSatuan" data-harga="<?= $jadwalDetails['harga'] ?>">Rp <?= number_format($jadwalDetails['harga'], 0, ',', '.') ?></span>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <p class="text-muted mb-2">Kursi yang dipilih:</p>
                        <div id="selectedSeatsContainer" class="d-flex flex-wrap gap-2 min-h-30">
                            <span class="text-muted small fst-italic">Belum ada kursi yang dipilih.</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4 mt-4">
                        <span class="fw-bold fs-5">Total Pembayaran</span>
                        <span class="fw-bold fs-5 text-primary-dark" id="totalHargaDisplay">Rp 0</span>
                    </div>
                    
                    <form action="" method="POST" id="checkoutForm">
                        <input type="hidden" name="selected_seats" id="inputSelectedSeats" value="">
                        <input type="hidden" name="total_harga" id="inputTotalHarga" value="0">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <select class="form-select rounded-3 py-2" name="payment_method" required>
                                <option value="" selected disabled>Pilih metode pembayaran...</option>
                                <?php foreach($paymentMethods as $pm): ?>
                                    <option value="<?= htmlspecialchars($pm['kode']) ?>"><?= htmlspecialchars($pm['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <button type="submit" id="btnCheckout" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm" disabled>BAYAR SEKARANG</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php ob_start(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const seats = document.querySelectorAll('.seat-available');
            const selectedContainer = document.getElementById('selectedSeatsContainer');
            const inputSelectedSeats = document.getElementById('inputSelectedSeats');
            const inputTotalHarga = document.getElementById('inputTotalHarga');
            const totalHargaDisplay = document.getElementById('totalHargaDisplay');
            const btnCheckout = document.getElementById('btnCheckout');
            
            const hargaSatuan = parseInt(document.getElementById('hargaSatuan').getAttribute('data-harga'));
            
            let selectedSeatsIds = [];
            let selectedSeatsNames = [];
            
            seats.forEach(seat => {
                seat.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    
                    if (this.classList.contains('selected')) {
                        // Deselect
                        this.classList.remove('selected');
                        this.classList.add('seat-available');
                        
                        selectedSeatsIds = selectedSeatsIds.filter(sId => sId !== id);
                        selectedSeatsNames = selectedSeatsNames.filter(sName => sName !== name);
                    } else {
                        // Select
                        this.classList.add('selected');
                        this.classList.remove('seat-available');
                        
                        selectedSeatsIds.push(id);
                        selectedSeatsNames.push(name);
                    }
                    
                    updateSummary();
                });
            });
            
            function updateSummary() {
                // Update UI for selected seats
                if (selectedSeatsNames.length > 0) {
                    selectedContainer.innerHTML = '';
                    selectedSeatsNames.forEach(name => {
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-dark px-3 py-2 rounded-pill';
                        badge.textContent = name;
                        selectedContainer.appendChild(badge);
                    });
                    
                    // Enable button
                    btnCheckout.disabled = false;
                } else {
                    selectedContainer.innerHTML = '<span class="text-muted small fst-italic">Belum ada kursi yang dipilih.</span>';
                    // Disable button
                    btnCheckout.disabled = true;
                }
                
                // Update inputs
                inputSelectedSeats.value = selectedSeatsIds.join(',');
                
                const total = selectedSeatsIds.length * hargaSatuan;
                inputTotalHarga.value = total;
                
                // Format total
                totalHargaDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        });
    </script>
<?php $extraJs = ob_get_clean(); ?>
