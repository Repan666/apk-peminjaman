<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors'); ?>

<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>" class="text-emerald text-decoration-none fw-bold small">Kelola User</a></li>
            <li class="breadcrumb-item active small">Tambah User</li>
        </ol>
    </nav>
    <h2 class="fw-bold text-slate-900">Tambah User Baru</h2>
    <p class="text-muted small">Lengkapi data profil dan akun untuk memberikan akses APKLOAN.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <form method="post" action="<?= base_url('admin/users/store') ?>">
                <?= csrf_field(); ?>
                
                <h6 class="fw-bold text-emerald mb-4"><i class="bi bi-person-lines-fill me-2"></i>Informasi Profil</h6>
                
                <div class="row mb-4">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <label class="form-label fw-bold text-slate-900 small">Nama Lengkap</label>
                        <input type="text" name="nama" 
                               class="form-control rounded-3 py-2 <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" 
                               placeholder="Nama Lengkap" value="<?= old('nama') ?>">
                        <div class="invalid-feedback fw-bold"><?= $errors['nama'] ?? '' ?></div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold text-slate-900 small">Nomor WhatsApp/HP</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted small">+62</span>
                            <input type="number" name="no_hp" 
                                   class="form-control border-start-0 rounded-end-3 py-2 <?= isset($errors['no_hp']) ? 'is-invalid' : '' ?>" 
                                   placeholder="812xxxx" value="<?= old('no_hp') ?>">
                            <div class="invalid-feedback fw-bold"><?= $errors['no_hp'] ?? '' ?></div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" 
                              class="form-control rounded-3 <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" 
                              placeholder="Masukkan alamat tinggal saat ini..."><?= old('alamat') ?></textarea>
                    <div class="invalid-feedback fw-bold"><?= $errors['alamat'] ?? '' ?></div>
                </div>

                <hr class="my-4 opacity-10">
                <h6 class="fw-bold text-emerald mb-4"><i class="bi bi-shield-lock-fill me-2"></i>Keamanan Akun</h6>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold text-slate-900 small">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted small">@</span>
                            <input type="text" name="username" 
                                   class="form-control border-start-0 rounded-end-3 py-2 <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                                   placeholder="username" value="<?= old('username') ?>">
                            <div class="invalid-feedback fw-bold"><?= $errors['username'] ?? '' ?></div>
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

                <div class="mb-4">
                    <label class="form-label fw-bold text-slate-900 small">Password</label>
                    <input type="password" name="password" 
                           class="form-control rounded-3 py-2 <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                           placeholder="••••••••">
                    <div class="invalid-feedback fw-bold"><?= $errors['password'] ?? '' ?></div>
                    <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">Minimal 6 karakter kombinasi huruf/angka.</small>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 mt-5">
                    <button type="submit" class="btn btn-emerald px-5 py-2 rounded-3 text-white fw-bold shadow-sm order-2 order-sm-1">
                        <i class="bi bi-person-plus-fill me-2"></i>Daftarkan User
                    </button>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-light border px-4 py-2 rounded-3 text-muted order-1 order-sm-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="alert alert-info border-0 rounded-4 p-4 shadow-sm">
            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle-fill me-2"></i>Penting!</h6>
            <p class="small text-dark mb-0 opacity-75">
                Pastikan <strong>Nomor HP</strong> aktif untuk mempermudah pengiriman notifikasi keterlambatan atau konfirmasi peminjaman alat.
            </p>
        </div>
    </div>
</div>

<style>
    .text-emerald { color: #10b981 !important; }
    .btn-emerald { background-color: #10b981; border: none; transition: 0.3s; }
    .btn-emerald:hover { background-color: #059669; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2) !important; }
    .form-control:focus, .form-select:focus { border-color: #10b981; box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1); }
</style>

<?= $this->endSection() ?>