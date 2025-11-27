<?php require_once APP_PATH . '/views/layouts/mahasiswa_header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-pencil-square"></i> Input Nilai Mata Kuliah</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Input Nilai</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> <strong>Petunjuk:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Isi nilai mata kuliah dengan skala 0-100</li>
                        <li>Nilai yang sudah diinput dapat diupdate kapan saja</li>
                        <li>Pastikan semua mata kuliah sudah terisi sebelum memproses rekomendasi</li>
                    </ul>
                </div>

                <form action="<?= url('mahasiswa/inputNilai') ?>" method="POST" data-validate>
                    <?= csrf_field() ?>

                    <?php foreach ($matkul_by_kriteria as $kriteria_id => $data): ?>
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">
                            <i class="bi bi-bookmark"></i> <?= escape($data['nama']) ?>
                        </h5>
                        <div class="row">
                            <?php foreach ($data['matakuliah'] as $mk): ?>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <?= escape($mk['kode']) ?> - <?= escape($mk['nama_matkul']) ?>
                                </label>
                                <div class="input-group">
                                    <input type="number" 
                                           name="nilai[<?= $mk['id'] ?>]" 
                                           class="form-control" 
                                           min="0" 
                                           max="100" 
                                           step="0.01"
                                           value="<?= $nilai_map[$mk['id']] ?? '' ?>"
                                           placeholder="0-100">
                                    <span class="input-group-text">
                                        <?php 
                                        $current_nilai = $nilai_map[$mk['id']] ?? 0;
                                        if ($current_nilai >= 85) echo '<span class="badge bg-success">A</span>';
                                        elseif ($current_nilai >= 70) echo '<span class="badge bg-primary">B</span>';
                                        elseif ($current_nilai >= 55) echo '<span class="badge bg-warning">C</span>';
                                        elseif ($current_nilai > 0) echo '<span class="badge bg-danger">D</span>';
                                        else echo '<span class="badge bg-secondary">-</span>';
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= url('mahasiswa/dashboard') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Real-time grade calculation
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function() {
        const nilai = parseFloat(this.value) || 0;
        const badge = this.parentElement.querySelector('.badge');
        
        if (nilai >= 85) {
            badge.className = 'badge bg-success';
            badge.textContent = 'A';
        } else if (nilai >= 70) {
            badge.className = 'badge bg-primary';
            badge.textContent = 'B';
        } else if (nilai >= 55) {
            badge.className = 'badge bg-warning';
            badge.textContent = 'C';
        } else if (nilai > 0) {
            badge.className = 'badge bg-danger';
            badge.textContent = 'D';
        } else {
            badge.className = 'badge bg-secondary';
            badge.textContent = '-';
        }
    });
});
</script>

<?php require_once APP_PATH . '/views/layouts/mahasiswa_footer.php'; ?>
