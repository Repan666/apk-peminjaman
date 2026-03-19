<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Laporan Peminjaman</h2>
        <p class="text-muted small mb-0">Filter dan cetak histori peminjaman alat praktikum.</p>
    </div>
    <div class="d-flex gap-2 d-print-none">
        <button onclick="window.print()" class="btn btn-emerald rounded-pill px-4 shadow-sm">
            <i class="bi bi-printer me-2"></i>Cetak Laporan
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
    <div class="card-body p-4">
        <form action="<?= base_url('petugas/laporan/peminjaman') ?>" method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Tanggal Awal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-event text-muted"></i></span>
                    <input type="date" name="tanggal_awal" class="form-control border-0 bg-light" value="<?= request()->getGet('tanggal_awal') ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Tanggal Akhir</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-check text-muted"></i></span>
                    <input type="date" name="tanggal_akhir" class="form-control border-0 bg-light" value="<?= request()->getGet('tanggal_akhir') ?>" required>
                </div>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-emerald rounded-pill px-4 flex-grow-1 fw-bold">
                    <i class="bi bi-filter me-2"></i>Filter
                </button>
                <?php if(request()->getGet('tanggal_awal')): ?>
                    <a href="<?= base_url('petugas/laporan/peminjaman') ?>" class="btn btn-light rounded-pill px-3 border">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php if(request()->getGet('tanggal_awal')): ?>
    <div class="mb-4 animate__animated animate__fadeIn">
        <div class="d-inline-flex align-items-center bg-emerald bg-opacity-10 border border-emerald border-opacity-25 px-3 py-2 rounded-3">
            <i class="bi bi-calendar-range-fill text-emerald me-2"></i>
            <span class="text-dark small">
                Periode Laporan: 
                <strong class="text-slate-900 mx-1"><?= date('d M Y', strtotime(request()->getGet('tanggal_awal'))) ?></strong> 
                 s/d 
                <strong class="text-slate-900 mx-1"><?= date('d M Y', strtotime(request()->getGet('tanggal_akhir'))) ?></strong>
            </span>
        </div>
    </div>
<?php endif; ?>
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive-wrapper">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4 py-3" style="width: 60px;">No</th>
                        <th class="py-3">Peminjam</th>
                        <th class="py-3">Alat Praktikum</th>
                        <th class="py-3">Waktu Pinjam</th>
                        <th class="py-3">Waktu Kembali</th>
                        <th class="py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-3">
                                    <i class="bi bi-clipboard-x fs-1 opacity-25 d-block mb-3"></i>
                                    <p class="text-muted">Tidak ada data ditemukan untuk periode ini.</p>
                                    <a href="<?= base_url('petugas/laporan/peminjaman') ?>" class="btn btn-link text-emerald text-decoration-none small">Lihat Semua Data</a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($laporan as $row): 
                            // Konversi object ke array jika data dari Stored Procedure berbentuk object
                            $r = (is_array($row)) ? $row : (array)$row; 
                        ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $i++ ?></td>
                            <td>
                                <div class="fw-bold text-slate-900"><?= $r['nama_peminjam'] ?></div>
                              
                            </td>
                            <td>
                                <div class="text-slate-900"><?= $r['nama_alat'] ?></div>
                            </td>
                            <td>
                                <div class="small text-dark"><i class="bi bi-calendar-event me-1 text-muted"></i><?= date('d/m/Y', strtotime($r['tanggal_pinjam'])) ?></div>
                            </td>
                            <td>
                                <div class="small text-dark"><i class="bi bi-calendar-check me-1 text-muted"></i><?= date('d/m/Y', strtotime($r['tanggal_kembali'])) ?></div>
                            </td>
                            <td class="text-center">
                                <?php 
                                    $status = strtolower($r['status']);
                                    $badgeClass = 'bg-secondary';
                                    if($status == 'dipinjam') $badgeClass = 'bg-info';
                                    if($status == 'selesai') $badgeClass = 'bg-success';
                                    if($status == 'pending') $badgeClass = 'bg-warning text-dark';
                                ?>
                                <span class="badge rounded-pill px-3 <?= $badgeClass ?> bg-opacity-10 <?= $status == 'pending' ? '' : 'text-'.str_replace('bg-', '', $badgeClass) ?> border border-<?= str_replace('bg-', '', $badgeClass) ?> border-opacity-25" style="font-size: 0.75rem;">
                                    <?= strtoupper($status) ?>
                                </span>
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
    /* UI Style Consistency */
    :root {
        --emerald-500: #10b981;
        --emerald-600: #059669;
        --slate-900: #0f172a;
    }
    
    .btn-emerald { background-color: var(--emerald-500); color: white; border: none; transition: all 0.3s; }
    .btn-emerald:hover { background-color: var(--emerald-600); color: white; transform: translateY(-1px); }
    
    .text-slate-900 { color: var(--slate-900); }
    .bg-light { background-color: #f8fafc !important; }
    
    .form-control:focus {
        box-shadow: none;
        border: 1px solid var(--emerald-500) !important;
    }

    .table thead th {
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #edf2f7;
    }

    /* Print Logic */
    @media print {
        @page { size: A4 landscape; margin: 10mm; }
        .sidebar, .top-navbar, .d-print-none, .btn, .card.mb-4 { display: none !important; }
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; }
        .content-padding { padding: 0 !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        .table-responsive-wrapper { overflow: visible !important; }
        table { width: 100% !important; border-collapse: collapse; }
        th, td { border: 1px solid #e2e8f0 !important; padding: 8px !important; }
        .badge { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; }
    }
</style>

<?= $this->endSection() ?>