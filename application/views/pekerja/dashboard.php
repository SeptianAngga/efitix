<div class="content-wrapper">
  <section class="content-header">
    <h1>Selamat Datang, <?= $pekerja->nama_lengkap ?></h1>
    <small><?= date('l, d F Y') ?> - <?= $cuaca['description'] ?></small>
  </section>

  <section class="content">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Jadwal Anda Hari Ini</h3>
      </div>
      <div class="box-body">
        <?php if ($jadwal): ?>
          <table class="table table-bordered">
            <tr>
              <th>Shift</th>
              <td><?= $jadwal->shift ?></td>
            </tr>
            <tr>
              <th>Jam</th>
              <td>
                <?php
                  // Aturan jam kerja berdasarkan jabatan dan shift
                  $jam_shift = '-';
                  $aturan = [
                    'Tiket' => [
                      'Pagi' => '07:00 – 19:00',
                      'Malam' => '19:00 – 07:00',
                    ],
                    'Validasi' => [
                      'Pagi' => '07:00 – 19:00',
                      'Malam' => '19:00 – 07:00',
                    ],
                    'Kebersihan' => [
                      'Pagi' => '06:00 – 12:00',
                      'Sore' => '12:00 – 19:00',
                    ],
                  ];
                  if (isset($aturan[$pekerja->jabatan][$jadwal->shift])) {
                    $jam_shift = $aturan[$pekerja->jabatan][$jadwal->shift];
                  }
                  echo $jam_shift;
                ?>
              </td>
            </tr>
            <tr>
              <th>Jabatan</th>
              <td><?= $pekerja->jabatan ?></td>
            </tr>
            <tr>
              <th>Status Kehadiran</th>
              <td>
                <?= $jadwal->status_kehadiran ?>
                <?php if (in_array(strtolower($jadwal->status_kehadiran), ['belum', 'belum konfirmasi'])): ?>
                  <div class="mt-2">
                    <form action="<?= base_url('dashboard_pekerja/konfirmasi_kehadiran') ?>" method="post" style="display:inline;">
                      <input type="hidden" name="status" value="Hadir">
                      <input type="hidden" name="jadwal_id" value="<?= $jadwal->id ?>">
                      <button type="submit" class="btn btn-success btn-sm">Hadir</button>
                    </form>
                    <form action="<?= base_url('dashboard_pekerja/konfirmasi_kehadiran') ?>" method="post" style="display:inline;">
                      <input type="hidden" name="status" value="Tidak Hadir">
                      <input type="hidden" name="jadwal_id" value="<?= $jadwal->id ?>">
                      <button type="submit" class="btn btn-danger btn-sm">Tidak Hadir</button>
                    </form>
                  </div>
                <?php endif; ?>
              </td>
            </tr>
          </table>
        <?php else: ?>
          <div class="alert alert-info">Tidak ada jadwal hari ini.</div>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>