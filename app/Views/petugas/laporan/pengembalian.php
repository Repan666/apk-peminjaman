<?= $this->extend('layouts/petugas_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex align-items-center justify-content-between">
    <div>
        <h2 class="fw-bold text-slate-900">Laporan Pengembalian</h2>
        <p class="text-muted small">Rekapitulasi alat yang sudah dikembalikan & status denda.</p>
    </div>
    <button onclick="window.print()" class="btn btn-emerald rounded-pill px-4 shadow-sm d-print-none">
        <i class="bi bi-printer me-2"></i>Cetak Laporan
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-print-wrapper">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-muted small fw-bold text-uppercase" style="width: 50px;">No</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Peminjam</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Nama Alat</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Pinjam/Harus Kembali</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Dikembalikan</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Denda</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($laporan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Tidak ada data pengembalian ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach($laporan as $row): ?>
                        <tr>
                            <td class="px-4 text-muted small"><?= $i++ ?></td>
                            <td><span class="fw-bold text-slate-900"><?= $row['nama_peminjam'] ?></span></td>
                            <td><?= $row['nama_alat'] ?></td>
                            <td class="small">
                                <?= date('d/m/y', strtotime($row['tanggal_pinjam'])) ?> - 
                                <span class="text-danger fw-bold"><?= date('d/m/y', strtotime($row['tanggal_kembali'])) ?></span>
                            </td>
                            <td class="fw-bold text-emerald small"><?= date('d/m/Y', strtotime($row['tanggal_dikembalikan'])) ?></td>
                            <td class="fw-bold <?= $row['denda'] > 0 ? 'text-danger' : 'text-muted' ?>">
                                Rp<?= number_format($row['denda'], 0, ',', '.') ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success text-white rounded-pill px-3 shadow-sm" style="font-size: 0.7rem;">
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
    /* CSS UI Dasar */
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .text-emerald { color: #10b981 !important; }
    .bg-light { background-color: #f8fafc !important; }
    .text-slate-900 { color: #0f172a !important; }

    /* Mode Screen (Desktop/Mobile) */
    @media screen {
        .table-print-wrapper {
            overflow-x: auto;
        }
    }

    /* FIX TOTAL UNTUK CETAK PDF */
    @media print {
        @page {
            size: auto;
            margin: 10mm;
        }

        .sidebar, .top-navbar, .d-print-none, .btn {
            display: none !important;
        }

        .main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
            display: block !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            display: block !important;
            overflow: visible !important;
        }

        .table-print-wrapper {
            overflow: visible !important;
            display: block !important;
        }

        table {
            width: 100% !important;
            border: 1px solid #e9ecef;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        /* Paksa Warna Keluar di PDF */
        .bg-success {
            background-color: #198754 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .text-danger {
            color: #dc3545 !important;
            -webkit-print-color-adjust: exact;
        }

        .text-emerald {
            color: #10b981 !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<?= $this->endSection() ?>