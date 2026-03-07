<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-slate-900">Petugas Overview</h2>
    <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-pill">
        <i class="bi bi-calendar3 me-2 text-success"></i> <?= date('d M Y') ?>
    </span>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-hourglass-split text-warning fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Menunggu Persetujuan</p>
                    <h3 class="fw-bold mb-0"><?= $pending_count ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-box-seam text-primary fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Pinjaman Aktif</p>
                    <h3 class="fw-bold mb-0"><?= $aktif_count ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white border-start border-success border-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-check-all text-success fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Verifikasi Selesai</p>
                    <h3 class="fw-bold mb-0"><?= $kembali_today ?></h3>
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
                        <thead class="bg-light text-muted small uppercase">
                            <tr>
                                <th class="ps-4">Siswa / Peminjam</th>
                                <th>Alat</th>
                                <th>Tanggal Pengajuan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">Repan</div>
                                    <small class="text-muted">XII RPL 1</small>
                                </td>
                                <td>Oscilloscope Rigol</td>
                                <td><?= date('d M Y') ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('petugas/peminjaman') ?>" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-check-circle me-1"></i> Validasi
                                    </a>
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