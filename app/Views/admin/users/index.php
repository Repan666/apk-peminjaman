<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<?php $currentId = session()->get('user_id'); ?>

<div class="row align-items-center mb-4 g-3">
    <div class="col-12 col-md-6">
        <h2 class="fw-bold text-slate-900 mb-1">Kelola User</h2>
        <p class="text-muted small mb-0">Manajemen hak akses dan data pengguna sistem APKLOAN.</p>
    </div>
    <div class="col-12 col-md-6">
        <div class="d-flex gap-2 justify-content-md-end">
            <form action="" method="get" class="flex-grow-1 flex-md-grow-0">
                <div class="input-group search-group shadow-sm rounded-pill overflow-hidden">
                    <span class="input-group-text bg-white border-0 ps-3">
                        <i class="bi bi-search text-muted small"></i>
                    </span>
                    <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" 
                           class="form-control border-0 ps-2 shadow-none" 
                           placeholder="Cari nama atau username..." 
                           style="width: 200px; font-size: 0.9rem;">
                    <?php if(!empty($keyword)): ?>
                        <a href="<?= base_url('admin/users') ?>" class="input-group-text bg-white border-0 pe-3 text-danger">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
            
            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-emerald rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah
            </a>
        </div>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center animate__animated animate__fadeInDown" role="alert">
        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
            <i class="bi bi-check-lg text-success"></i>
        </div>
        <div class="fw-medium text-success"><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold text-uppercase tracking-wider">Informasi User</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase tracking-wider">Role</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase tracking-wider">Status</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase tracking-wider text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($users)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-people fs-1 text-muted opacity-25 d-block mb-3"></i>
                                <h5 class="text-slate-900 fw-bold">Data tidak ditemukan</h5>
                                <p class="text-muted small">Coba gunakan kata kunci pencarian yang lain.</p>
                                <a href="<?= base_url('admin/users') ?>" class="btn btn-link text-emerald text-decoration-none fw-bold">Reset Pencarian</a>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3 bg-emerald bg-opacity-10 text-emerald fw-bold d-flex align-items-center justify-content-center">
                                        <?= strtoupper(substr($u['nama'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-900"><?= $u['nama'] ?></div>
                                        <div class="text-muted small">@<?= $u['username'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    $roleColor = 'secondary';
                                    if($u['role'] == 'admin') $roleColor = 'primary';
                                    if($u['role'] == 'petugas') $roleColor = 'info text-dark';
                                ?>
                                <span class="badge bg-<?= $roleColor ?> bg-opacity-10 text-capitalize px-3 py-2 rounded-pill border border-<?= explode(' ', $roleColor)[0] ?> border-opacity-25" style="font-size: 0.75rem; color: inherit !important;">
                                    <?= $u['role'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if($u['status']): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small border border-success border-opacity-25">
                                        <i class="bi bi-check-circle-fill me-1" style="font-size: 10px;"></i> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill small border border-danger border-opacity-25">
                                        <i class="bi bi-dash-circle-fill me-1" style="font-size: 10px;"></i> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-3">
                                <div class="d-flex justify-content-center gap-2">
                                    <?php if($u['role'] != 'admin' || $u['id'] == $currentId): ?>
                                        <a href="<?= base_url('admin/users/edit/'.$u['id']) ?>" 
                                           class="btn btn-icon btn-light-warning" title="Edit User">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if($u['role'] != 'admin' && $u['status']): ?>
                                        <form action="<?= base_url('admin/users/nonaktif/'.$u['id']) ?>" 
                                              method="post" 
                                              onsubmit="return confirm('Yakin ingin menonaktifkan user ini?')">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-icon btn-light-danger" title="Nonaktifkan">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* UI Toolkit Enhancements */
    .btn-emerald { background-color: #10b981; color: white; border: none; transition: 0.3s; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-2px); }
    
    .search-group .form-control:focus {
        background-color: white !important;
    }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 1.1rem;
    }

    .tracking-wider { letter-spacing: 0.05em; }
    
    /* Button Custom Styles */
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.2s;
        border: none;
    }

    .btn-light-warning { background-color: #fffbeb; color: #d97706; }
    .btn-light-warning:hover { background-color: #fef3c7; color: #92400e; }
    
    .btn-light-danger { background-color: #fef2f2; color: #dc2626; }
    .btn-light-danger:hover { background-color: #fee2e2; color: #991b1b; }

    .table thead th {
        font-size: 0.65rem;
        background-color: #f8fafc;
    }

    /* Animation */
    .animate__animated { animation-duration: 0.5s; }
</style>

<?= $this->endSection() ?>