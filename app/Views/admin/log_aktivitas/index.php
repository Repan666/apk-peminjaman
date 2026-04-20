<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h2 class="fw-bold text-slate-900">System Activity Feed</h2>
        <p class="text-muted small">Timeline aktivitas pengguna dan perubahan sistem secara real-time.</p>
    </div>
    <div class="d-flex gap-2 d-print-none">
    </div>
</div>

<div class="timeline-container position-relative ps-4">
    <div class="timeline-line position-absolute start-0 top-0 bottom-0 bg-light border-start border-2 ms-3 d-print-none"></div>

    <?php if(empty($logs)): ?>
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-clipboard-x text-light" style="font-size: 5rem;"></i>
            </div>
            <h5 class="text-slate-900 fw-bold">Belum Ada Aktivitas</h5>
            <p class="text-muted small">Semua jejak audit akan muncul di sini secara kronologis.</p>
        </div>
    <?php else: ?>
        <?php foreach($logs as $row): 
            $act = strtolower($row['aktivitas']);
            $icon = 'bi-info-circle';
            $color = '#64748b'; // Default Slate
            $bgLight = '#f1f5f9';

            if(strpos($act, 'login') !== false) {
                $icon = 'bi-box-arrow-in-right';
                $color = '#3b82f6'; // Blue
                $bgLight = '#eff6ff';
            } elseif(strpos($act, 'tambah') !== false || strpos($act, 'simpan') !== false) {
                $icon = 'bi-plus-circle-fill';
                $color = '#10b981'; // Emerald
                $bgLight = '#ecfdf5';
            } elseif(strpos($act, 'ubah') !== false || strpos($act, 'update') !== false) {
                $icon = 'bi-pencil-square';
                $color = '#f59e0b'; // Amber
                $bgLight = '#fffbeb';
            } elseif(strpos($act, 'hapus') !== false || strpos($act, 'delete') !== false) {
                $icon = 'bi-trash3-fill';
                $color = '#ef4444'; // Red
                $bgLight = '#fef2f2';
            }
        ?>
        <div class="timeline-item position-relative mb-4">
            <div class="timeline-dot position-absolute start-0 translate-middle-x bg-white border border-4 rounded-circle d-print-none" 
                 style="width: 18px; height: 18px; margin-left: -8px; z-index: 2; border-color: <?= $color ?> !important;">
            </div>

            <div class="card border-0 shadow-sm rounded-4 ms-3 transition-hover">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="d-flex">
                            <div class="action-icon rounded-3 d-flex align-items-center justify-content-center me-3" 
                                 style="width: 45px; height: 45px; background-color: <?= $bgLight ?>; color: <?= $color ?>;">
                                <i class="bi <?= $icon ?> fs-4"></i>
                            </div>
                            
                            <div>
                                <h6 class="mb-1 fw-bold text-slate-900">
                                    <?= strtoupper($row['aktivitas']) ?>
                                </h6>
                                <p class="mb-2 text-slate-600 small">
                                    <span class="fw-bold text-emerald text-capitalize"><?= $row['nama'] ?></span> 
                                    (<?= $row['role'] ?>) – <?= $row['keterangan'] ?>
                                </p>
                                <div class="d-flex gap-3 text-muted" style="font-size: 0.7rem;">
                                    <span><i class="bi bi-clock me-1"></i><?= date('H:i:s', strtotime($row['created_at'])) ?></span>
                                    <span><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($row['created_at'])) ?></span>
                                    <span class="font-monospace d-print-none text-opacity-50"><i class="bi bi-hdd-network me-1"></i><?= $row['ip_address'] ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <span class="badge bg-light text-muted fw-normal rounded-pill d-none d-md-block" style="font-size: 0.65rem;">
                            <?= date('d/m/y', strtotime($row['created_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    .text-emerald { color: #10b981 !important; }
    .bg-light { background-color: #f8fafc !important; }
    .text-slate-900 { color: #0f172a !important; }
    .text-slate-600 { color: #475569 !important; }

    /* Hover effect agar card terasa interaktif */
    .transition-hover:hover {
        transform: translateX(5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<?= $this->endSection() ?>