<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/alat') ?>" class="text-decoration-none text-emerald fw-bold small">Data Alat</a></li>
            <li class="breadcrumb-item active small">Registrasi Baru</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Registrasi Alat Baru</h2>
    <p class="text-muted small">Sistem akan otomatis memberikan kode unik untuk setiap alat yang didaftarkan.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <form action="<?= base_url('admin/alat/store') ?>" method="post">
                <?= csrf_field(); ?>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-slate-900 small">Kode Unik Alat</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                <i class="bi bi-qr-code text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 rounded-end-3 bg-light fw-bold text-emerald" 
                                   value="AUTO-GENERATED" disabled style="cursor: not-allowed; letter-spacing: 1px;">
                        </div>
                        <div class="form-text small" style="font-size: 0.7rem;">
                            <i class="bi bi-info-circle me-1"></i> Kode dibuat otomatis oleh sistem (Format: ALT-XXX).
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-slate-900 small">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control rounded-3 py-2" 
                               placeholder="Contoh: Proyektor Epson EB-X51" required value="<?= old('nama_alat') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-slate-900 small">Kategori Alat</label>
                        <select name="kategori_id" class="form-select rounded-3 py-2" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <?php foreach($kategori as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= old('kategori_id') == $k['id'] ? 'selected' : '' ?>>
                                    <?= $k['nama_kategori'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold text-slate-900 small">Jumlah Stok</label>
                                <input type="number" name="stok" class="form-control rounded-3 py-2" 
                                       min="1" placeholder="0" required value="<?= old('stok', 1) ?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-slate-900 small">Kondisi Awal</label>
                                <select name="kondisi" class="form-select rounded-3 py-2" required>
                                    <option value="baik">Baik</option>
                                    <option value="rusak ringan">Rusak Ringan</option>
                                    <option value="rusak berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5 opacity-10">

                <div class="d-flex flex-column flex-sm-row gap-2">
                    <button type="submit" class="btn btn-emerald px-5 py-2 rounded-3 shadow-sm text-white fw-bold order-2 order-sm-1">
                        <i class="bi bi-plus-circle me-2"></i>Simpan Alat
                    </button>
                    <a href="<?= base_url('admin/alat') ?>" class="btn btn-light border px-4 py-2 rounded-3 text-muted order-1 order-sm-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="bg-white border-start border-4 border-emerald rounded-4 p-4 shadow-sm h-100">
            <h6 class="fw-bold text-slate-900 mb-3 small text-uppercase">Tips Registrasi</h6>
            <div class="d-flex align-items-start mb-3">
                <i class="bi bi-lightning-charge text-warning me-3 mt-1"></i>
                <p class="small text-muted mb-0"><strong>Kode Otomatis:</strong> Anda tidak perlu repot menghafal urutan kode. Sistem akan mengambil nomor urut terakhir secara akurat.</p>
            </div>
            <div class="d-flex align-items-start">
                <i class="bi bi-shield-check text-emerald me-3 mt-1"></i>
                <p class="small text-muted mb-0"><strong>Kondisi:</strong> Pastikan kondisi awal alat sesuai dengan fisik aslinya untuk akurasi laporan inventaris.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .text-emerald { color: #10b981 !important; }
    .btn-emerald { background-color: #10b981; border: none; transition: 0.3s; }
    .btn-emerald:hover { background-color: #059669; transform: translateY(-2px); }
    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1);
    }
    input:disabled { background-color: #f8fafc !important; }
</style>

<?= $this->endSection() ?>