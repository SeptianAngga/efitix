<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Tambah Jadwal</h3>
  </div>
  <form method="post" action="<?= site_url('jadwal/simpan') ?>">
    <div class="box-body">
      <div class="form-group">
        <label>Pekerja</label>
        <select name="pekerja_id" id="pekerja_id" class="form-control" required>
          <option value="">-- Pilih --</option>
          <?php foreach ($pekerja as $p): ?>
            <option value="<?= $p->id ?>">
              <?= $p->nama_lengkap ?> (<?= $p->jabatan ?>, <?= $p->shift ?>, <?= $p->tipe_pekerja ?>, <?= $p->hari_operasional ?>)
            </option>
          <?php endforeach; ?>
        </select>
        <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
      </div>

      <div class="form-group">
        <label>Shift</label>
        <input type="text" name="shift" id="shift" class="form-control" readonly required>
      </div>
    </div>

    <div class="box-footer">
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="<?= site_url('jadwal?from=' . $tanggal) ?>" class="btn btn-default">Batal</a>
    </div>
  </form>
</div>

<script>
document.getElementById('pekerja_id').addEventListener('change', function () {
  const pekerjaId = this.value;

  fetch('<?= site_url("jadwal/get_shift_by_pekerja") ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `pekerja_id=${encodeURIComponent(pekerjaId)}`
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById('shift').value = data.shift || '';
  });
});
</script>