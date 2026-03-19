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
    <h2 class="fw-bold text-slate-900">Edit Profil User</h2>
    <p class="text-muted small">Perbarui informasi akun atau ubah hak akses pengguna di bawah ini.</p>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <form method="post" action="<?= base_url('admin/users/update/'.$user['id']) ?>">
                <?= csrf_field(); ?>
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Nama Lengkap</label>
                    <input type="text" name="nama" 
                           class="form-control rounded-3 py-2 <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" 
                           value="<?= old('nama', $user['nama']) ?>">
                    <div class="invalid-feedback fw-bold"><?= $errors['nama'] ?? '' ?></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Username</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">@</span>
                        <input type="text" name="username" 
                               class="form-control border-start-0 rounded-end-3 py-2 <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                               value="<?= old('username', $user['username']) ?>">
                        <div class="invalid-feedback fw-bold"><?= $errors['username'] ?? '' ?></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3 mb-md-0">
                            <label class="form-label fw-bold text-slate-900 small">Ganti Password</label>
                            <input type="password" name="password" 
                                   class="form-control rounded-3 py-2 <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                   placeholder="••••••••">
                            <div class="invalid-feedback fw-bold"><?= $errors['password'] ?? '' ?></div>
                            <small class="text-muted mt-2 d-block" style="font-size: 0.7rem; line-height: 1.2;">
                                <i class="bi bi-info-circle me-1"></i>Kosongkan jika tidak ingin ganti password.
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-slate-900 small">Hak Akses (Role)</label>
                        <select name="role" class="form-select rounded-3 py-2 <?= isset($errors['role']) ? 'is-invalid' : '' ?>">
                            <?php $currentRole = old('role', $user['role']); ?>
                            <option value="admin" <?= $currentRole == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="petugas" <?= $currentRole == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                            <option value="peminjam" <?= $currentRole == 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
                        </select>
                        <div class="invalid-feedback fw-bold"><?= $errors['role'] ?? '' ?></div>
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                <div class="d-flex flex-column flex-sm-row gap-2 mt-2">
                    <button type="submit" class="btn btn-emerald px-4 py-2 rounded-3 text-white fw-bold shadow-sm order-2 order-sm-1">
                        <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light border px-4 py-2 rounded-3 text-muted order-1 order-sm-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="bg-light rounded-4 p-4 border border-dashed border-2">
            <h6 class="fw-bold text-slate-900 mb-3 small text-uppercase tracking-wider">Status Akun Saat Ini</h6>
            <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm mb-3">
                <div class="avatar-sm bg-emerald bg-opacity-10 text-emerald rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                    <i class="bi bi-person-badge fs-4"></i>
                </div>
                <div>
                    <div class="fw-bold text-slate-900"><?= $user['nama'] ?></div>
                    <div class="badge bg-<?= $user['role'] == 'admin' ? 'primary' : 'info' ?> bg-opacity-10 text-<?= $user['role'] == 'admin' ? 'primary' : 'dark' ?> small">
                        Role: <?= ucfirst($user['role']) ?>
                    </div>
                </div>
            </div>
            <p class="text-muted small mb-0">
                <i class="bi bi-shield-lock me-1"></i> Perubahan pada <strong>Role</strong> akan langsung mempengaruhi izin akses pengguna ini setelah mereka login kembali.
            </p>
        </div>
    </div>
</div>

<style>
    .text-emerald { color: #10b981 !important; }
    .btn-emerald { background-color: #10b981; border: none; transition: all 0.2s; }
    .btn-emerald:hover { background-color: #059669; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2) !important; }
    .is-invalid { border-color: #ef4444 !important; }
    .invalid-feedback { color: #ef4444 !important; font-size: 0.75rem; }
</style>

<?= $this->endSection() ?>