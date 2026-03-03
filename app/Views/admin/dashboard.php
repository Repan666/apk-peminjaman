<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-slate-900">Dashboard Overview</h2>
    <span class="badge bg-white text-dark border p-2 px-3 shadow-sm rounded-pill">
        <i class="bi bi-calendar3 me-2 text-success"></i> <?= date('d M Y') ?>
    </span>
</div>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-people-fill text-primary fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total User</p>
                    <h3 class="fw-bold mb-0">124</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-tools text-success fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Alat</p>
                    <h3 class="fw-bold mb-0">85</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-clock-history text-warning fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Pending</p>
                    <h3 class="fw-bold mb-0">12</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 rounded-4">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-danger bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-arrow-repeat text-danger fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Aktif Pinjam</p>
                    <h3 class="fw-bold mb-0">24</h3>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Peminjaman Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Nama Peminjam</th>
                                <th>Alat</th>
                                <th>Tgl Pinjam</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">Andi Wijaya</td>
                                <td>Multimeter Digital</td>
                                <td>03 Mar 2026</td>
                                <td><span class="badge bg-warning text-dark px-3">Pending</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>