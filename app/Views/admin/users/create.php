<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>" class="text-decoration-none">Kelola User</a></li>
            <li class="breadcrumb-item active">Tambah User</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Tambah User Baru</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form method="post" action="<?= base_url('admin/users/store') ?>">
                <?= csrf_field(); ?>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control rounded-3" placeholder="Contoh: John Doe" value="<?= old('nama') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">@</span>
                        <input type="text" name="username" class="form-control rounded-end-3 border-start-0" placeholder="username" value="<?= old('username') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Password</label>
                    <input type="password" name="password" class="form-control rounded-3" placeholder="••••••••" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Hak Akses (Role)</label>
                    <select name="role" class="form-select rounded-3" required>
                        <option value="" disabled <?= old('role') ? '' : 'selected' ?>>Pilih Role</option>
                        <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="petugas" <?= old('role') == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                        <option value="peminjam" <?= old('role') == 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-emerald px-4 rounded-3 text-white">Simpan Data</button>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light border px-4 rounded-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; border: none; }
    .btn-emerald:hover { background-color: #059669; }
</style>

<?= $this->endSection() ?>