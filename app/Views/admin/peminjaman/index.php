<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold text-slate-900 mb-1">Manajemen Peminjaman</h2>
        <p class="text-muted small mb-0">Validasi dan pantau status peminjaman alat mahasiswa.</p>
    </div>
    <div>
        <a href="/admin/peminjaman/create" class="btn btn-emerald px-4 py-2 rounded-pill shadow-sm fw-bold">
            <i class="bi bi-plus-lg me-2"></i>Tambah Peminjaman
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small uppercase">
                    <tr>
                        <th class="ps-4 py-3">No</th>
                        <th>Detail Peminjam</th>
                        <th>Alat & Kategori</th>
                        <th>Durasi Pinjam</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td>
                            <div class="fw-bold text-slate-900"><?= $p['nama'] ?></div>
                            <small class="text-muted">User ID: #<?= $p['user_id'] ?? 'N/A' ?></small>
                        </td>
                        <td>
                            <div class="text-dark fw-medium"><?= $p['nama_alat'] ?></div>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border-0 rounded-pill px-2 py-0 small" style="font-size: 0.7rem;">
                                <?= $p['nama_kategori'] ?? 'Alat' ?>
                            </span>
                        </td>
                        <td>
                            <div class="small text-dark"><i class="bi bi-calendar-event me-2 text-muted"></i><?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?></div>
                            <div class="small text-muted"><i class="bi bi-calendar-check me-2 text-muted"></i><?= date('d M Y', strtotime($p['tanggal_kembali'])) ?></div>
                        </td>
                        <td>
                            <?php 
                                $statusMap = [
                                    'pending' => ['bg-warning', 'Pending', 'bi-hourglass-split'],
                                    'dipinjam' => ['bg-success', 'Dipinjam', 'bi-arrow-repeat'],
                                    'ditolak' => ['bg-danger', 'Ditolak', 'bi-x-circle'],
                                    'selesai' => ['bg-primary', 'Selesai', 'bi-check2-all']
                                ];
                                $s = $statusMap[$p['status']] ?? ['bg-secondary', 'Dibatalkan', 'bi-question-circle'];
                            ?>
                            <span class="badge <?= $s[0] ?> bg-opacity-10 <?= str_replace('bg-', 'text-', $s[0]) ?> rounded-pill px-3 py-2 border-0 small">
                                <i class="bi <?= $s[2] ?> me-1"></i> <?= $s[1] ?>
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                <a href="/admin/peminjaman/detail/<?= $p['id'] ?>" class="btn btn-white btn-sm px-3 border-end" title="Detail">
                                    <i class="bi bi-eye text-info"></i>
                                </a>

                                <?php if($p['status'] == 'pending'): ?>
                                    <a href="/admin/peminjaman/approve/<?= $p['id'] ?>" class="btn btn-white btn-sm px-3 border-end" title="Setujui" onclick="return confirm('Setujui peminjaman ini?')">
                                        <i class="bi bi-check-lg text-success"></i>
                                    </a>
                                    <a href="/admin/peminjaman/reject/<?= $p['id'] ?>" class="btn btn-white btn-sm px-3" title="Tolak" onclick="return confirm('Tolak peminjaman ini?')">
                                        <i class="bi bi-trash text-danger"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if($p['status'] == 'dipinjam'): ?>
                                    <a href="/admin/peminjaman/cancel/<?= $p['id'] ?>" class="btn btn-white btn-sm px-3 text-warning" title="Batalkan" onclick="return confirm('Batalkan status peminjaman ini?')">
                                        <i class="bi bi-slash-circle"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-emerald { background-color: #10b981; color: white; border: none; transition: 0.3s; }
    .btn-emerald:hover { background-color: #059669; color: white; transform: translateY(-2px); }
    .btn-white { background: white; border: 1px solid #edf2f7; }
    .btn-white:hover { background: #f8fafc; }
    .table-hover tbody tr:hover { background-color: #fcfcfd; }
    .badge { font-weight: 600; letter-spacing: 0.3px; }
    .text-slate-900 { color: #0f172a; }
</style>

<?= $this->endSection() ?>