<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('petugas/peminjaman') ?>" class="text-decoration-none text-muted small fw-bold">
        <i class="bi bi-arrow-left me-1"></i> KEMBALI KE DAFTAR
    </a>
    <h2 class="fw-bold text-slate-900 mt-2">Detail Validasi Peminjaman</h2>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-person-badge me-2 text-success"></i>Informasi Pengajuan</h5>
            
            <div class="row mb-4">
                <div class="col-sm-6">
                    <label class="text-muted small uppercase fw-bold d-block">Nama Peminjam</label>
                    <span class="fs-5 fw-bold text-dark"><?= $peminjaman['nama_user'] ?></span>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <label class="text-muted small uppercase fw-bold d-block">Status Saat Ini</label>
                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill"><?= strtoupper($peminjaman['status']) ?></span>
                </div>
            </div>

            <div class="bg-light rounded-4 p-4 border border-dashed mb-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="bg-white p-3 rounded-3 shadow-sm text-success">
                            <i class="bi bi-box-seam fs-1"></i>
                        </div>
                    </div>
                    <div class="col">
                        <label class="text-muted small fw-bold d-block">Alat yang Diminta</label>
                        <h4 class="fw-bold mb-0"><?= $peminjaman['nama_alat'] ?></h4>
                        <span class="font-monospace text-muted small"><?= $peminjaman['kode_alat'] ?></span>
                    </div>
                    <div class="col-auto text-end">
                        <label class="text-muted small fw-bold d-block">Stok Tersedia</label>
                        <h3 class="fw-bold text-success mb-0"><?= $peminjaman['stok'] ?> <small class="fs-6 text-muted">Unit</small></h3>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-white">
                        <label class="text-muted small fw-bold d-block">Rencana Pinjam</label>
                        <div class="d-flex align-items-center text-primary mt-1">
                            <i class="bi bi-calendar-plus me-2 fs-5"></i>
                            <span class="fw-bold"><?= date('d F Y', strtotime($peminjaman['tanggal_pinjam'])) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-white">
                        <label class="text-muted small fw-bold d-block">Rencana Kembali</label>
                        <div class="d-flex align-items-center text-danger mt-1">
                            <i class="bi bi-calendar-check me-2 fs-5"></i>
                            <span class="fw-bold"><?= date('d F Y', strtotime($peminjaman['tanggal_kembali'])) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <label class="text-muted small fw-bold d-block">Keterangan Peminjam</label>
                    <p class="p-3 bg-light rounded-3 italic text-muted">
                        "<?= $peminjaman['keterangan'] ?: 'Tidak ada keterangan tambahan.' ?>"
                    </p>
                </div>
            </div>

            <div class="mt-5 pt-3 border-top">
                <?php if($peminjaman['status'] == 'pending'): ?>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('petugas/peminjaman/setuju/'.$peminjaman['id']) ?>" 
                           class="btn btn-success px-5 py-2 rounded-pill shadow-sm fw-bold">
                           <i class="bi bi-check2-circle me-2"></i>SETUJUI PINJAMAN
                        </a>
                        <a href="<?= base_url('petugas/peminjaman/tolak/'.$peminjaman['id']) ?>" 
                           class="btn btn-danger px-4 py-2 rounded-pill shadow-sm fw-bold"
                           onclick="return confirm('Apakah Anda yakin ingin MENOLAK pengajuan ini?')">
                           <i class="bi bi-x-circle me-2"></i>TOLAK
                        </a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary border-0 rounded-4 d-flex align-items-center">
                        <i class="bi bi-lock-fill fs-4 me-3"></i>
                        <span>Pengajuan ini telah diproses dan tidak dapat diubah kembali melalui halaman ini.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-slate-900 text-white p-4">
            <h6 class="fw-bold opacity-75 mb-3 uppercase small">Panduan Petugas</h6>
            <ul class="list-unstyled small mb-0">
                <li class="mb-3 d-flex">
                    <i class="bi bi-1-circle me-2 text-success"></i>
                    <span>Pastikan stok fisik alat di laboratorium mencukupi.</span>
                </li>
                <li class="mb-3 d-flex">
                    <i class="bi bi-2-circle me-2 text-success"></i>
                    <span>Cek apakah peminjam memiliki riwayat telat kembali.</span>
                </li>
                <li class="d-flex">
                    <i class="bi bi-3-circle me-2 text-success"></i>
                    <span>Setelah klik "Setujui", siswa dapat mengambil alat di meja petugas.</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .bg-slate-900 { background-color: #0F172A; }
    .text-success { color: #10B981 !important; }
    .btn-success { background-color: #10B981; border: none; }
    .btn-success:hover { background-color: #059669; }
</style>

<?= $this->endSection() ?>