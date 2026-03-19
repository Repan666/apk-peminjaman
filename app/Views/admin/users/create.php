<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<?php 
    // Mengambil semua pesan error dari session
    $errors = session()->getFlashdata('errors'); 
?>

<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>" class="text-emerald text-decoration-none fw-bold small">Kelola User</a></li>
            <li class="breadcrumb-item active small">Tambah User</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Tambah User Baru</h2>
    <p class="text-muted small">Input data pengguna baru untuk memberikan akses ke sistem APKLOAN.</p>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <form method="post" action="<?= base_url('admin/users/store') ?>">
                <?= csrf_field(); ?>
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Nama Lengkap</label>
                    <input type="text" name="nama" 
                           class="form-control rounded-3 py-2 <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" 
                           placeholder="Masukkan nama lengkap" value="<?= old('nama') ?>">
                    <div class="invalid-feedback fw-bold"><?= $errors['nama'] ?? '' ?></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Username</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">@</span>
                        <input type="text" name="username" 
                               class="form-control border-start-0 rounded-end-3 py-2 <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                               placeholder="username" value="<?= old('username') ?>">
                        <div class="invalid-feedback fw-bold"><?= $errors['username'] ?? '' ?></div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3 mb-md-0">
                            <label class="form-label fw-bold text-slate-900 small">Password</label>
                            <input type="password" name="password" 
                                   class="form-control rounded-3 py-2 <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                                   placeholder="••••••••">
                            <div class="invalid-feedback fw-bold"><?= $errors['password'] ?? '' ?></div>
                            <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">Gunakan minimal 6 karakter.</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-slate-900 small">Hak Akses (Role)</label>
                        <select name="role" class="form-select rounded-3 py-2 <?= isset($errors['role']) ? 'is-invalid' : '' ?>">
                            <option value="" disabled <?= old('role') ? '' : 'selected' ?>>Pilih Role</option>
                            <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="petugas" <?= old('role') == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                            <option value="peminjam" <?= old('role') == 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
                        </select>
                        <div class="invalid-feedback fw-bold"><?= $errors['role'] ?? '' ?></div>
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                    <button type="submit" class="btn btn-emerald px-4 py-2 rounded-3 text-white fw-bold shadow-sm order-2 order-sm-1">
                        <i class="bi bi-person-plus-fill me-2"></i>Simpan User Baru
                    </button>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light border px-4 py-2 rounded-3 text-muted order-1 order-sm-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5 mt-4 mt-lg-0 d-none d-lg-block">
        <div class="bg-emerald bg-opacity-10 border border-emerald border-opacity-25 rounded-4 p-4">
            <h6 class="fw-bold text-emerald mb-3">
                <i class="bi bi-shield-check me-2"></i>Informasi Keamanan
            </h6>
            <div class="d-flex mb-3">
                <div class="text-emerald me-3"><i class="bi bi-1-circle-fill"></i></div>
                <div class="small text-muted"><strong>Username</strong> harus unik. Jika error muncul, berarti username sudah dipakai staf lain.</div>
            </div>
            <div class="d-flex mb-3">
                <div class="text-emerald me-3"><i class="bi bi-2-circle-fill"></i></div>
                <div class="small text-muted"><strong>Password</strong> disarankan kombinasi huruf dan angka minimal 6 karakter.</div>
            </div>
            <div class="d-flex">
                <div class="text-emerald me-3"><i class="bi bi-3-circle-fill"></i></div>
                <div class="small text-muted">Pastikan memilih <strong>Role</strong> yang sesuai dengan tugas kerja pengguna tersebut.</div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-emerald { color: #10b981 !important; }
    .btn-emerald { background-color: #10b981; border: none; transition: all 0.2s ease-in-out; }
    .btn-emerald:hover { background-color: #059669; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important; }
    
    .is-invalid { 
        border-color: #ef4444 !important;
        background-image: none !important; 
    }
    .invalid-feedback { 
        color: #ef4444 !important; 
        font-size: 0.75rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1);
    }
</style>

<?= $this->endSection() ?>