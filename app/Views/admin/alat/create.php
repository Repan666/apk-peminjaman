<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/alat') ?>" class="text-decoration-none text-emerald">Data Alat</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Registrasi Alat Baru</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form action="<?= base_url('admin/alat/store') ?>" method="post">
                <?= csrf_field(); ?>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Kode Unik Alat</label>
                        <input type="text" name="kode_alat" class="form-control rounded-3" placeholder="Contoh: ALT-001" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control rounded-3" placeholder="Contoh: Proyektor Epson" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Kategori</label>
                        <select name="kategori_id" class="form-select rounded-3" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <?php foreach($kategori as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold small">Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control rounded-3" min="0" placeholder="0" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold small">Kondisi Awal</label>
                        <select name="kondisi" class="form-select rounded-3" required>
                            <option value="baik">Baik</option>
                            <option value="rusak ringan">Rusak Ringan</option>
                            <option value="rusak berat">Rusak Berat</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-emerald px-4 rounded-3 shadow-sm">Simpan Data Alat</button>
                    <a href="<?= base_url('admin/alat') ?>" class="btn btn-light border px-4 rounded-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>