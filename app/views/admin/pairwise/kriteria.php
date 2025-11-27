<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Pairwise Comparison Kriteria</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Pairwise Kriteria</li>
    </ol>

    <?php if (!empty($kriteria) && count($kriteria) >= 2): ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-grid-3x3-gap me-1"></i>
            Matriks Perbandingan Berpasangan
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Petunjuk:</strong> Masukkan nilai perbandingan antar kriteria.<br>
                Skala: 1 = Sama penting, 3 = Sedikit lebih penting, 5 = Lebih penting, 7 = Sangat penting, 9 = Mutlak lebih penting
            </div>

            <form action="<?= url('admin/pairwiseKriteria') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria 1</th>
                                <th>Perbandingan</th>
                                <th>Kriteria 2</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pairwise_array = [];
                            if (!empty($pairwise)) {
                                foreach ($pairwise as $p) {
                                    $pairwise_array[$p['kriteria_1'] . '_' . $p['kriteria_2']] = $p['nilai'];
                                }
                            }
                            
                            for ($i = 0; $i < count($kriteria); $i++):
                                for ($j = $i + 1; $j < count($kriteria); $j++):
                                    $k1 = $kriteria[$i];
                                    $k2 = $kriteria[$j];
                                    $key = $k1['id'] . '_' . $k2['id'];
                                    $nilai = $pairwise_array[$key] ?? 1;
                            ?>
                            <tr>
                                <td>
                                    <strong><?= escape($k1['kode']) ?></strong> - <?= escape($k1['nama_kriteria']) ?>
                                </td>
                                <td class="text-center">vs</td>
                                <td>
                                    <strong><?= escape($k2['kode']) ?></strong> - <?= escape($k2['nama_kriteria']) ?>
                                </td>
                                <td>
                                    <input type="hidden" name="kriteria_1[]" value="<?= $k1['id'] ?>">
                                    <input type="hidden" name="kriteria_2[]" value="<?= $k2['id'] ?>">
                                    <input type="number" step="0.01" name="nilai[]" 
                                           class="form-control" value="<?= $nilai ?>" 
                                           min="0.11" max="9" required>
                                </td>
                            </tr>
                            <?php
                                endfor;
                            endfor;
                            ?>
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-calculator"></i> Simpan & Hitung Bobot
                </button>
            </form>

            <?php if (!empty($hasil)): ?>
            <hr class="my-4">
            <h5>Hasil Perhitungan</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Bobot Kriteria</div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kriteria</th>
                                        <th>Bobot</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['bobot'] as $k => $bobot): ?>
                                    <tr>
                                        <td><?= escape($k) ?></td>
                                        <td><?= number_format($bobot, 6) ?></td>
                                        <td><?= number_format($bobot * 100, 2) ?>%</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Informasi Konsistensi</div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th>Lambda Max</th>
                                    <td><?= number_format($hasil['lambda_max'], 6) ?></td>
                                </tr>
                                <tr>
                                    <th>CI</th>
                                    <td><?= number_format($hasil['ci'], 6) ?></td>
                                </tr>
                                <tr>
                                    <th>CR</th>
                                    <td>
                                        <?= number_format($hasil['cr'], 6) ?>
                                        <?php if ($hasil['cr'] <= 0.1): ?>
                                            <span class="badge bg-success">Konsisten</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Tidak Konsisten</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        Minimal harus ada 2 kriteria untuk melakukan perbandingan berpasangan.
        <a href="<?= url('admin/kriteria') ?>">Tambah Kriteria</a>
    </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
