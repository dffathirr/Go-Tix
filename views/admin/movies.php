<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Kelola Film</h2>
    <button class="btn btn-primary fw-bold px-4" data-bs-toggle="modal" data-bs-target="#addMovieModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Film
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
                        <th class="ps-4">ID</th>
                        <th>Judul Film</th>
                        <th>Genre</th>
                        <th>Durasi</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movies as $m): ?>
                    <tr>
                        <td class="ps-4">#<?= $m['id'] ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($m['title']) ?></td>
                        <td><?= htmlspecialchars($m['genre']) ?></td>
                        <td><?= htmlspecialchars($m['durasi']) ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($m['rating']) ?></span></td>
                        <td>
                            <?php if ($m['type'] == 'ongoing'): ?>
                                <span class="badge bg-success text-white">Sedang Tayang</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Segera Tayang</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMovieModal<?= $m['id'] ?>">Edit</button>
                            <form action="admin/delete-movie" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus film ini?');">
                                <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editMovieModal<?= $m['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Edit Film</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="admin/update-movie" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Film</label>
                                            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($m['title']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Genre</label>
                                            <input type="text" class="form-control" name="genre" value="<?= htmlspecialchars($m['genre']) ?>" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Durasi</label>
                                                <input type="text" class="form-control" name="durasi" value="<?= htmlspecialchars($m['durasi']) ?>" required placeholder="Contoh: 120 Menit">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Rating</label>
                                                <select class="form-select" name="rating" required>
                                                    <option value="SU" <?= ($m['rating'] == 'SU') ? 'selected' : '' ?>>SU (Semua Umur)</option>
                                                    <option value="13+" <?= ($m['rating'] == '13+') ? 'selected' : '' ?>>13+</option>
                                                    <option value="17+" <?= ($m['rating'] == '17+') ? 'selected' : '' ?>>17+</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status Tayang</label>
                                            <select class="form-select" name="type" required>
                                                <option value="ongoing" <?= ($m['type'] == 'ongoing') ? 'selected' : '' ?>>Sedang Tayang (Ongoing)</option>
                                                <option value="coming soon" <?= ($m['type'] == 'coming soon') ? 'selected' : '' ?>>Segera Tayang (Coming Soon)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary fw-bold px-4">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($movies)): ?>
                <div class="p-4 text-center text-muted">Belum ada data film.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMovieModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Film Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="admin/store-movie" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Film</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <input type="text" class="form-control" name="genre" required placeholder="Contoh: Action, Sci-Fi">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Durasi</label>
                            <input type="text" class="form-control" name="durasi" required placeholder="Contoh: 120 Menit">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Rating</label>
                            <select class="form-select" name="rating" required>
                                <option value="SU">SU (Semua Umur)</option>
                                <option value="13+">13+</option>
                                <option value="17+">17+</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Tayang</label>
                        <select class="form-select" name="type" required>
                            <option value="ongoing">Sedang Tayang (Ongoing)</option>
                            <option value="coming soon">Segera Tayang (Coming Soon)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Tambah Film</button>
                </div>
            </form>
        </div>
    </div>
</div>
