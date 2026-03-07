<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/alat') ?>" class="text-decoration-none text-emerald">Data Alat</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Update Data Alat</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form action="<?= base_url('admin/alat/update/'.$alat['id']) ?>" method="post">
                <?= csrf_field(); ?>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Kode Unik Alat</label>
                        <input type="text" name="kode_alat" value="<?= $alat['kode_alat'] ?>" class="form-control rounded-3 bg-light" readonly>
                        <div class="form-text small italic">Kode alat tidak dapat diubah.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Nama Alat</label>
                        <input type="text" name="nama_alat" value="<?= $alat['nama_alat'] ?>" class="form-control rounded-3" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Kategori</label>
                        <select name="kategori_id" class="form-select rounded-3" required>
                            <?php foreach($kategori as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= $alat['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                                    <?= $k['nama_kategori'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold small">Update Stok</label>
                        <input type="number" name="stok" value="<?= $alat['stok'] ?>" class="form-control rounded-3" min="0" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold small">Kondisi Saat Ini</label>
                        <select name="kondisi" class="form-select rounded-3">
                            <option value="baik" <?= $alat['kondisi']=='baik'?'selected':'' ?>>Baik</option>
                            <option value="rusak ringan" <?= $alat['kondisi']=='rusak ringan'?'selected':'' ?>>Rusak Ringan</option>
                            <option value="rusak berat" <?= $alat['kondisi']=='rusak berat'?'selected':'' ?>>Rusak Berat</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-emerald px-4 rounded-3 shadow-sm">Update Perubahan</button>
                    <a href="<?= base_url('admin/alat') ?>" class="btn btn-light border px-4 rounded-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>