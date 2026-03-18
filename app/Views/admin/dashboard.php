<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-slate-900">Dashboard Overview</h2>
        <p class="text-muted small">Selamat datang kembali, Admin. Berikut ringkasan sistem hari ini.</p>
    </div>
    <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-pill">
        <i class="bi bi-calendar3 me-2 text-emerald"></i> <?= date('d M Y') ?>
    </span>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-4 transition-hover">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold">TOTAL USER</p>
                    <h3 class="fw-bold mb-0"><?= number_format($total_user) ?></h3>
                </div>
            </div>
        </div>
    </div>

   <div class="col-md-3">
    <div class="card border-0 shadow-sm p-3 rounded-4 transition-hover">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0 p-3 rounded-3" style="background-color: #ecfdf5;">
                <i class="bi bi-box-seam fs-3" style="color: #10b981; line-height: 1;"></i> 
            </div>
            <div class="flex-grow-1 ms-3">
                <p class="text-muted mb-0 small fw-bold text-uppercase">Total Alat</p>
                <h3 class="fw-bold mb-0 text-slate-900"><?= number_format($total_alat) ?></h3>
            </div>
        </div>
    </div>
</div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-4 transition-hover">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold">PENDING</p>
                    <h3 class="fw-bold mb-0"><?= number_format($total_pending) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-4 transition-hover">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-danger bg-opacity-10 p-3 rounded-3 text-danger">
                    <i class="bi bi-arrow-repeat fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold">AKTIF PINJAM</p>
                    <h3 class="fw-bold mb-0"><?= number_format($total_aktif) ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Peminjaman Terbaru</h5>
                <a href="/admin/peminjaman" class="btn btn-sm btn-light rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4 py-3">PEMINJAM</th>
                                <th>ALAT</th>
                                <th>TGL PINJAM</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($peminjaman_baru)): ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted small">Belum ada data peminjaman.</td></tr>
                            <?php else: ?>
                                <?php foreach($peminjaman_baru as $pj): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-slate-900"><?= $pj['nama_peminjam'] ?></div>
                                        
                                    </td>
                                    <td><span class="small"><?= $pj['nama_alat'] ?></span></td>
                                    <td><span class="small"><?= date('d M Y', strtotime($pj['tanggal_pinjam'])) ?></span></td>
                                    <td>
                                        <?php 
                                            $badge = ($pj['status'] == 'pending') ? 'bg-warning text-dark' : 'bg-info text-white';
                                            if($pj['status'] == 'selesai') $badge = 'bg-success text-white';
                                        ?>
                                        <span class="badge rounded-pill <?= $badge ?>" style="font-size: 0.65rem;"><?= strtoupper($pj['status']) ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Aktivitas Terkini</h5>
            </div>
            <div class="card-body pt-0">
                <div class="timeline-simple">
                    <?php if(empty($recent_logs)): ?>
                        <p class="text-muted small text-center py-4">Tidak ada aktivitas.</p>
                    <?php else: ?>
                        <?php foreach($recent_logs as $log): ?>
                        <div class="mb-3 pb-3 border-bottom border-light last-child-border-0">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold small text-emerald"><?= strtoupper($log['aktivitas']) ?></span>
                                <span class="text-muted" style="font-size: 0.65rem;"><?= date('H:i', strtotime($log['created_at'])) ?></span>
                            </div>
                            <p class="mb-0 text-slate-700 small" style="font-size: 0.75rem;">
                                <strong><?= $log['nama'] ?></strong>: <?= $log['keterangan'] ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <a href="/admin/log_aktivitas" class="btn btn-emerald w-100 rounded-3 mt-2 small shadow-sm">Buka Log Audit</a>
            </div>
        </div>
    </div>
</div>

<style>
    .text-emerald { color: #10b981 !important; }
    .bg-emerald { background-color: #10b981 !important; }
    .btn-emerald { background-color: #10b981; color: white; border: none; font-size: 0.85rem; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    .last-child-border-0:last-child { border-bottom: none !important; }
    
    .transition-hover:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
</style>

<?= $this->endSection() ?>