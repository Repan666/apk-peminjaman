<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Kelola Kategori</h2>
        <p class="text-muted small">Kelompokkan alat berdasarkan kategori untuk mempermudah inventaris.</p>
    </div>
    <a href="<?= base_url('admin/kategori/create') ?>" class="btn btn-emerald px-4 shadow-sm">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
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
                        <th class="ps-4 py-3" style="width: 25%;">Nama Kategori</th>
                        <th style="width: 45%;">Deskripsi</th>
                        <th style="width: 15%;">Status</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($kategori)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada data kategori.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($kategori as $k): ?>
                        <tr class="<?= !$k['status'] ? 'bg-light opacity-75' : '' ?>">
                            <td class="ps-4">
                                <div class="fw-bold text-slate-900"><?= $k['nama_kategori'] ?></div>
                            </td>
                            <td>
                                <span class="text-muted small"><?= $k['deskripsi'] ?: '-' ?></span>
                            </td>
                            <td>
                                <?php if($k['status']): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small">
                                        <i class="bi bi-check2-circle me-1"></i> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill small">
                                        <i class="bi bi-slash-circle me-1"></i> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= base_url('admin/kategori/edit/'.$k['id']) ?>" 
                                       class="btn btn-sm btn-white border shadow-sm text-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <?php if($k['status']): ?>
                                    <form action="<?= base_url('admin/kategori/nonaktif/'.$k['id']) ?>" 
                                          method="post" 
                                          onsubmit="return confirm('Menonaktifkan kategori mungkin mempengaruhi tampilan alat terkait. Lanjutkan?')">
                                        <?= csrf_field(); ?>
                                        <button class="btn btn-sm btn-white border shadow-sm text-danger" title="Nonaktifkan">
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

<?= $this->endSection() ?>