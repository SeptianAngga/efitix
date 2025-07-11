<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Pekerja</h3>
        <a href="<?= base_url('pekerja/tambah') ?>" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-plus"></i> Tambah Pekerja
        </a>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="bg-info text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Jabatan</th>
                    <th>Tipe</th>
                    <th>Hari Operasional</th>
                    <th>Shift</th>
                    <th>Tanggal Mulai</th>
                    <th>Level</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pekerja)): ?>
                    <tr><td colspan="10" class="text-center">Data tidak tersedia</td></tr>
                <?php else: $no = 1; foreach ($pekerja as $p): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $p->nama_lengkap; ?></td>
                        <td><?= $p->username; ?></td>
                        <td><?= $p->jabatan; ?></td>
                        <td><?= $p->tipe; ?></td>
                        <td><?= $p->hari_operasional; ?></td>
                        <td><?= $p->shift; ?></td>
                        <td><?= date('d-m-Y', strtotime($p->tanggal_mulai)); ?></td>
                        <td><?= ucfirst($p->level); ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('pekerja/edit/' . $p->id) ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a>
                            <a href="<?= base_url('pekerja/hapus/' . $p->id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin hapus data ini?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>