<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Kelola User</h2>
        <p class="text-muted small">Manajemen hak akses dan data pengguna sistem.</p>
    </div>
    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-emerald px-4 shadow-sm">
        <i class="bi bi-person-plus-fill me-2"></i>Tambah User
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div><?= session()->getFlashdata('success') ?></div>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-slate-900"><?= $u['nama'] ?></div>
                        </td>
                        <td><span class="text-muted">@</span><?= $u['username'] ?></td>
                        <td>
                            <?php 
                                $badgeClass = 'bg-secondary';
                                if($u['role'] == 'admin') $badgeClass = 'bg-primary';
                                if($u['role'] == 'petugas') $badgeClass = 'bg-info text-dark';
                            ?>
                            <span class="badge <?= $badgeClass ?> bg-opacity-10 text-capitalize px-3 py-2 rounded-pill" style="color: inherit;">
                                <?= $u['role'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if($u['status']): ?>
                                <span class="text-success small fw-bold"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Aktif</span>
                            <?php else: ?>
                                <span class="text-danger small fw-bold"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="<?= base_url('admin/users/edit/'.$u['id']) ?>" class="btn btn-sm btn-light border text-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <?php if($u['status']): ?>
                                <form action="<?= base_url('admin/users/nonaktif/'.$u['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menonaktifkan user ini?')">
                                    <?= csrf_field(); ?>
                                    <button class="btn btn-sm btn-light border text-danger">
                                        <i class="bi bi-person-x-fill"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>