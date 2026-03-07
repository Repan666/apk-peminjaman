<?= $this->extend('layouts/peminjam_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <h2 class="fw-bold text-slate-900 mb-1">Pinjaman Aktif</h2>
    <p class="text-muted small mb-0">Daftar alat yang sedang Anda bawa. Segera kembalikan sebelum jatuh tempo.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4 py-3" style="width: 50px;">No</th>
                        <th>Informasi Alat</th>
                        <th>Waktu Peminjaman</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($peminjaman)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                Tidak ada pinjaman yang sedang aktif.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php $no=1; foreach($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td>
                            <div class="fw-bold text-slate-900"><?= $p['nama_alat'] ?></div>
                        </td>
                        <td>
                            <div class="small text-dark fw-medium">
                                <i class="bi bi-calendar-event me-1 text-emerald"></i>
                                <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                            </div>
                        </td>
                        <td>
                            <?php 
                                $tgl_kembali = strtotime($p['tanggal_kembali']);
                                $hari_ini = strtotime(date('Y-m-d'));
                                $is_late = ($hari_ini > $tgl_kembali);
                            ?>
                            <div class="small fw-bold <?= $is_late ? 'text-danger' : 'text-slate-900' ?>">
                                <i class="bi bi-calendar-check me-1"></i>
                                <?= date('d M Y', strtotime($p['tanggal_kembali'])) ?>
                                <?php if($is_late): ?>
                                    <span class="badge bg-danger ms-1 small" style="font-size: 0.6rem;">Terlambat!</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-emerald bg-opacity-10 text-emerald rounded-pill px-3 py-1 small">
                                <i class="bi bi-arrow-repeat me-1"></i> <?= ucwords($p['status']) ?>
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <button type="button" class="btn btn-emerald btn-sm px-4 py-2 rounded-pill shadow-sm fw-bold" 
                                    data-bs-toggle="modal" data-bs-target="#modalKembali<?= $p['id'] ?>">
                                Kembalikan <i class="bi bi-box-arrow-in-left ms-1"></i>
                            </button>

                            <div class="modal fade" id="modalKembali<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-body p-4 text-center">
                                            <div class="bg-emerald bg-opacity-10 text-emerald rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                                <i class="bi bi-question-circle fs-3"></i>
                                            </div>
                                            <h5 class="fw-bold text-slate-900 mb-2">Konfirmasi Kembali?</h5>
                                            <p class="text-muted small mb-4">Anda akan mengajukan pengembalian untuk alat <strong><?= $p['nama_alat'] ?></strong>.</p>
                                            
                                            <form action="<?= base_url('peminjam/pengembalian/'.$p['id']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-emerald py-2 rounded-pill fw-bold">Ya, Ajukan Sekarang</button>
                                                    <button type="button" class="btn btn-link text-muted text-decoration-none small" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; transition: 0.2s; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-1px); }
    .text-emerald { color: #10b981; }
    .text-slate-900 { color: #0f172a; }
    .bg-light { background-color: #f8fafc !important; }
    .table thead th { font-weight: 700; letter-spacing: 0.5px; border-bottom: none; }
    .table tbody td { border-bottom: 1px solid #f1f5f9; }
</style>

<?= $this->endSection() ?>