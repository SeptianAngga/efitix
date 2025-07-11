<footer class="main-footer text-center">
  <strong>EffiTix &copy; <?= date('Y') ?></strong>
</footer>

</div> <script src="<?= base_url('assets/adminlte/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>
<script src="<?= base_url('assets/custom/sweetalert.min.js') ?>"></script>
<script>
function konfirmasiKehadiran(status) {
  Swal.fire({
    title: 'Konfirmasi Kehadiran',
    text: 'Anda memilih: ' + status,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "<?= site_url('dashboard_pekerja/konfirmasi_kehadiran/') ?>" + status.toLowerCase() + "/<?= $jadwal->id ?>";
    }
  });
}
</script>
</body>
</html>