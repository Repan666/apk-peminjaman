<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Laporan Pengembalian</h2>
        <p class="text-muted small mb-0">Rekapitulasi alat yang sudah kembali, durasi, dan status denda.</p>
    </div>
    <div class="d-flex gap-2 d-print-none">
        <a href="<?= base_url('petugas/laporan/pengembalian/pdf') . '?' . http_build_query(request()->getGet()) ?>" 
            class="btn btn-danger rounded-pill px-4 shadow-sm">
            <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
        </a>
        <a href="<?= base_url('petugas/laporan/pengembalian/excel') . '?' . http_build_query(request()->getGet()) ?>" 
        class="btn btn-success rounded-pill px-4 shadow-sm">
    <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
    <div class="card-body p-4">
        <form action="<?= base_url('petugas/laporan/pengembalian') ?>" method="get" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Dari Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-range text-muted"></i></span>
                    <input type="date" name="tanggal_awal" class="form-control border-0 bg-light shadow-none" value="<?= request()->getGet('tanggal_awal') ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-check text-muted"></i></span>
                    <input type="date" name="tanggal_akhir" class="form-control border-0 bg-light shadow-none" value="<?= request()->getGet('tanggal_akhir') ?>" required>
                </div>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-emerald rounded-pill px-4 flex-grow-1 fw-bold">
                    <i class="bi bi-funnel-fill me-2"></i>Filter Data
                </button>
                <?php if(request()->getGet('tanggal_awal')): ?>
                    <a href="<?= base_url('petugas/laporan/pengembalian') ?>" class="btn btn-light rounded-pill px-3 border">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php if(request()->getGet('tanggal_awal')): ?>
    <div class="mb-4 animate__animated animate__fadeIn">
        <div class="d-inline-flex align-items-center bg-white border border-emerald border-opacity-50 px-3 py-2 rounded-3 shadow-sm">
            <div class="bg-emerald bg-opacity-10 p-2 rounded-2 me-3">
                <i class="bi bi-file-earmark-check text-emerald fs-5"></i>
            </div>
            <div>
                <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">Periode Pengembalian</small>
                <span class="text-dark fw-bold">
                    <?= date('d/m/Y', strtotime(request()->getGet('tanggal_awal'))) ?> 
                    <span class="text-muted mx-1 fw-normal">s/d</span> 
                    <?= date('d/m/Y', strtotime(request()->getGet('tanggal_akhir'))) ?>
                </span>
            </div>
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
                        <th class="py-3">Alat</th>
                        <th class="py-3">Masa Pinjam</th>
                        <th class="py-3">Tgl Kembali</th>
                        <th class="py-3">Denda</th>
                        <th class="py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-3 text-muted">
                                    <i class="bi bi-folder2-open fs-1 opacity-25 d-block mb-3"></i>
                                    <p>Belum ada rekaman pengembalian pada periode ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($laporan as $row): 
                            // Handle return dari SP (Object) vs Query Builder (Array)
                            $r = (is_array($row)) ? $row : (array)$row;
                        ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $i++ ?></td>
                            <td>
                                <div class="fw-bold text-slate-900"><?= $r['nama_peminjam'] ?></div>
                            </td>
                            <td><span class="text-slate-900"><?= $r['nama_alat'] ?></span></td>
                            <td class="small">
                                <div class="text-muted"><?= date('d/m/y', strtotime($r['tanggal_pinjam'])) ?></div>
                                <div class="text-danger fw-bold"><?= date('d/m/y', strtotime($r['tanggal_kembali'])) ?></div>
                            </td>
                            <td>
                                <div class="text-emerald fw-bold small">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    <?= date('d/m/Y', strtotime($r['tanggal_dikembalikan'])) ?>
                                </div>
                            </td>
                            <td>
                                <?php if($r['denda'] > 0): ?>
                                    <span class="text-danger fw-bold">Rp<?= number_format($r['denda'], 0, ',', '.') ?></span>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 bg-success bg-opacity-10 text-success border border-success border-opacity-25" style="font-size: 0.75rem;">
                                    <?= strtoupper($r['status']) ?>
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
    :root {
        --emerald-500: #10b981;
        --emerald-600: #059669;
        --slate-900: #0f172a;
    }
    
    .btn-emerald { background-color: var(--emerald-500); color: white; border: none; transition: 0.3s; }
    .btn-emerald:hover { background-color: var(--emerald-600); color: white; transform: translateY(-1px); }
    
    .text-slate-900 { color: var(--slate-900); }
    .bg-light { background-color: #f8fafc !important; }
    
    .table thead th {
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #edf2f7;
    }

    /* Print Logic Customization */
    @media print {
        @page { size: A4 landscape; margin: 10mm; }
        .sidebar, .top-navbar, .d-print-none, .btn, .card.mb-4 { display: none !important; }
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        .table-responsive-wrapper { overflow: visible !important; }
        th, td { border: 1px solid #dee2e6 !important; padding: 10px !important; font-size: 10pt; }
        .text-emerald { color: #059669 !important; -webkit-print-color-adjust: exact; }
        .text-danger { color: #dc3545 !important; -webkit-print-color-adjust: exact; }
        .badge { color: #000 !important; border: 1px solid #000 !important; background: transparent !important; }
    }
</style>

<?= $this->endSection() ?>