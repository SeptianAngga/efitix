<section class="content-header">
  <a href="<?= site_url('jadwal/tambah') ?>" class="btn btn-primary">
    <i class="fa fa-plus"></i> Tambah Jadwal
  </a>
</section>

<section class="content">
  <div class="box box-primary">
    <div class="box-header with-border text-center">
      <button class="btn btn-default" onclick="navigateDate(-1)">
        <i class="fa fa-chevron-left"></i> Sebelumnya
      </button>
      <strong style="margin: 0 20px;"><?= date('l, d F Y', strtotime($tanggal)); ?></strong>
      <button class="btn btn-default" onclick="navigateDate(1)">
        Berikutnya <i class="fa fa-chevron-right"></i>
      </button>
    </div>

    <div class="box-body table-responsive">
      <?php if (!empty($keterangan_sisa)) : ?>
        <div class="alert alert-warning">
          <strong><i class="fa fa-exclamation-circle"></i> Kebutuhan Belum Terpenuhi:</strong>
          <ul style="margin-bottom: 0;">
            <?php foreach ($keterangan_sisa as $item) : ?>
              <li><?= $item; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php elseif ($notif_terpenuhi): ?>
        <div class="alert alert-success">
          🎉 Seluruh kebutuhan jadwal pekerja pada tanggal ini telah terpenuhi. Terima kasih!
        </div>
      <?php endif; ?>

      <table class="table table-bordered table-hover">
        <thead>
          <tr class="bg-info">
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Shift</th>
            <th>Status Hadir</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($jadwal)): ?>
            <tr><td colspan="4" class="text-center">Tidak ada jadwal untuk hari ini.</td></tr>
          <?php else: ?>
            <?php foreach ($jadwal as $j): ?>
              <tr>
                <td><?= htmlspecialchars($j->nama_lengkap); ?></td>
                <td><?= htmlspecialchars($j->jabatan); ?></td>
                <td><?= htmlspecialchars($j->shift); ?></td>
                <td>
                  <?php if ($j->user_id == $user_id): ?>
                    <select class="form-control status-select" data-id="<?= $j->id; ?>">
                      <option value="Belum" <?= $j->status_kehadiran == 'Belum' ? 'selected' : '' ?>>Belum</option>
                      <option value="Hadir" <?= $j->status_kehadiran == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                      <option value="Tidak Hadir" <?= $j->status_kehadiran == 'Tidak Hadir' ? 'selected' : '' ?>>Tidak Hadir</option>
                      <option value="Belum Konfirmasi" <?= $j->status_kehadiran == 'Belum Konfirmasi' ? 'selected' : '' ?>>Belum Konfirmasi</option>
                    </select>
                  <?php else: ?>
                    <?php
                      $status = $j->status_kehadiran;
                      if ($status == 'Hadir') {
                        echo '<span class="label label-success"><i class="fa fa-check"></i> Hadir</span>';
                      } elseif ($status == 'Tidak Hadir') {
                        echo '<span class="label label-danger"><i class="fa fa-times"></i> Tidak Hadir</span>';
                      } elseif ($status == 'Belum Konfirmasi') {
                        echo '<span class="label label-warning"><i class="fa fa-question-circle"></i> Belum Konfirmasi</span>';
                      } else {
                        echo '<span class="label label-default"><i class="fa fa-clock-o"></i> Belum</span>';
                      }
                    ?>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
  function navigateDate(offset) {
    const currentDate = '<?= $tanggal; ?>';
    window.location.href = '<?= site_url('jadwal/index/') ?>' + offset + '?from=' + currentDate;
  }

  document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function () {
      const id = this.getAttribute('data-id');
      const status = this.value;

      fetch('<?= site_url('jadwal/update_status') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${encodeURIComponent(id)}&status=${encodeURIComponent(status)}`
      })
      .then(res => res.json())
      .then(response => {
        if (!response.success) {
          alert("Gagal mengupdate status.");
        }
      });
    });
  });
</script>