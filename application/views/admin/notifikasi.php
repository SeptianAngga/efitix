<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-bell"></i> Semua Notifikasi</h3>
  </div>

  <div class="box-body">
    <?php if (empty($notifikasi)): ?>
      <p class="text-muted">Tidak ada notifikasi yang tersedia.</p>
    <?php else: ?>
      <ul class="list-group">
        <?php foreach ($notifikasi as $n): ?>
          <li class="list-group-item">
            <i class="fa fa-circle text-<?= $n->tipe ?>"></i>
            <?= htmlspecialchars($n->pesan); ?>
            <span class="pull-right text-muted" style="font-size: 12px;">
              <?= date('H:i', strtotime($n->waktu)) ?>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>