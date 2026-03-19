<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/peminjaman" class="text-decoration-none small fw-bold text-emerald">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h2 class="fw-bold text-slate-900 mt-2">Update Peminjaman</h2>
    <p class="text-muted small">ID Transaksi: #<?= $peminjaman['id'] ?> | Status saat ini: <strong><?= strtoupper($peminjaman['status']) ?></strong></p>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <form action="/admin/peminjaman/update/<?= $peminjaman['id'] ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-4 p-3 bg-light rounded-3 d-flex align-items-center">
                        <i class="bi bi-box-seam text-emerald fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Alat yang dipinjam:</small>
                            <span class="fw-bold text-slate-900"><?= $peminjaman['nama_alat'] ?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Tanggal Pinjam</label>
                            <?php if($peminjaman['status'] == 'pending'): ?>
                                <input type="date" name="tanggal_pinjam" value="<?= $peminjaman['tanggal_pinjam'] ?>" class="form-control border-0 bg-light rounded-3">
                            <?php else: ?>
                                <input type="date" class="form-control border-0 bg-light rounded-3 opacity-75" value="<?= $peminjaman['tanggal_pinjam'] ?>" disabled>
                                <input type="hidden" name="tanggal_pinjam" value="<?= $peminjaman['tanggal_pinjam'] ?>">
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Tanggal Kembali</label>
                            <?php if(!in_array($peminjaman['status'], ['selesai', 'ditolak', 'dibatalkan'])): ?>
                                <input type="date" name="tanggal_kembali" value="<?= $peminjaman['tanggal_kembali'] ?>" class="form-control border-0 bg-light rounded-3" min="<?= $peminjaman['tanggal_pinjam'] ?>">
                            <?php else: ?>
                                <input type="date" class="form-control border-0 bg-light rounded-3 opacity-75" value="<?= $peminjaman['tanggal_kembali'] ?>" disabled>
                                <input type="hidden" name="tanggal_kembali" value="<?= $peminjaman['tanggal_kembali'] ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Ubah Status Transaksi</label>
                        <?php if($peminjaman['status'] == 'selesai'): ?>
                            <input type="text" class="form-control border-0 bg-success bg-opacity-10 text-success fw-bold rounded-3" value="SELESAI (Transaksi Terkunci)" readonly>
                            <input type="hidden" name="status" value="selesai">
                        
                        <?php elseif($peminjaman['status'] == 'ditolak'): ?>
                            <input type="text" class="form-control border-0 bg-danger bg-opacity-10 text-danger fw-bold rounded-3" value="DITOLAK (Status Final)" readonly>
                            <input type="hidden" name="status" value="ditolak">

                        <?php elseif($peminjaman['status'] == 'dibatalkan'): ?>
                            <input type="text" class="form-control border-0 bg-secondary bg-opacity-10 text-secondary fw-bold rounded-3" value="DIBATALKAN (Status Final)" readonly>
                            <input type="hidden" name="status" value="dibatalkan">

                             <?php elseif($peminjaman['status'] == 'menunggu_verifikasi'): ?>
                            <input type="text" class="form-control border-0 bg-secondary bg-opacity-10 text-secondary fw-bold rounded-3" value="MENUNGGU VERIFIKASI (Diproses di menu Pengembalian)" readonly>
                            <input type="hidden" name="status" value="menunggu_verifikasi">

                        <?php else: ?>
                            <select name="status" class="form-select border-0 bg-light rounded-3 fw-bold text-emerald">
                                <?php if($peminjaman['status'] == 'pending'): ?>
                                    <option value="pending" selected>PENDING (Menunggu Verifikasi)</option>
                                    <option value="dipinjam">APPROVE (Serahkan Alat & Kurangi Stok)</option>
                                    <option value="ditolak">REJECT (Tolak Peminjaman)</option>
                                <?php elseif($peminjaman['status'] == 'dipinjam'): ?>
                                    <option value="dipinjam" selected>DIPINJAM (Aktif)</option>
                                    <option value="dibatalkan">BATALKAN (Kembalikan Stok Alat)</option>
                                <?php endif; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Keterangan / Catatan Admin</label>
                        <textarea name="keterangan" class="form-control border-0 bg-light rounded-3" rows="3"><?= trim($peminjaman['keterangan']) ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-emerald py-2 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>Update Data Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 mb-3" style="background: #0f172a;">
            <div class="card-body p-4">
                <h6 class="text-uppercase fw-bold mb-4" style="color: #34d399; font-size: 0.75rem; letter-spacing: 1px;">
                    Detail Peminjam
                </h6>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-shrink-0 bg-emerald p-3 rounded-4 shadow-sm">
                        <i class="bi bi-person-badge fs-3 text-white"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="fw-bold text-white mb-0"><?= $peminjaman['nama'] ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header border-0 bg-white pt-4 px-4 pb-0">
                <h6 class="fw-bold text-slate-900 mb-0">
                    <i class="bi bi-shield-check text-emerald me-2"></i>Alur Sistem
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex gap-3 mb-3">
                    <div class="bg-light-emerald p-2 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-emerald fw-bold small">1</span>
                    </div>
                    <p class="small text-muted mb-0">Status <strong>Approve</strong> akan mengurangi stok alat otomatis secara real-time.</p>
                </div>

                <div class="d-flex gap-3 mb-3">
                    <div class="bg-light-emerald p-2 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-emerald fw-bold small">2</span>
                    </div>
                    <p class="small text-muted mb-0">Status <strong>Batalkan</strong> akan mengembalikan stok (+1) ke inventaris.</p>
                </div>

                <div class="d-flex gap-3">
                    <div class="bg-light-emerald p-2 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-emerald fw-bold small">3</span>
                    </div>
                    <p class="small text-muted mb-0">Status <strong>Selesai/Final</strong> mengunci status agar histori data tetap valid.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .text-emerald { color: #10b981 !important; }
    .bg-emerald { background-color: #10b981 !important; }
    .bg-light-emerald { background-color: rgba(16, 185, 129, 0.1) !important; }
    .bg-light { background-color: #f8fafc !important; }
    .text-slate-900 { color: #0f172a !important; }
    
    .card { min-height: fit-content; }
    
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #10b981 !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1);
    }
</style>

<?= $this->endSection() ?>