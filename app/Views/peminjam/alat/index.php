<?= $this->extend('layouts/peminjam_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Daftar Alat Praktikum</h2>
        <p class="text-muted small mb-0">Monitor ketersediaan dan kondisi alat secara real-time.</p>
    </div>
    <div class="d-flex gap-2">
        <div class="input-group shadow-sm rounded-pill overflow-hidden" style="width: 280px;">
            <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control border-0 ps-0 small" placeholder="Cari nama alat..." id="searchAlat">
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4 py-3">Detail Alat</th>
                        <th>Kategori</th>
                        <th>Status Stok</th>
                        <th>Kondisi Fisik</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($alat as $a): ?>
                    <?php 
                        // NORMALISASI DATA KONDISI (Biar sinkron Admin & Peminjam)
                        // Mengubah "Rusak Ringan" atau "RUSAK_RINGAN" jadi "rusak_ringan"
                        $kondisi_raw = strtolower(str_replace(' ', '_', $a['kondisi'])); 
                    ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="fw-bold text-slate-900"><?= $a['nama_alat'] ?></div>
                            <small class="text-muted font-monospace"><?= $a['kode_alat'] ?></small>
                        </td>
                        <td>
                            <span class="text-dark small"><i class="bi bi-tag me-1 text-muted"></i><?= $a['nama_kategori'] ?></span>
                        </td>
                        <td>
                            <?php 
                                if($a['stok'] <= 0) {
                                    $sClass = 'text-danger'; $sIcon = 'bi-box-seam-fill'; $sText = 'Habis';
                                } elseif($a['stok'] <= 5) {
                                    $sClass = 'text-warning'; $sIcon = 'bi-box-seam'; $sText = 'Terbatas';
                                } else {
                                    $sClass = 'text-success'; $sIcon = 'bi-box-seam'; $sText = 'Tersedia';
                                }
                            ?>
                            <div class="<?= $sClass ?> small fw-bold">
                                <i class="bi <?= $sIcon ?> me-1"></i> <?= $a['stok'] ?> <span class="fw-normal text-muted">Unit (<?= $sText ?>)</span>
                            </div>
                        </td>
                        <td>
                            <?php 
                                if($kondisi_raw == 'baik') {
                                    echo '<span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 small"><i class="bi bi-shield-check me-1"></i>Baik</span>';
                                } elseif($kondisi_raw == 'rusak_ringan') {
                                    echo '<span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 small"><i class="bi bi-shield-exclamation me-1"></i>Rusak Ringan</span>';
                                } elseif($kondisi_raw == 'rusak_berat') {
                                    echo '<span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 small"><i class="bi bi-shield-x me-1"></i>Rusak Berat</span>';
                                } else {
                                    echo '<span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 small">'.ucwords($a['kondisi']).'</span>';
                                }
                            ?>
                        </td>
                        <td class="text-center pe-4">
                            <?php 
                                // TOMBOL AKTIF JIKA: Stok ada DAN kondisi bukan rusak berat
                                if($a['stok'] > 0 && $kondisi_raw != 'rusak_berat'): 
                            ?>
                                <button class="btn btn-emerald btn-sm px-4 py-2 rounded-pill shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#pinjamModal<?= $a['id'] ?>">
                                    Pinjam Alat
                                </button>
                            <?php else: ?>
                                <button class="btn btn-light btn-sm px-4 py-2 rounded-pill text-muted border small fw-bold" disabled>
                                    <i class="bi bi-lock-fill me-1"></i> Non-Aktif
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <div class="modal fade" id="pinjamModal<?= $a['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-body p-4">
                                    <div class="text-center mb-4">
                                        <h5 class="fw-bold text-slate-900 mb-1">Form Peminjaman</h5>
                                        <p class="text-muted small">Alat: <strong><?= $a['nama_alat'] ?></strong></p>
                                    </div>
                                    
                                    <?php if($kondisi_raw == 'rusak_ringan'): ?>
                                    <div class="alert alert-warning border-0 small rounded-3 mb-3 py-2">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i><strong>Perhatian:</strong> Alat ini dalam kondisi rusak ringan.
                                    </div>
                                    <?php endif; ?>

                                    <form action="<?= base_url('peminjam/peminjaman/ajukan') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="alat_id" value="<?= $a['id'] ?>">
                                        
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Tanggal Pinjam</label>
                                            <input type="date" name="tanggal_pinjam" class="form-control form-control-sm rounded-3 border-0 bg-light" value="<?= date('Y-m-d') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-muted">Rencana Kembali</label>
                                            <input type="date" name="tanggal_kembali" class="form-control form-control-sm rounded-3 border-0 bg-light" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label small fw-bold text-muted">Keperluan</label>
                                            <textarea name="keterangan" class="form-control form-control-sm rounded-3 border-0 bg-light" rows="2" placeholder="Tujuan peminjaman..."></textarea>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-emerald py-2 rounded-pill fw-bold shadow-sm">Kirim Pengajuan</button>
                                            <button type="button" class="btn btn-link text-muted text-decoration-none small" data-bs-dismiss="modal">Batalkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; transition: 0.3s; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-2px); }
    .bg-light { background-color: #f8fafc !important; }
    .text-slate-900 { color: #0f172a; }
    .badge { letter-spacing: 0.3px; }
</style>

<?= $this->endSection() ?>