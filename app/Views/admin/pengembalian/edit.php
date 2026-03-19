<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/pengembalian" class="text-decoration-none small fw-bold text-emerald">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <h2 class="fw-bold text-slate-900 mt-2">Verifikasi Pengembalian</h2>
    <p class="text-muted small">Update tanggal dikembalikan untuk menghitung denda dan update stok otomatis.</p>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="/admin/pengembalian/update/<?= $peminjaman['id'] ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-4 p-3 bg-light rounded-4 border-start border-emerald border-4">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Peminjam:</small>
                                <span class="fw-bold text-slate-900"><?= $peminjaman['nama'] ?></span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Alat Praktikum:</small>
                                <span class="fw-bold text-slate-900"><?= $peminjaman['nama_alat'] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Tanggal Dikembalikan</label>
                            <input type="date" name="tanggal_dikembalikan" 
                                   id="tgl_dikembalikan"
                                   class="form-control border-0 bg-light rounded-3 fw-bold" 
                                   value="<?= $peminjaman['tanggal_dikembalikan'] ?? date('Y-m-d') ?>" required>
                            <div class="form-text text-xs">Default: Hari ini</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Ubah Status</label>
                            <select name="status" class="form-select border-0 bg-light rounded-3 fw-bold text-emerald">
                                <?php if($peminjaman['status'] == 'menunggu_verifikasi'): ?>
                                    <option value="menunggu_verifikasi" selected>MENUNGGU VERIFIKASI</option>
                                    <option value="selesai">SELESAI (Verifikasi & Tambah Stok)</option>
                                <?php else: ?>
                                    <option value="selesai" selected>SELESAI (Audit Ulang)</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Keterangan</label>
                        <textarea name="keterangan" class="form-control border-0 bg-light rounded-3" rows="3" placeholder="Contoh: Alat kembali dalam keadaan bersih..."><?= trim($peminjaman['keterangan']) ?></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-emerald py-2 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-shield-check me-2"></i>Simpan Perubahan & Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 bg-slate-900 text-white mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4 opacity-75">Informasi Batas Waktu</h6>
                
                <div class="mb-3">
                    <small class="text-white-50 d-block">Tanggal Seharusnya Kembali:</small>
                    <span class="fw-bold fs-5 text-warning">
                        <i class="bi bi-calendar-event me-2"></i><?= date('d M Y', strtotime($peminjaman['tanggal_kembali'])) ?>
                    </span>
                </div>

                <hr class="opacity-25">

                <div class="p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10">
                    <h6 class="small fw-bold text-uppercase mb-3"><i class="bi bi-calculator me-2"></i>Prediksi Denda</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small opacity-75">Tarif Denda / Hari</span>
                        <span class="fw-bold">Rp <?= number_format($tarif, 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small opacity-75">Denda Saat Ini</span>
                        <span class="fw-bold <?= $peminjaman['denda'] > 0 ? 'text-danger' : 'text-success' ?>">
                            Rp <?= number_format($peminjaman['denda'], 0, ',', '.') ?>
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="small mb-2"><i class="bi bi-info-circle me-2 text-info"></i> <strong>Penting:</strong></div>
                    <ul class="ps-3 small opacity-75 mb-0">
                        <li>Mengubah status ke <strong>Selesai</strong> akan menambah stok alat <strong>+1</strong> secara otomatis.</li>
                        <li>Denda dihitung dari selisih tanggal kembali dan tanggal dikembalikan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .bg-light { background-color: #f8fafc !important; }
    .text-emerald { color: #10b981 !important; }
    .bg-slate-900 { background-color: #0F172A !important; }
    .text-xs { font-size: 0.75rem; }
    
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #10b981 !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1);
    }
</style>

<?= $this->endSection() ?>