<section class="content-header">
  <p>
    <i class="fa fa-calendar"></i> <?= $tanggal_lengkap ?> &nbsp;
    <i class="fa fa-cloud"></i> <?= $cuaca ?>
  </p>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-4">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?= $jumlah_pengunjung; ?></h3>
          <p>Prediksi Jumlah Pengunjung <i class="fa fa-info-circle" title="Berdasarkan algoritma prediksi otomatis."></i></p>
        </div>
        <div class="icon"><i class="fa fa-bar-chart"></i></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= $tiket_terjual; ?></h3>
          <p>Tiket Terjual <i class="fa fa-info-circle" title="Data ini diinput manual oleh admin."></i></p>
        </div>
        <div class="icon"><i class="fa fa-ticket"></i></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= $rekomendasi; ?></h3>
          <p>Rekomendasi Jumlah Pekerja</p>
        </div>
        <div class="icon"><i class="fa fa-users"></i></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?= $tetap; ?></h3>
          <p>Jumlah Pekerja Tetap</p>
        </div>
        <div class="icon"><i class="fa fa-user"></i></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="small-box bg-navy">
        <div class="inner">
          <h3><?= $freelance; ?></h3>
          <p>Jumlah Pekerja Freelance</p>
        </div>
        <div class="icon"><i class="fa fa-user-o"></i></div>
      </div>
    </div>
  </div>

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Pekerja Bertugas Hari Ini</h3>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Shift</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($bertugas)): ?>
            <tr><td colspan="3" class="text-center">Tidak ada jadwal hari ini</td></tr>
          <?php else: ?>
            <?php foreach ($bertugas as $b): ?>
              <tr>
                <td><?= $b->nama_lengkap; ?></td>
                <td><?= $b->jabatan; ?></td>
                <td><?= $b->shift; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Grafik Tren Pengunjung Mingguan</h3>
    </div>
    <div class="box-body" style="height: 300px;">
      <canvas id="grafikPengunjung" style="width: 100%; height: 100%;"></canvas>
    </div>
  </div>
</section>

<script src="<?= base_url('assets/adminlte/plugins/chartjs/Chart.min.js'); ?>"></script>

<script>
  const labelGrafik = <?= json_encode(json_decode($grafik_label)); ?>;
  const dataGrafik = <?= json_encode(json_decode($grafik_data)); ?>;

  if (labelGrafik.length > 0 && dataGrafik.length > 0) {
    const ctx = document.getElementById('grafikPengunjung').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labelGrafik,
        datasets: [{
          label: 'Pengunjung',
          data: dataGrafik,
          backgroundColor: 'rgba(60,141,188,0.2)',
          borderColor: '#3c8dbc',
          borderWidth: 2,
          pointBackgroundColor: '#3c8dbc',
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 10
            }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          },
          tooltip: {
            mode: 'index',
            intersect: false
          }
        }
      }
    });
  }
</script>