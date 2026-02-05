<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Cari Judul Kakak Tingkat</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('mahasiswa/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Judul Kakak Tingkat</li>
    </ol>

    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        <strong>Database Judul Tugas Akhir Tahun 2021</strong>
        <p class="mb-0 mt-2">
            Cari referensi judul tugas akhir dari kakak tingkat untuk mendapatkan inspirasi. 
            Database ini berisi judul-judul yang sudah dikerjakan pada tahun 2021.
        </p>
    </div>

    <!-- Search Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-search"></i> Pencarian Judul
        </div>
        <div class="card-body">
            <form action="<?= url('mahasiswa/cariJudulKating') ?>" method="GET">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="q" class="form-label">Kata Kunci</label>
                            <input type="text" class="form-control" id="q" name="q" 
                                   value="<?= escape($keyword) ?>"
                                   placeholder="Cari berdasarkan judul, nama mahasiswa, atau NIM...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" id="tahun" name="tahun">
                                <option value="">Semua Tahun</option>
                                <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>" <?= $year == $tahun ? 'selected' : '' ?>>
                                    <?= $year ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="<?= url('mahasiswa/cariJudulKating') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-list-ul"></i> Hasil Pencarian
                <?php if (!empty($keyword) || !empty($tahun)): ?>
                <span class="badge bg-primary"><?= count($results) ?> hasil</span>
                <?php endif; ?>
            </span>
        </div>
        <div class="card-body">
            <?php if (!empty($results)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Judul</th>
                            <th width="20%">Mahasiswa</th>
                            <th width="10%">Tahun</th>
                            <th width="15%">Tema</th>
                            <th width="10%">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($results as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= escape($item['judul']) ?></strong>
                                <?php if (!empty($item['dosen_pembimbing'])): ?>
                                <br><small class="text-muted">
                                    <i class="bi bi-person"></i> Pembimbing: <?= escape($item['dosen_pembimbing']) ?>
                                </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= escape($item['nama_mahasiswa']) ?>
                                <br><small class="text-muted"><?= escape($item['nim']) ?></small>
                            </td>
                            <td><?= $item['tahun'] ?></td>
                            <td>
                                <?php if ($item['tema_nama']): ?>
                                <span class="badge bg-info"><?= escape($item['tema_nama']) ?></span>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($item['nilai']): ?>
                                <span class="badge bg-<?= in_array($item['nilai'], ['A', 'A-']) ? 'success' : (in_array($item['nilai'], ['B+', 'B']) ? 'primary' : 'secondary') ?>">
                                    <?= escape($item['nilai']) ?>
                                </span>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Statistics -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6><i class="bi bi-bar-chart"></i> Statistik</h6>
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <h4 class="text-primary"><?= count($results) ?></h4>
                                        <small class="text-muted">Total Judul</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <h4 class="text-success">
                                            <?= count(array_filter($results, function($r) { return in_array($r['nilai'], ['A', 'A-']); })) ?>
                                        </h4>
                                        <small class="text-muted">Nilai A/A-</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <h4 class="text-info">
                                            <?= count(array_unique(array_column($results, 'tema_nama'))) ?>
                                        </h4>
                                        <small class="text-muted">Tema Berbeda</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3">
                                        <h4 class="text-warning">
                                            <?= count(array_unique(array_column($results, 'dosen_pembimbing'))) ?>
                                        </h4>
                                        <small class="text-muted">Dosen Pembimbing</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-search" style="font-size: 3rem;"></i>
                <p class="mt-3">
                    <?php if (!empty($keyword)): ?>
                        Tidak ditemukan hasil untuk "<strong><?= escape($keyword) ?></strong>"
                    <?php else: ?>
                        Tidak ada data judul yang tersedia.
                    <?php endif; ?>
                </p>
                <p><small>Coba dengan kata kunci yang berbeda.</small></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tips -->
    <div class="card mt-4 border-info">
        <div class="card-body">
            <h6 class="card-title"><i class="bi bi-lightbulb text-warning"></i> Tips Pencarian</h6>
            <ul class="mb-0">
                <li>Gunakan kata kunci spesifik seperti "sistem informasi", "mobile", "machine learning", dll</li>
                <li>Cari berdasarkan nama mahasiswa atau NIM jika ingin melihat karya tertentu</li>
                <li>Filter berdasarkan tahun untuk melihat tren judul per angkatan</li>
                <li>Perhatikan tema dan nilai untuk referensi topik yang potensial</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
