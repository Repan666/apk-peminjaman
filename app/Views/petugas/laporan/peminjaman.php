<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h2 class="fw-bold text-slate-900">Laporan Peminjaman</h2>
        <p class="text-muted small">Histori pengajuan dan status peminjaman alat.</p>
    </div>
    <button onclick="window.print()" class="btn btn-emerald rounded-pill px-4 shadow-sm d-print-none">
        <i class="bi bi-printer me-2"></i>Cetak Laporan
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 printable-content">
    <div class="card-body p-0">
        <div class="table-responsive-wrapper">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="px-4 py-3 small fw-bold text-uppercase" style="width: 50px;">No</th>
                        <th class="py-3 small fw-bold text-uppercase">Peminjam</th>
                        <th class="py-3 small fw-bold text-uppercase">Nama Alat</th>
                        <th class="py-3 small fw-bold text-uppercase">Tgl Pinjam</th>
                        <th class="py-3 small fw-bold text-uppercase">Tgl Kembali</th>
                        <th class="py-3 small fw-bold text-uppercase text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Tidak ada data untuk periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($laporan as $row): ?>
                        <tr>
                            <td class="px-4 text-muted small"><?= $i++ ?></td>
                            <td>
                                <span class="fw-bold text-slate-900"><?= $row['nama_peminjam'] ?></span>
                            </td>
                            <td><?= $row['nama_alat'] ?></td>
                            <td class="small"><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])) ?></td>
                            <td class="small"><?= date('d/m/Y', strtotime($row['tanggal_kembali'])) ?></td>
                            <td class="text-center">
                                <?php 
                                    $badge = 'bg-secondary text-white';
                                    if($row['status'] == 'dipinjam') $badge = 'bg-info text-white';
                                    if($row['status'] == 'selesai') $badge = 'bg-success text-white';
                                    if($row['status'] == 'pending') $badge = 'bg-warning text-dark';
                                ?>
                                <span class="badge rounded-pill px-3 <?= $badge ?> shadow-sm" style="font-size: 0.7rem;">
                                    <?= strtoupper($row['status']) ?>
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
    /* UI Style */
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .text-emerald { color: #10b981 !important; }
    .bg-light { background-color: #f8fafc !important; }
    .text-slate-900 { color: #0f172a !important; }
    
    /* Responsive screen only */
    @media screen {
        .table-responsive-wrapper {
            overflow-x: auto;
        }
    }

    /* FIX CETAK PDF HALAMAN 2 & WARNA */
    @media print {
        @page {
            size: auto;
            margin: 15mm;
        }
        
        body {
            background-color: white !important;
        }

        .sidebar, .top-navbar, .d-print-none, .btn {
            display: none !important;
        }

        .main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
            display: block !important;
        }

        .content-padding {
            padding: 0 !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            display: block !important;
            overflow: visible !important;
        }

        /* Hilangkan pembatas scroll table agar tidak memotong halaman */
        .table-responsive-wrapper {
            overflow: visible !important;
            display: block !important;
        }

        table {
            width: 100% !important;
            border: 1px solid #e2e8f0;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        /* Memaksa warna muncul di PDF */
        .bg-success { 
            background-color: #198754 !important; 
            color: white !important; 
            print-color-adjust: exact; 
            -webkit-print-color-adjust: exact; 
        }
        .bg-info { 
            background-color: #0dcaf0 !important; 
            color: white !important; 
            print-color-adjust: exact; 
            -webkit-print-color-adjust: exact; 
        }
        .bg-secondary { 
            background-color: #6c757d !important; 
            color: white !important; 
            print-color-adjust: exact; 
            -webkit-print-color-adjust: exact; 
        }
        .badge {
            border: none !important;
        }
    }
</style>

<?= $this->endSection() ?>