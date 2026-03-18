<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/peminjaman" class="text-decoration-none small fw-bold text-emerald">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <div class="d-flex justify-content-between align-items-center mt-2">
        <h2 class="fw-bold text-slate-900">Detail Pengajuan</h2>
        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 small">
            ID Transaksi: <span class="font-monospace text-emerald"><?= str_pad($peminjaman['id'], 5, '0', STR_PAD_LEFT) ?></span>
        </span>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="fw-bold mb-0 text-slate-900">Informasi Peminjaman</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase w-25" style="letter-spacing: 0.5px;">Data Peminjam</th>
                                <td class="ps-4 py-3 fw-bold text-slate-900">
                                    <i class="bi bi-person-circle me-2 text-emerald"></i><?= $peminjaman['nama'] ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase" style="letter-spacing: 0.5px;">Alat</th>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold"><?= $peminjaman['nama_alat'] ?></div>
                                    <small class="text-muted font-monospace">Unit ID: AL-<?= $peminjaman['alat_id'] ?></small>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase" style="letter-spacing: 0.5px;">Rentang Waktu</th>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <small class="text-muted d-block">Mulai</small>
                                            <span class="fw-medium text-dark"><?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])) ?></span>
                                        </div>
                                        <i class="bi bi-arrow-right text-muted"></i>
                                        <div>
                                            <small class="text-muted d-block">Kembali</small>
                                            <span class="fw-medium text-dark"><?= date('d M Y', strtotime($peminjaman['tanggal_kembali'])) ?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase" style="letter-spacing: 0.5px;">Keperluan</th>
                                <td class="ps-4 py-3 text-dark italic">
                                    "<?= $peminjaman['keterangan'] ?: '-' ?>"
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light border-0 p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="small text-muted">
                        <i class="bi bi-clock-history me-1"></i> Diajukan pada: <?= date('d/m/Y H:i', strtotime($peminjaman['created_at'] ?? 'now')) ?>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <?php if($peminjaman['status'] == 'pending'): ?>
                            <a href="/admin/peminjaman/reject/<?= $peminjaman['id'] ?>" class="btn btn-outline-danger px-4 rounded-pill fw-bold btn-sm">Tolak Pengajuan</a>
                            <a href="/admin/peminjaman/approve/<?= $peminjaman['id'] ?>" class="btn btn-emerald px-4 rounded-pill fw-bold btn-sm shadow-sm">Setujui & Serahkan Alat</a>
                        <?php elseif($peminjaman['status'] == 'dipinjam'): ?>
                            <button class="btn btn-primary px-4 rounded-pill fw-bold btn-sm">Proses Pengembalian</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <?php 
                $status = strtolower($peminjaman['status']);
                $bgClass = 'bg-secondary'; // default
                $textClass = 'text-white';

                if ($status == 'pending') {
                    $bgClass = 'bg-warning';
                    $textClass = 'text-dark';
                } elseif ($status == 'dipinjam') {
                    $bgClass = 'bg-success';
                } elseif ($status == 'ditolak') {
                    $bgClass = 'bg-danger';
                } elseif ($status == 'selesai') {
                    $bgClass = 'bg-primary';
                } elseif ($status == 'dibatalkan') {
                    $bgClass = 'bg-dark';
                }
            ?>
            
            <div class="p-4 text-center <?= $bgClass ?> <?= $textClass ?>">
                <small class="text-uppercase fw-bold opacity-75" style="letter-spacing: 1px;">Status Saat Ini</small>
                <h3 class="fw-bold mb-0 mt-1"><?= strtoupper($peminjaman['status']) ?></h3>
            </div>
            
            <div class="card-body p-4">
                <h6 class="fw-bold text-slate-900 mb-3">Tindakan Admin</h6>
                <div class="d-grid gap-2">
                    <a href="/admin/peminjaman/edit/<?= $peminjaman['id'] ?>" class="btn btn-light border rounded-pill text-dark fw-bold btn-sm">
                        <i class="bi bi-pencil-square me-2 text-muted"></i>Ubah Data
                    </a>
                    <button onclick="window.print()" class="btn btn-light border rounded-pill text-dark fw-bold btn-sm">
                        <i class="bi bi-printer me-2 text-muted"></i>Cetak Bukti (PDF)
                    </button>
                </div>
            </div>
        </div>

        <div class="alert alert-secondary border-0 rounded-4 p-4 shadow-sm">
            <h6 class="fw-bold small text-uppercase mb-3"><i class="bi bi-info-circle me-2"></i>Catatan Sistem</h6>
            <p class="small text-muted mb-0">Pastikan kondisi alat diperiksa saat serah terima. Hubungi peminjam jika melewati batas pengembalian.</p>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    .text-emerald { color: #10b981 !important; }
    .bg-light { background-color: #f8fafc !important; }
    .uppercase { font-size: 0.65rem; font-weight: 800; }
    @media print {
        .sidebar, .top-navbar, .btn, .alert { display: none !important; }
        .main-wrapper { margin-left: 0 !important; }
    }
</style>

<?= $this->endSection() ?>