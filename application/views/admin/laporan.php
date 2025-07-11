<div class="box box-primary" id="laporan-area">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-file-text-o"></i> Laporan</h3>
  </div>

  <div class="box-body">
    <form class="form-inline" method="get">
      <label>Periode:&nbsp;</label>
      <input type="date" name="awal" class="form-control" value="<?= $awal ?>">
      <span> - </span>
      <input type="date" name="akhir" class="form-control" value="<?= $akhir ?>">
      <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
    </form>

    <hr>

    <div class="row text-center">
      <div class="col-md-4">
        <div class="callout callout-info">
          <h4>Total Pengunjung</h4>
          <h2><?= number_format($pengunjung) ?></h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="callout callout-primary">
          <h4>Total Tiket Terjual</h4>
          <h2><?= number_format($tiket) ?></h2>
        </div>
      </div>
      <div class="col-md-4">
        <div class="callout callout-success">
          <h4>Total Shift yang Dijalankan</h4>
          <h2><?= number_format($shift) ?></h2>
        </div>
      </div>
    </div>

    <canvas id="pengunjungChart" height="100"></canvas>
    <br>
    <canvas id="rataChart" height="100"></canvas>
    <br>

    <div class="box box-solid">
      <div class="box-body">
        <h4><i class="fa fa-info-circle text-primary"></i> Ringkasan Data</h4>
        <?php
          $dataPengunjung = array_map('intval', array_column($bulanan, 'total'));
          $rataLabel = array_column($rata_pekerja, 'bulan');
          $shiftData = array_map('intval', array_column($rata_pekerja, 'shift'));
          $pekerjaData = array_map('floatval', array_column($rata_pekerja, 'rata_pekerja'));
        ?>
        <p>
          Berdasarkan grafik di atas, jumlah pengunjung mengalami
          <?= (!empty($dataPengunjung) && end($dataPengunjung) > $dataPengunjung[0]) ? '<strong>peningkatan</strong>' : '<strong>penurunan</strong>' ?> dari bulan sebelumnya.
          Hal ini dapat dilihat dari garis tren pada grafik pengunjung.
        </p>
        <p>
          Pada grafik batang, jumlah shift yang dijalankan dibandingkan dengan rata-rata jumlah pekerja yang dibutuhkan.
          Bulan <strong><?= $rataLabel[0] ?? '-' ?></strong> memiliki <strong><?= $shiftData[0] ?? '-' ?></strong> shift, dengan rata-rata <strong><?= $pekerjaData[0] ?? '-' ?></strong> pekerja.
        </p>
        <p>
          Data ini dapat digunakan oleh manajemen untuk mengevaluasi kebutuhan SDM dan pola kerja di bulan berikutnya.
        </p>
      </div>
    </div>

    <div class="text-right">
      <button class="btn btn-lg btn-primary" id="btnExportPDF">
        <i class="fa fa-file-pdf-o"></i> Ekspor PDF
      </button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
  const bulanLabel = <?= json_encode(array_column($bulanan, 'bulan')) ?>;
  const dataPengunjung = <?= json_encode(array_map('intval', array_column($bulanan, 'total'))) ?>;

  const pengunjungChart = new Chart(document.getElementById('pengunjungChart'), {
    type: 'line',
    data: {
      labels: bulanLabel,
      datasets: [{
        label: 'Pengunjung',
        data: dataPengunjung,
        borderColor: 'blue',
        backgroundColor: 'rgba(0, 0, 255, 0.2)',
        borderWidth: 2,
        fill: true,
        tension: 0.3,
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    }
  });

  const rataLabel = <?= json_encode(array_column($rata_pekerja, 'bulan')) ?>;
  const shiftData = <?= json_encode(array_map('intval', array_column($rata_pekerja, 'shift'))) ?>;
  const pekerjaData = <?= json_encode(array_map('floatval', array_column($rata_pekerja, 'rata_pekerja'))) ?>;

  const rataChart = new Chart(document.getElementById('rataChart'), {
    type: 'bar',
    data: {
      labels: rataLabel,
      datasets: [
        {
          label: 'Shift',
          data: shiftData,
          backgroundColor: 'rgba(0, 123, 255, 0.7)'
        },
        {
          label: 'Rata-rata Pekerja',
          data: pekerjaData,
          backgroundColor: 'rgba(0, 200, 100, 0.7)'
        }
      ]
    }
  });

  // Ekspor PDF
  document.getElementById('btnExportPDF').addEventListener('click', function () {
    const area = document.getElementById('laporan-area');

    html2canvas(area).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF('p', 'mm', 'a4');

      const pageWidth = pdf.internal.pageSize.getWidth();
      const imgProps = pdf.getImageProperties(imgData);
      const pdfWidth = pageWidth - 20;
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      pdf.setFontSize(16);
      pdf.text("Laporan Bulanan EfiTix", 20, 20);
      pdf.setFontSize(11);
      pdf.text("Periode: <?= date('F Y', strtotime($awal)) ?> - <?= date('F Y', strtotime($akhir)) ?>", 20, 28);

      pdf.addImage(imgData, 'PNG', 10, 35, pdfWidth, pdfHeight);
      pdf.save("Laporan_Bulanan_EfiTix.pdf");
    });
  });
</script>