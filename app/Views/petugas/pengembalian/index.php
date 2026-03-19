<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold text-slate-900 mb-1">Verifikasi Pengembalian</h2>
    <p class="text-muted small mb-0">Daftar alat yang telah dikembalikan peminjam dan menunggu validasi stok/denda.</p>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4 py-3">Peminjam</th>
                        <th>Alat & Kode</th>
                        <th>Deadline</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pengembalian as $p): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-slate-900 small"><?= $p['nama_user'] ?></div>
                            
                        </td>
                        <td>
                            <div class="fw-bold text-dark small"><?= $p['nama_alat'] ?></div>
                            <code class="text-emerald" style="font-size: 0.7rem;"><?= $p['kode_alat'] ?></code>
                        </td>
                        <td>
                            <div class="small text-muted"><?= date('d/m/Y', strtotime($p['tanggal_kembali'])) ?></div>
                        </td>
                        <td>
                            <div class="small fw-bold text-slate-900"><?= date('d/m/Y', strtotime($p['tanggal_dikembalikan'])) ?></div>
                        </td>
                        <td>
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill small fw-bold">
                                <i class="bi bi-clock-history me-1"></i> MENUNGGU VERIFIKASI
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <a href="<?= base_url('petugas/pengembalian/detail/'.$p['id']) ?>" 
                               class="btn btn-emerald btn-sm px-4 rounded-pill fw-bold shadow-sm">
                                Periksa Alat
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    .text-emerald { color: #10b981; }
</style>

<?= $this->endSection() ?>