<section class="content-header">
  <a href="<?= site_url('tiket/tambah') ?>" class="btn btn-primary btn-sm">+ Tambah Tiket</a>
</section>

<section class="content">
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
    </div>
  <?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="fa fa-exclamation-triangle"></i> <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Jumlah Terjual</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($list as $row): ?>
        <tr>
          <td><?= $row->tanggal ?></td>
          <td><?= $row->jumlah_terjual ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</section>