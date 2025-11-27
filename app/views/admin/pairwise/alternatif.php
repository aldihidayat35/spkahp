<?php require_once APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Pairwise Comparison Alternatif</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Pairwise Alternatif</li>
    </ol>

    <?php if (!empty($kriteria)): ?>
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <i class="bi bi-filter me-1"></i>
            Pilih Kriteria
        </div>
        <div class="card-body">
            <form action="<?= url('admin/pairwiseAlternatif') ?>" method="GET" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kriteria</label>
                    <select name="kriteria_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Kriteria --</option>
                        <?php foreach ($kriteria as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= (isset($selected_kriteria) && $selected_kriteria == $k['id']) ? 'selected' : '' ?>>
                                <?= escape($k['kode']) ?> - <?= escape($k['nama_kriteria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($selected_kriteria) && !empty($alternatif) && count($alternatif) >= 2): ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-grid-3x3-gap me-1"></i>
            Matriks Perbandingan Alternatif
            <?php if (!empty($kriteria_info)): ?>
                - Kriteria: <strong><?= escape($kriteria_info['nama_kriteria']) ?></strong>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Petunjuk:</strong> Masukkan nilai perbandingan antar alternatif tema berdasarkan kriteria yang dipilih.<br>
                Skala: 1 = Sama penting, 3 = Sedikit lebih penting, 5 = Lebih penting, 7 = Sangat penting, 9 = Mutlak lebih penting
            </div>

            <form action="<?= url('admin/pairwiseAlternatif') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="kriteria_id" value="<?= $selected_kriteria ?>">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Alternatif 1</th>
                                <th>Perbandingan</th>
                                <th>Alternatif 2</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pairwise_array = [];
                            if (!empty($pairwise)) {
                                foreach ($pairwise as $p) {
                                    $pairwise_array[$p['alternatif_1'] . '_' . $p['alternatif_2']] = $p['nilai'];
                                }
                            }
                            
                            for ($i = 0; $i < count($alternatif); $i++):
                                for ($j = $i + 1; $j < count($alternatif); $j++):
                                    $a1 = $alternatif[$i];
                                    $a2 = $alternatif[$j];
                                    $key = $a1['id'] . '_' . $a2['id'];
                                    $nilai = $pairwise_array[$key] ?? 1;
                            ?>
                            <tr>
                                <td>
                                    <strong><?= escape($a1['kode']) ?></strong> - <?= escape($a1['nama_tema']) ?>
                                </td>
                                <td class="text-center">vs</td>
                                <td>
                                    <strong><?= escape($a2['kode']) ?></strong> - <?= escape($a2['nama_tema']) ?>
                                </td>
                                <td>
                                    <input type="hidden" name="alternatif_1[]" value="<?= $a1['id'] ?>">
                                    <input type="hidden" name="alternatif_2[]" value="<?= $a2['id'] ?>">
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
                    <i class="bi bi-calculator"></i> Simpan & Hitung
                </button>
            </form>

            <?php if (!empty($hasil)): ?>
            <hr class="my-4">
            <h5>Hasil Perhitungan</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Bobot Alternatif</div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Alternatif</th>
                                        <th>Bobot</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['bobot'] as $alt => $bobot): ?>
                                    <tr>
                                        <td><?= escape($alt) ?></td>
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
    <?php elseif (isset($selected_kriteria)): ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        Minimal harus ada 2 alternatif untuk melakukan perbandingan berpasangan.
        <a href="<?= url('admin/alternatif') ?>">Tambah Alternatif</a>
    </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/layouts/admin_footer.php'; ?>
