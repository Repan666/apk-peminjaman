<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --slate-900: #0F172A;
            --emerald-500: #10B981;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            padding: 30px; 
            color: #334155; 
            background-color: white;
        }
        
        .header-section { 
            border-bottom: 2px solid var(--slate-900); 
            margin-bottom: 25px; 
            padding-bottom: 15px; 
        }
        
        .table thead { 
            background-color: var(--emerald-500) !important; 
            color: white !important; 
        }
        
        .table th { 
            text-align: center; 
            text-transform: uppercase; 
            font-size: 0.8rem; 
            padding: 12px;
        }
        
        .table td { 
            padding: 10px; 
            vertical-align: middle; 
            font-size: 0.85rem;
        }

        .info-table { 
            font-size: 0.9rem; 
            margin-bottom: 20px; 
            color: #475569;
        }

        .footer-ttd { margin-top: 60px; }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="header-section text-center">
            <h2 class="fw-bold text-uppercase" style="color: var(--slate-900);">Laporan Pengembalian Alat</h2>
            <p class="text-muted small">Loaan.Q - Laporan Histori Pengembalian</p>
        </div>

        <div class="info-table">
            <table class="table table-borderless w-auto">
                <tr>
                    <td class="fw-bold pe-3">Dicetak Pada</td>
                    <td>: <?= date('d M Y, H:i') ?></td>
                </tr>
                <tr>
                    <td class="fw-bold pe-3">Dicetak Oleh</td>
                    <td>: <?= $dicetak_oleh ?></td>
                </tr>
            </table>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Tgl Dikembalikan</th>
                    <th>Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($laporan)): ?>
                    <tr><td colspan="8" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach($laporan as $r): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $r['nama_peminjam'] ?></td>
                        <td><?= $r['nama_alat'] ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($r['tanggal_pinjam'])) ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($r['tanggal_kembali'])) ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($r['tanggal_dikembalikan'])) ?></td>
                        <td class="text-end">Rp <?= number_format($r['denda'] ?? 0, 0, ',', '.') ?></td>
                        <td class="text-center fw-bold"><?= strtoupper($r['status']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="row footer-ttd">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>Petugas Inventaris,</p>
                <br><br><br>
                <p class="text-decoration-underline fw-bold"><?= $dicetak_oleh ?></p>
            </div>
        </div>
    </div>

</body>
</html>