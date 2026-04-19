<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/admin/pengembalian" class="text-decoration-none small fw-bold text-emerald">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <div class="d-flex justify-content-between align-items-center mt-2">
        <h2 class="fw-bold text-slate-900">Audit Pengembalian</h2>
        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 small">
            ID Transaksi: <span class="font-monospace text-emerald"><?= str_pad($peminjaman['id'], 5, '0', STR_PAD_LEFT) ?></span>
        </span>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="fw-bold mb-0 text-slate-900">Histori Transaksi Alat</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <tbody>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase w-25">Peminjam</th>
                                <td class="ps-4 py-3 fw-bold text-slate-900">
                                    <i class="bi bi-person-circle me-2 text-emerald"></i><?= $peminjaman['nama'] ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase">Alat</th>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-emerald"><?= $peminjaman['nama_alat'] ?></div>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase">Rentang Waktu</th>
                                <td class="ps-4 py-3">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <small class="text-muted d-block small uppercase">Pinjam</small>
                                            <span class="fw-medium text-dark"><?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])) ?></span>
                                        </div>
                                        <div class="col-4 border-start ps-3">
                                            <small class="text-muted d-block small uppercase">Batas Kembali</small>
                                            <span class="fw-medium text-warning"><?= date('d M Y', strtotime($peminjaman['tanggal_kembali'])) ?></span>
                                        </div>
                                        <div class="col-4 border-start ps-3">
                                            <small class="text-muted d-block small uppercase">Dikembalikan</small>
                                            <span class="fw-bold text-primary"><?= $peminjaman['tanggal_dikembalikan'] ? date('d M Y', strtotime($peminjaman['tanggal_dikembalikan'])) : '-' ?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase">Detail Denda</th>
                                <td class="ps-4 py-3">
                                    <?php if($peminjaman['denda'] > 0): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill fw-bold">
                                            Rp <?= number_format($peminjaman['denda'], 0, ',', '.') ?>
                                        </span>
                                        <small class="text-muted ms-2 italic">*Terlambat dikembalikan</small>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-bold">
                                            Rp 0 (Tepat Waktu)
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="ps-4 py-3 bg-light text-muted small uppercase">Catatan Verifikasi</th>
                                <td class="ps-4 py-3 text-dark">
                                    <div class="p-3 bg-light rounded-3 border-start border-3 italic">
                                        "<?= $peminjaman['keterangan'] ?: 'Tidak ada catatan tambahan.' ?>"
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 p-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="/admin/pengembalian/edit/<?= $peminjaman['id'] ?>" class="btn btn-emerald px-4 rounded-pill fw-bold btn-sm shadow-sm">
                        <i class="bi bi-pencil-square me-1"></i> Ubah Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <?php 
                // Normalisasi status ke lowercase untuk pengecekan
                $status_check = strtolower($peminjaman['status'] ?? '');
                
                // Set warna default (Warning/Kuning)
                $bg_box = 'bg-warning';
                $text_box = 'text-dark';
                $label_status = 'MENUNGGU VERIFIKASI';

                if ($status_check === 'selesai') {
                    $bg_box = 'bg-success'; // Pakai bg-success bawaan bootstrap biar aman
                    $text_box = 'text-white';
                    $label_status = 'TRANSAKSI SELESAI';
                }
            ?>
            
            <div class="p-4 text-center <?= $bg_box ?> <?= $text_box ?>" style="min-height: 120px; display: flex; flex-direction: column; justify-content: center;">
                <small class="text-uppercase fw-bold opacity-75" style="letter-spacing: 1px; font-size: 0.7rem;">Status Pengembalian</small>
                <h3 class="fw-bold mb-0 mt-1"><?= $label_status ?></h3>
            </div>

            <div class="card-body p-4 bg-white">
                <div class="d-flex align-items-center mb-4">
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-light p-2 rounded-3 me-3">
                        <i class="bi bi-clock-history text-muted fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block small uppercase" style="font-size: 0.6rem;">Terakhir Diperbarui</small>
                        <span class="fw-bold text-slate-900 small">
                            <?= date('d M Y, H:i', strtotime($peminjaman['updated_at'] ?? 'now')) ?> WIB
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1 !important;">
            <div class="card-body p-4">
                <h6 class="fw-bold small text-uppercase mb-3 text-slate-900">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Catatan Audit
                </h6>
                <p class="small text-muted mb-0" style="line-height: 1.6;">
                    Data ini bersifat permanen setelah status menjadi <strong>Selesai</strong>. 
                    Setiap perubahan pada tanggal dikembalikan akan secara otomatis mengkalkulasi ulang nilai denda pada sistem.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahan CSS untuk memastikan warna Emerald muncul */
    .bg-emerald { background-color: #10b981 !important; }
    .text-emerald { color: #10b981 !important; }
    .btn-emerald { background-color: #10b981; color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    
    /* Warna teks gelap untuk kontras */
    .text-slate-900 { color: #0f172a !important; }

    @media print {
        .btn, .badge, .text-decoration-none, .alert, .card-footer { display: none !important; }
        .col-lg-4 { width: 100% !important; }
    }
</style>

<?= $this->endSection() ?>