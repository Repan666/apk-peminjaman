<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors'); ?>

<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>" class="text-emerald text-decoration-none fw-bold small">Kelola User</a></li>
            <li class="breadcrumb-item active small">Edit User</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Update Profil User</h2>
    <p class="text-muted small">Perbarui data profil atau izin akses user di sini.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 animate__animated animate__fadeInUp">
            <form method="post" action="<?= base_url('admin/users/update/'.$user['id']) ?>">
                <?= csrf_field(); ?>
                
                <h6 class="fw-bold text-emerald mb-4"><i class="bi bi-person-badge-fill me-2"></i>Data Profil</h6>
                
                <div class="row mb-4">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <label class="form-label fw-bold text-slate-900 small">Nama Lengkap</label>
                        <input type="text" name="nama" 
                               class="form-control rounded-3 py-2 <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" 
                               value="<?= old('nama', $user['nama']) ?>">
                        <div class="invalid-feedback fw-bold"><?= $errors['nama'] ?? '' ?></div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold text-slate-900 small">Nomor HP</label>
                        <input type="number" name="no_hp" 
                               class="form-control rounded-3 py-2 <?= isset($errors['no_hp']) ? 'is-invalid' : '' ?>" 
                               value="<?= old('no_hp', $user['no_hp']) ?>">
                        <div class="invalid-feedback fw-bold"><?= $errors['no_hp'] ?? '' ?></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Alamat</label>
                    <textarea name="alamat" rows="2" 
                              class="form-control rounded-3 <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>"><?= old('alamat', $user['alamat']) ?></textarea>
                    <div class="invalid-feedback fw-bold"><?= $errors['alamat'] ?? '' ?></div>
                </div>

                <hr class="my-4 opacity-10">
                <h6 class="fw-bold text-emerald mb-4"><i class="bi bi-key-fill me-2"></i>Akses Akun</h6>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold text-slate-900 small">Username</label>
                        <input type="text" name="username" 
                               class="form-control rounded-3 py-2 <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                               value="<?= old('username', $user['username']) ?>">
                        <div class="invalid-feedback fw-bold"><?= $errors['username'] ?? '' ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-slate-900 small">Role</label>
                        <select name="role" class="form-select rounded-3 py-2 <?= isset($errors['role']) ? 'is-invalid' : '' ?>">
                            <?php $currentRole = old('role', $user['role']); ?>
                            <option value="admin" <?= $currentRole == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="petugas" <?= $currentRole == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                            <option value="peminjam" <?= $currentRole == 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Ganti Password</label>
                    <input type="password" name="password" 
                           class="form-control rounded-3 py-2 <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                           placeholder="Kosongkan jika tidak ingin ganti">
                    <div class="invalid-feedback fw-bold"><?= $errors['password'] ?? '' ?></div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 mt-5">
                    <button type="submit" class="btn btn-emerald px-5 py-2 rounded-3 text-white fw-bold shadow-sm order-2 order-sm-1">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light border px-4 py-2 rounded-3 text-muted order-1 order-sm-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Utility class jika belum ada di admin_layout */
    .btn-emerald {
        background-color: #10b981;
        border: none;
    }
    .btn-emerald:hover {
        background-color: #059669;
        color: white;
    }
    .text-emerald {
        color: #10b981;
    }
</style>

<?= $this->endSection() ?>