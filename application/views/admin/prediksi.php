<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-line-chart"></i> <?= $title ?></h3>
  </div>

  <div class="box-body">
    <form method="post" action="<?= site_url('prediksi/prediksi_submit') ?>" class="form-inline">

      <div class="form-group" style="margin-right: 15px;">
        <label for="tanggal">Tanggal:&nbsp;</label>
        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $tanggal ?>" required>
      </div>

      <div class="form-group" style="margin-right: 15px;">
        <label for="tipe_hari">Tipe Hari:&nbsp;</label>
        <select name="tipe_hari" id="tipe_hari" class="form-control">
          <option value="Awal Pekan" <?= $tipe_hari == 'Awal Pekan' ? 'selected' : '' ?>>Awal Pekan</option>
          <option value="Akhir Pekan" <?= $tipe_hari == 'Akhir Pekan' ? 'selected' : '' ?>>Akhir Pekan</option>
          <option value="Hari Libur" <?= $tipe_hari == 'Hari Libur' ? 'selected' : '' ?>>Hari Libur Nasional</option>
        </select>
      </div>

      <div class="form-group" style="margin-right: 15px;">
        <label for="cuaca">Cuaca:&nbsp;</label>
        <input type="text" class="form-control" name="cuaca" id="cuaca" value="<?= $cuaca ?>" readonly>
      </div>

      <button type="submit" class="btn btn-primary">
        <i class="fa fa-check"></i> Simpan Rekomendasi
      </button>
    </form>

    <hr>

    <div class="row">
      <div class="col-md-3">
        <div class="callout callout-info text-center">
          <h4>Prediksi Pengunjung</h4>
          <h2><?= $pengunjung ?></h2>
        </div>
      </div>

      <div class="col-md-3">
        <div class="callout callout-success text-center">
          <h4>Rekomendasi Tiket</h4>
          <h2><?= $tiket ?> pekerja</h2>
        </div>
      </div>

      <div class="col-md-3">
        <div class="callout callout-warning text-center">
          <h4>Rekomendasi Validasi</h4>
          <h2><?= $validasi ?> pekerja</h2>
        </div>
      </div>

      <div class="col-md-3">
        <div class="callout callout-danger text-center">
          <h4>Rekomendasi Kebersihan</h4>
          <h2><?= $kebersihan ?> pekerja</h2>
        </div>
      </div>
    </div>

    <small class="text-muted"><i class="fa fa-info-circle"></i> * Dihitung otomatis dari sistem prediksi (ML)</small>
  </div>
</div>