<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; padding: 20px; color: #0F172A; }
        .table thead { background-color: #10B981 !important; color: white; } /* Emerald Theme */
        .table th, .table td { vertical-align: middle; padding: 12px; }
        .header-section { border-bottom: 2px solid #0F172A; margin-bottom: 20px; padding-bottom: 10px; }
        .info-table { font-size: 0.9rem; margin-bottom: 20px; }
        .footer-ttd { margin-top: 50px; }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="header-section text-center">
            <h2 class="fw-bold text-uppercase">Laporan Peminjaman Alat</h2>
            <p class="text-muted small">Loaan.Q</p>
        </div>

        <div class="info-table">
            <table class="table table-borderless w-auto">
                <tr>
                    <td class="fw-bold">Dicetak Pada</td>
                    <td>: <?= date('d M Y H:i') ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Dicetak Oleh</td>
                    <td>: <?= $dicetak_oleh['nama'] ?> (<?= $dicetak_oleh['role'] ?>)</td>
                </tr>
            </table>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Peminjam</th>
                    <th>Alat</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($laporan as $r): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $r['nama_peminjam'] ?></td>
                    <td><?= $r['nama_alat'] ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($r['tanggal_pinjam'])) ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($r['tanggal_kembali'])) ?></td>
                    <td class="text-center fw-bold small">
                        <span class="text-uppercase"><?= $r['status'] ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row footer-ttd">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>Petugas Inventaris,</p>
                <br><br><br>
                <p class="text-decoration-underline fw-bold">
                    <?= $dicetak_oleh['nama'] ?>
                </p>
            </div>
        </div>
    </div>

</body>
</html>