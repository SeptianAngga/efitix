<div class="content-wrapper">
  <section class="content-header">
    <h1>Input Penjualan Tiket Hari Ini</h1>
  </section>

  <section class="content">
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
      </div>
    <?php elseif ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
      </div>
    <?php endif; ?>

    <?php if ($sudah_input): ?>
      <div class="alert alert-info">
        Anda sudah menginput penjualan tiket hari ini (<strong><?= $sudah_input->jumlah_terjual ?></strong> tiket).
      </div>
    <?php else: ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Input Tiket</h3>
        </div>
        <form method="post" action="<?= site_url('tiket_pekerja/simpan') ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="jumlah_terjual">Jumlah Tiket Terjual</label>
              <input type="number" name="jumlah_terjual" id="jumlah_terjual" class="form-control" required min="0" placeholder="Contoh: 120">
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </section>
</div>