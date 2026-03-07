<?= $this->extend('layouts/peminjam_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-slate-900">Dashboard Overview</h2>
    <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-pill">
        <i class="bi bi-calendar3 me-2 text-success"></i> <?= date('d M Y') ?>
    </span>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-arrow-repeat text-warning fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Sedang Dipinjam</p>
                    <h3 class="fw-bold mb-0"><?= $total_aktif ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-journal-check text-primary fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Riwayat</p>
                    <h3 class="fw-bold mb-0"><?= $total_pinjam ?? 0 ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100 p-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 small">Butuh alat?</p>
                    <a href="<?= base_url('peminjam/alat') ?>" class="text-white fw-bold text-decoration-none">Cari Sekarang <i class="bi bi-arrow-right"></i></a>
                </div>
                <i class="bi bi-search fs-2 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Status Pengajuan Terakhir</h5>
                <a href="<?= base_url('peminjam/riwayat') ?>" class="btn btn-sm btn-light text-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small uppercase">
                            <tr>
                                <th class="ps-4 py-3">Alat</th>
                                <th>Tgl Pinjam</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">Multimeter Digital</div>
                                    <small class="text-muted">Kategori: Elektronik</small>
                                </td>
                                <td>03 Mar 2026</td>
                                <td><span class="badge bg-warning text-dark px-3 rounded-pill">Pending</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light border rounded-pill"><i class="bi bi-info-circle"></i> Detail</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>