<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold text-slate-900">Manajemen Pengembalian</h2>
        <p class="text-muted small">Verifikasi pengembalian alat, hitung denda otomatis, dan pantau histori log.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-warning bg-opacity-10 border-start border-warning border-4">
            <small class="text-muted d-block">Menunggu Verifikasi</small>
            <h4 class="fw-bold text-dark mb-0">
                <?php 
                    $pendingCount = array_filter($pengembalian, fn($i) => $i['status'] == 'menunggu_verifikasi');
                    echo count($pendingCount);
                ?>
            </h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-success bg-opacity-10 border-start border-success border-4">
            <small class="text-muted d-block">Selesai Hari Ini</small>
            <h4 class="fw-bold text-dark mb-0">
                 <?php 
                    $successCount = array_filter($pengembalian, fn($i) => $i['status'] == 'selesai');
                    echo count($successCount);
                ?>
            </h4>
        </div>
    </div>
</div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small uppercase">NO</th>
                        <th class="py-3 text-muted small uppercase">PEMINJAM</th>
                        <th class="py-3 text-muted small uppercase">ALAT</th>
                        <th class="py-3 text-muted small uppercase">TGL PINJAM / KEMBALI</th>
                        <th class="py-3 text-muted small uppercase text-center">TGL DIKEMBALIKAN</th>
                        <th class="py-3 text-muted small uppercase text-center">DENDA</th>
                        <th class="py-3 text-muted small uppercase text-center">STATUS</th>
                        <th class="pe-4 py-3 text-muted small uppercase text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($pengembalian as $row): ?>
                    <tr>
                        <td class="ps-4 fw-medium text-slate-500"><?= $no++ ?></td>
                        <td>
                        <div class="fw-bold text-slate-900 mb-1"><?= $row['nama'] ?></div>
                        <div class="small text-muted">
                            <div class="d-flex align-items-center mb-1">
                                <i class="bi bi-whatsapp text-success me-2" style="font-size: 0.8rem;"></i>
                                <span><?= $row['no_hp'] ?? '-' ?></span>
                            </div>
                            <div class="d-flex align-items-start">
                                <i class="bi bi-geo-alt text-emerald me-2" style="font-size: 0.8rem; margin-top: 3px;"></i>
                                <span class="text-truncate" style="max-width: 150px;" title="<?= esc($row['alamat'] ?? '') ?>">
                                    <?= $row['alamat'] ?? 'N/A' ?>
                                </span>
                            </div>
                        </div>
                    </td>
                        <td>
                            <span class="badge bg-light text-dark fw-medium border"><?= $row['nama_alat'] ?></span>
                        </td>
                        <td>
                            <div class="small">
                                <span class="text-muted">P:</span> <?= date('d/m/y', strtotime($row['tanggal_pinjam'])) ?><br>
                                <span class="text-muted">K:</span> <span class="fw-bold"><?= date('d/m/y', strtotime($row['tanggal_kembali'])) ?></span>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php if($row['tanggal_dikembalikan']): ?>
                                <span class="text-dark fw-medium"><?= date('d/m/y', strtotime($row['tanggal_dikembalikan'])) ?></span>
                            <?php else: ?>
                                <span class="text-muted small">Belum Kembali</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($row['denda'] > 0): ?>
                                <span class="text-danger fw-bold">Rp <?= number_format($row['denda'], 0, ',', '.') ?></span>
                            <?php else: ?>
                                <span class="text-success small">Rp 0</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($row['status'] == 'menunggu_verifikasi'): ?>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    <i class="bi bi-clock-history me-1"></i> Menunggu
                                </span>
                            <?php elseif($row['status'] == 'selesai'): ?>
                                <span class="badge bg-emerald text-white px-3 py-2 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i> Selesai
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                <a href="/admin/pengembalian/detail/<?= $row['id'] ?>" class="btn btn-white btn-sm px-3 border-end" title="Detail">
                                    <i class="bi bi-eye text-primary"></i>
                                </a>
                                <a href="/admin/pengembalian/edit/<?= $row['id'] ?>" class="btn btn-white btn-sm px-3" title="Edit/Verifikasi">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3 px-4 border-top-0">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan <?= count($pengembalian) ?> data pengembalian alat.</small>
            </div>
    </div>
</div>

<style>
    .bg-emerald { background-color: #10b981 !important; }
    .text-slate-900 { color: #0f172a !important; }
    .uppercase { font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px; }
    .btn-white { background: #fff; border: 1px solid #edf2f7; }
    .btn-white:hover { background: #f8fafc; }
    .table-hover tbody tr:hover { background-color: #f8fafc; transition: 0.2s; }
</style>

<?= $this->endSection() ?>