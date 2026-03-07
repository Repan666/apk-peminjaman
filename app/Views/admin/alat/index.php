<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Inventaris Alat</h2>
        <p class="text-muted small">Monitor ketersediaan, kondisi, dan status alat peminjaman.</p>
    </div>
    <a href="<?= base_url('admin/alat/create') ?>" class="btn btn-emerald px-4 shadow-sm">
        <i class="bi bi-plus-lg me-2"></i>Tambah Alat
    </a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
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
                        <th class="ps-4 py-3">Info Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($alat as $a): ?>
                    <tr class="<?= !$a['status'] ? 'bg-light opacity-75' : '' ?>">
                        <td class="ps-4">
                            <div class="fw-bold text-slate-900"><?= $a['nama_alat'] ?></div>
                            <div class="text-muted small font-monospace"><?= $a['kode_alat'] ?></div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-medium"><?= $a['nama_kategori'] ?></span>
                        </td>
                        <td>
                            <?php 
                                $stokColor = 'text-success';
                                if($a['stok'] == 0) $stokColor = 'text-danger fw-bold';
                                elseif($a['stok'] <= 5) $stokColor = 'text-warning fw-bold';
                            ?>
                            <div class="<?= $stokColor ?>">
                                <i class="bi bi-box-fill me-1 small"></i><?= $a['stok'] ?> Unit
                            </div>
                        </td>
                        <td>
                            <?php 
                                $kondisiBadge = 'bg-success';
                                if($a['kondisi'] == 'rusak ringan') $kondisiBadge = 'bg-warning text-dark';
                                if($a['kondisi'] == 'rusak berat') $kondisiBadge = 'bg-danger';
                            ?>
                            <span class="badge <?= $kondisiBadge ?> bg-opacity-10 text-capitalize px-3 py-2 rounded-pill shadow-none" style="color: inherit;">
                                <?= $a['kondisi'] ?>
                            </span>
                        </td>
                        <td>
                            <?= $a['status'] ? 
                                '<span class="text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i>Aktif</span>' : 
                                '<span class="text-secondary small fw-bold"><i class="bi bi-slash-circle me-1"></i>Nonaktif</span>' 
                            ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="<?= base_url('admin/alat/edit/'.$a['id']) ?>" 
                                   class="btn btn-sm btn-white border shadow-sm text-warning" title="Edit Alat">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <?php if($a['status']): ?>
                                <form action="<?= base_url('admin/alat/nonaktif/'.$a['id']) ?>" 
                                      method="post" 
                                      onsubmit="return confirm('Nonaktifkan alat ini?')">
                                    <?= csrf_field(); ?>
                                    <button class="btn btn-sm btn-white border shadow-sm text-danger" title="Nonaktifkan">
                                        <i class="bi bi-trash3"></i> </button>
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