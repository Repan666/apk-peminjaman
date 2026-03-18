<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>" class="text-decoration-none">Kelola User</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Edit Data User</h2>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-bg-white">
            <form method="post" action="<?= base_url('users/update/'.$user['id']) ?>">
                <?= csrf_field(); ?>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control rounded-3" value="<?= $user['nama'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">@</span>
                        <input type="text" name="username" class="form-control border-start-0 rounded-end-3" value="<?= $user['username'] ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Password Baru</label>
                    <input type="password" name="password" class="form-control rounded-3" placeholder="Biarkan kosong jika tidak ingin diubah">
                    <div class="form-text text-muted small mt-1">Hanya isi jika ingin mengganti password.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Hak Akses (Role)</label>
                    <select name="role" class="form-select rounded-3">
                        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                        <option value="petugas" <?= $user['role']=='petugas'?'selected':'' ?>>Petugas</option>
                        <option value="peminjam" <?= $user['role']=='peminjam'?'selected':'' ?>>Peminjam</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-emerald px-4 rounded-3">Update User</button>
                    <a href="<?= base_url('users') ?>" class="btn btn-light border px-4 rounded-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>