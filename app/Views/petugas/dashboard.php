<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900">Petugas Overview</h2>
        <p class="text-muted small">Kelola validasi dan monitoring alat laboratorium.</p>
    </div>
    <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-pill">
        <i class="bi bi-calendar3 me-2 text-emerald"></i> <?= date('d M Y') ?>
    </span>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 p-3 rounded-3" style="background-color: #fffbeb;">
                    <i class="bi bi-hourglass-split fs-3" style="color: #f59e0b;"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Menunggu Validasi</p>
                    <h3 class="fw-bold mb-0 text-slate-900"><?= $pending_count ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 p-3 rounded-3" style="background-color: #eff6ff;">
                    <i class="bi bi-box-seam fs-3" style="color: #3b82f6;"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Pinjaman Aktif</p>
                    <h3 class="fw-bold mb-0 text-slate-900"><?= $aktif_count ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white border-start border-emerald border-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 p-3 rounded-3" style="background-color: #ecfdf5;">
                    <i class="bi bi-check-all fs-3" style="color: #10b981;"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Selesai Hari Ini</p>
                    <h3 class="fw-bold mb-0 text-slate-900"><?= $kembali_today ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Antrean Validasi Peminjaman</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4 py-3">PEMINJAM</th>
                                <th>ALAT</th>
                                <th>TANGGAL PENGAJUAN</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($antrean)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted small">Tidak ada antrean validasi.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($antrean as $row): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-slate-900"><?= $row['nama_siswa'] ?></div>
                                    </td>
                                    <td><?= $row['nama_alat'] ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('petugas/peminjaman') ?>" class="btn btn-sm btn-emerald rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-shield-check me-1"></i> Proses
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    .border-emerald { border-color: #10b981 !important; }
    .text-slate-900 { color: #0f172a !important; }
</style>

<?= $this->endSection() ?>