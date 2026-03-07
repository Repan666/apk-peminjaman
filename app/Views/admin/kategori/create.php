<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/kategori') ?>" class="text-decoration-none text-emerald">Kelola Kategori</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Tambah Kategori Alat</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form method="post" action="<?= base_url('admin/kategori/store') ?>">
                <?= csrf_field(); ?>
                
                <div class="mb-3">
                    <label class="form-label fw-600 small">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control border-light-subtle rounded-3 p-2 px-3" 
                           placeholder="Contoh: Alat Elektronik, Perkakas" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-600 small text-muted">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" class="form-control border-light-subtle rounded-3" 
                              rows="4" placeholder="Jelaskan jenis alat dalam kategori ini..."></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-emerald px-4 rounded-3 shadow-sm">Simpan Kategori</button>
                    <a href="<?= base_url('admin/kategori') ?>" class="btn btn-light border px-4 rounded-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>