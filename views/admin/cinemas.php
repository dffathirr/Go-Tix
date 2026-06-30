<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Kelola Bioskop</h2>
    <button class="btn btn-primary fw-bold px-4" data-bs-toggle="modal" data-bs-target="#addCinemaModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Bioskop
    </button>
</div>

<?php if (isset($_SESSION['success_msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error_msg'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="10%">ID</th>
                        <th width="70%">Nama Bioskop</th>
                        <th class="text-end pe-4" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cinemas as $c): ?>
                    <tr>
                        <td class="ps-4">#<?= $c['id'] ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($c['nama']) ?></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCinemaModal<?= $c['id'] ?>">Edit</button>
                            <form action="admin/delete-cinema" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus bioskop ini?');">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editCinemaModal<?= $c['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Edit Bioskop</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="admin/update-cinema" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Bioskop</label>
                                            <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($c['nama']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary fw-bold px-4">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($cinemas)): ?>
                <div class="p-4 text-center text-muted">Belum ada data bioskop.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addCinemaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Bioskop Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="admin/store-cinema" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Bioskop</label>
                        <input type="text" class="form-control" name="nama" required placeholder="Contoh: CGV Grand Indonesia">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Tambah Bioskop</button>
                </div>
            </form>
        </div>
    </div>
</div>
