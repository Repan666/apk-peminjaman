<?= $this->extend('layouts/petugas_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Daftar Pengajuan</h2>
        <p class="text-muted small">Klik detail untuk memverifikasi data dan stok alat.</p>
    </div>
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
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-slate-900"><?= $p['nama_user'] ?></div>
                            <span class="text-muted small"><?= $p['role_user'] ?></span>
                        </td>
                        <td>
                            <div class="fw-medium"><?= $p['nama_alat'] ?></div>
                            <small class="font-monospace text-muted"><?= $p['kode_alat'] ?></small>
                        </td>
                        <td>
                            <span class="small fw-bold text-primary">
                                <?= date('d/m/Y', strtotime($p['tanggal_pinjam'])) ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                                $statusClass = 'bg-warning text-dark';
                                if($p['status'] == 'dipinjam') $statusClass = 'bg-success text-white';
                                if($p['status'] == 'ditolak') $statusClass = 'bg-danger text-white';
                                if($p['status'] == 'kembali') $statusClass = 'bg-secondary text-white';
                            ?>
                            <span class="badge <?= $statusClass ?> bg-opacity-10 px-3 py-2 rounded-pill fw-bold" style="color: inherit;">
                                <?= strtoupper($p['status']) ?>
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <a href="<?= base_url('petugas/peminjaman/detail/'.$p['id']) ?>" 
                               class="btn btn-white border rounded-pill px-4 btn-sm fw-bold shadow-sm">
                                <i class="bi bi-search me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>