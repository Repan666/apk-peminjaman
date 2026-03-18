<?= $this->extend('layouts/peminjam_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900">Halo, <?= session()->get('nama') ?>!</h2>
        <p class="text-muted small">Cek status peminjaman dan cari alat di sini.</p>
    </div>
    <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-pill">
        <i class="bi bi-calendar3 me-2 text-emerald"></i> <?= date('d M Y') ?>
    </span>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white transition-hover">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 p-3 rounded-3" style="background-color: #fffbeb;">
                    <i class="bi bi-arrow-repeat fs-3" style="color: #f59e0b;"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Sedang Dipinjam</p>
                    <h3 class="fw-bold mb-0 text-slate-900"><?= $total_aktif ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 rounded-4 bg-white transition-hover">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 p-3 rounded-3" style="background-color: #eff6ff;">
                    <i class="bi bi-journal-check fs-3" style="color: #3b82f6;"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Riwayat</p>
                    <h3 class="fw-bold mb-0 text-slate-900"><?= $total_pinjam ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-2 text-white transition-hover" style="background-color: #10b981;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1 small opacity-75">Butuh alat praktik?</p>
                    <a href="<?= base_url('peminjam/alat') ?>" class="text-white fw-bold text-decoration-none fs-5">
                        Cari Alat <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                <i class="bi bi-search fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Status Pengajuan Terakhir</h5>
                <a href="<?= base_url('peminjam/riwayat') ?>" class="btn btn-sm btn-light border rounded-pill px-3 text-emerald fw-bold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4 py-3">ALAT</th>
                                <th>TGL PINJAM</th>
                                <th>STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($pengajuan_terakhir)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted small mb-0">Kamu belum pernah meminjam alat.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($pengajuan_terakhir as $pj): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-slate-900"><?= $pj['nama_alat'] ?></div>
                                        <small class="text-muted">Kategori: <?= $pj['nama_kategori'] ?? 'Umum' ?></small>
                                    </td>
                                    <td class="small text-muted"><?= date('d M Y', strtotime($pj['tanggal_pinjam'])) ?></td>
                                    <td>
                                        <?php 
                                            $status = strtolower($pj['status']);
                                            $badge = 'bg-secondary';
                                            if($status == 'pending') $badge = 'bg-warning text-dark';
                                            elseif($status == 'dipinjam') $badge = 'bg-info text-white';
                                            elseif($status == 'selesai') $badge = 'bg-success text-white';
                                            elseif($status == 'ditolak') $badge = 'bg-danger text-white';
                                        ?>
                                        <span class="badge rounded-pill <?= $badge ?>" style="font-size: 0.7rem;">
                                            <?= strtoupper($status) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('peminjam/riwayat') ?>" class="btn btn-sm btn-light border rounded-pill px-3">
                                            <i class="bi bi-info-circle"></i> Detail
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
    .text-emerald { color: #10b981 !important; }
    .text-slate-900 { color: #0f172a !important; }
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); }
</style>

<?= $this->endSection() ?>