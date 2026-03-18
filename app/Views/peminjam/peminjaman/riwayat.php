<?= $this->extend('layouts/peminjam_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Riwayat Peminjaman</h2>
        <p class="text-muted small mb-0">Lacak status pengajuan dan pengembalian alat kamu.</p>
    </div>
    <div>
        <a href="<?= base_url('peminjam/alat') ?>" class="btn btn-emerald rounded-pill px-4 shadow-sm fw-bold">
            <i class="bi bi-plus-lg me-2"></i>Pinjam Alat Baru
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
        <div><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4 py-3">Informasi Alat</th>
                        <th>Jadwal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($riwayat)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="bi bi-clock-history" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-muted">Belum ada riwayat peminjaman</h5>
                            <p class="text-muted small">Alat yang kamu pinjam akan muncul di sini.</p>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php foreach($riwayat as $r): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="fw-bold text-slate-900"><?= $r['nama_alat'] ?></div>
                            <div class="text-muted small font-monospace"><?= $r['kode_alat'] ?></div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                <span><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-check text-danger me-2"></i>
                                <span><?= date('d M Y', strtotime($r['tanggal_kembali'])) ?></span>
                            </div>
                        </td>
                        <td>
                            <?php 
                            $badgeColor = 'secondary';
                            $icon = 'bi-info-circle';
                            
                            if($r['status'] == 'pending') {
                                $badgeColor = 'warning';
                                $icon = 'bi-hourglass-split';
                            } elseif($r['status'] == 'dipinjam') {
                                $badgeColor = 'success';
                                $icon = 'bi-box-arrow-right';
                            } elseif($r['status'] == 'ditolak') {
                                $badgeColor = 'danger';
                                $icon = 'bi-x-circle';
                            } elseif($r['status'] == 'dikembalikan') {
                                $badgeColor = 'info';
                                $icon = 'bi-check-all';
                            }
                            ?>
                            <span class="badge bg-<?= $badgeColor ?> bg-opacity-10 text-<?= $badgeColor ?> px-3 py-2 rounded-pill fw-bold border border-<?= $badgeColor ?> border-opacity-10">
                                <i class="bi <?= $icon ?> me-1"></i>
                                <?= strtoupper($r['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; transition: 0.3s; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-2px); }
</style>

<?= $this->endSection() ?>