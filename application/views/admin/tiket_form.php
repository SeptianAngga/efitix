<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Input Tiket Terjual Hari Ini</h3>
  </div>

  <form method="post" action="<?= site_url('tiket/tambah') ?>">
    <div class="box-body">
      <div class="form-group">
        <label for="jumlah_terjual">Jumlah Tiket Terjual:</label>
        <input type="number" name="jumlah_terjual" class="form-control" required>
      </div>
    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="<?= site_url('tiket') ?>" class="btn btn-default">Kembali</a>
    </div>
  </form>
</div>