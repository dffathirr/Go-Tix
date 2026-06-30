<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Laporan Pesanan</h2>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Film</th>
                        <th>Tanggal Tayang</th>
                        <th>Jml Tiket</th>
                        <th>Total Harga</th>
                        <th>Pembayaran</th>
                        <th class="pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td class="ps-4 fw-bold text-primary">#<?= $b['id'] ?></td>
                        <td><?= htmlspecialchars($b['customer_name'] ?? 'Guest') ?></td>
                        <td><?= htmlspecialchars($b['movie_title'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($b['tanggal'] ?? '-') ?></td>
                        <td><?= $b['jml_tiket'] ?></td>
                        <td class="fw-bold text-success">Rp <?= number_format($b['total_harga'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($b['kd_pembayaran']) ?></td>
                        <td class="pe-4">
                            <?php if ($b['status'] == 'success'): ?>
                                <span class="badge bg-success">Berhasil</span>
                            <?php elseif ($b['status'] == 'pending'): ?>
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= htmlspecialchars($b['status']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($bookings)): ?>
                <div class="p-4 text-center text-muted">Belum ada transaksi pesanan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
