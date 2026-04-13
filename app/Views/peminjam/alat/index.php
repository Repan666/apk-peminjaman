<?= $this->extend('layouts/peminjam_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Daftar Alat Praktikum</h2>
        <p class="text-muted small mb-0">Monitor ketersediaan dan kondisi alat secara real-time.</p>
    </div>
    
    <div class="d-flex gap-2">
        <form action="<?= base_url('peminjam/alat') ?>" method="get" class="d-flex gap-2">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border bg-white" style="width: 280px;">
                <span class="input-group-text bg-white border-0 ps-3">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" 
                       name="keyword" 
                       class="form-control border-0 ps-0 small" 
                       placeholder="Cari nama atau kode..." 
                       value="<?= esc($keyword) ?>">
                
                <?php if ($keyword): ?>
                    <a href="<?= base_url('peminjam/alat') ?>" class="btn bg-white border-0 text-muted px-3 d-flex align-items-center">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-emerald rounded-pill px-4 shadow-sm fw-bold">Cari</button>
        </form>
    </div>
</div>
<?php if (!empty($keyword)): ?>
    <div class="mb-4 animate__animated animate__fadeIn">
        <div class="d-inline-flex align-items-center bg-white border border-emerald border-opacity-50 px-3 py-2 rounded-3 shadow-sm">
            <div class="bg-emerald bg-opacity-10 p-2 rounded-2 me-3">
                <i class="bi bi-search text-emerald"></i>
            </div>
            <div>
                <span class="text-muted small d-block" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Hasil Pencarian</span>
                <span class="text-slate-900 fw-bold">
                    "<?= esc($keyword) ?>"
                </span>
                <a href="<?= base_url('peminjam/alat') ?>" class="ms-2 text-danger small text-decoration-none" title="Bersihkan Pencarian">
                    <i class="bi bi-x-circle-fill"></i>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
        <div>
            <div class="fw-bold">Gagal Mengajukan!</div>
            <span class="small"><?= session()->getFlashdata('error') ?></span>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4 py-3" style="letter-spacing: 0.5px;">Detail Alat</th>
                        <th style="letter-spacing: 0.5px;">Kategori</th>
                        <th style="letter-spacing: 0.5px;">Status Stok</th>
                        <th style="letter-spacing: 0.5px;">Kondisi</th>
                        <th class="text-center" style="letter-spacing: 0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alat)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-box-seam fs-1 opacity-25 d-block mb-3"></i>
                                    <h5 class="text-muted fw-normal">Data alat tidak ditemukan</h5>
                                    <a href="<?= base_url('peminjam/alat') ?>" class="btn btn-link text-emerald text-decoration-none">Refresh Halaman</a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($alat as $a): ?>
                        <?php 
                            $kondisi_raw = strtolower(str_replace(' ', '_', $a['kondisi'])); 
                            $db = \Config\Database::connect();
                            $peminjaman_aktif = $db->table('peminjaman')
                                ->where('user_id', session()->get('user_id'))
                                ->where('alat_id', $a['id'])
                                ->whereIn('status', ['pending', 'dipinjam', 'menunggu_verifikasi'])
                                ->get()->getRowArray();
                                $isRusakBerat = ($kondisi_raw == 'rusak_berat');
                        ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-slate-900 mb-0"><?= $a['nama_alat'] ?></div>
                                <code class="text-muted small"><?= $a['kode_alat'] ?></code>
                            </td>
                            <td>
                                <span class="text-dark small"><i class="bi bi-tag me-1 text-muted"></i><?= $a['nama_kategori'] ?></span>
                            </td>
                            <td>
                                <?php 
                                    $sClass = ($a['stok'] <= 0) ? 'text-danger' : (($a['stok'] <= 5) ? 'text-warning' : 'text-success');
                                    $sIcon = ($a['stok'] <= 0) ? 'bi-box-seam-fill' : 'bi-box-seam';
                                ?>
                                <div class="<?= $sClass ?> small fw-bold"><i class="bi <?= $sIcon ?> me-1"></i> <?= $a['stok'] ?> Unit</div>
                            </td>
                            <td>
                                <?php if($kondisi_raw == 'baik'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">Baik</span>
                                <?php elseif($kondisi_raw == 'rusak_ringan'): ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1">Rusak Ringan</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Rusak Berat</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <?php if($peminjaman_aktif): ?>
                                    <button class="btn btn-secondary btn-sm px-3 py-2 rounded-pill opacity-75 fw-bold border-0" disabled>
                                        <i class="bi bi-hourglass-split me-1"></i> <?= ($peminjaman_aktif['status'] == 'pending') ? 'Menunggu' : 'Aktif' ?>
                                    </button>
                                <?php elseif($a['stok'] > 0 && !$isRusakBerat): ?>
                                    <button class="btn btn-emerald btn-sm px-4 py-2 rounded-pill shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#pinjamModal<?= $a['id'] ?>">
                                        Pinjam Alat
                                    </button>
                                <?php else: ?>
                                    <?php if($isRusakBerat): ?>
                                    <span class="text-danger small fw-bold">Rusak Berat</span>
                                <?php else: ?>
                                    <span class="text-muted small fw-bold">Stok Habis</span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <div class="modal fade" id="pinjamModal<?= $a['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-body p-4 text-center">
                                        <div class="mb-4">
                                            <div class="bg-emerald bg-opacity-10 text-emerald rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                                <i class="bi bi-file-earmark-text fs-3"></i>
                                            </div>
                                            <h5 class="fw-bold text-slate-900 mb-1">Form Peminjaman</h5>
                                            <p class="text-muted small">Anda akan mengajukan peminjaman:<br><strong><?= $a['nama_alat'] ?></strong></p>
                                        </div>
                                        
                                        <form action="<?= base_url('peminjam/peminjaman/ajukan') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="alat_id" value="<?= $a['id'] ?>">
                                            
                                            <div class="mb-3 text-start">
                                                <label class="form-label small fw-bold text-muted">Tanggal Pinjam</label>
                                                <input type="date" name="tanggal_pinjam" id="tgl_pinjam_<?= $a['id'] ?>" class="form-control rounded-3 border-0 bg-light" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" onchange="updateTglKembali(<?= $a['id'] ?>)" required>
                                            </div>

                                            <div class="mb-3 text-start">
                                                <label class="form-label small fw-bold text-muted">Rencana Kembali</label>
                                                <input type="date" name="tanggal_kembali" id="tgl_kembali_<?= $a['id'] ?>" class="form-control rounded-3 border-0 bg-light" min="<?= date('Y-m-d') ?>" required>
                                            </div>

                                            <div class="mb-4 text-start">
                                                <label class="form-label small fw-bold text-muted">Keperluan</label>
                                                <textarea name="keterangan" class="form-control rounded-3 border-0 bg-light" rows="2" placeholder="Tujuan peminjaman..." required></textarea>
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function updateTglKembali(id) {
        const tglPinjam = document.getElementById('tgl_pinjam_' + id).value;
        const inputKembali = document.getElementById('tgl_kembali_' + id);
        inputKembali.min = tglPinjam;
        if (inputKembali.value && inputKembali.value < tglPinjam) {
            inputKembali.value = tglPinjam;
        }
    }
</script>

<style>
    :root {
        --emerald-500: #10b981;
        --emerald-600: #059669;
        --slate-900: #0f172a;
    }
    .btn-emerald { background-color: var(--emerald-500); color: white; border: none; transition: all 0.3s ease; }
    .btn-emerald:hover { background-color: var(--emerald-600); color: white; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); }
    .bg-light { background-color: #f8fafc !important; }
    .text-slate-900 { color: var(--slate-900); }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; }
    .form-control:focus { box-shadow: none; border: 1px solid var(--emerald-500) !important; background-color: #fff !important; }
    .badge { font-weight: 600; }
</style>

<?= $this->endSection() ?>