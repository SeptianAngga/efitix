<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah / Edit Pekerja</h3>
        </div>
        <form action="<?= ($action == 'edit') ? site_url('pekerja/update/' . $pekerja->id) : site_url('pekerja/simpan'); ?>" method="post">
            <div class="box-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= @$pekerja->nama_lengkap; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?= @$pekerja->username; ?>" <?= ($action == 'edit') ? 'readonly' : 'required'; ?>>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= @$pekerja->email; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" <?= ($action == 'tambah') ? 'required' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password2" class="form-control" <?= ($action == 'tambah') ? 'required' : ''; ?>>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="<?= @$pekerja->tanggal_mulai; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Hari Operasional</label>
                            <select name="hari_operasional" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Awal Pekan', 'Akhir Pekan', 'HLN/Event'] as $opt): ?>
                                    <option value="<?= $opt; ?>" <?= (@$pekerja->hari_operasional == $opt) ? 'selected' : ''; ?>><?= $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Level Login</label>
                            <select name="level" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="admin" <?= (@$pekerja->level == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="pekerja" <?= (@$pekerja->level == 'pekerja' || $action == 'tambah') ? 'selected' : ''; ?>>Pekerja</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jabatan</label>
                            <select name="jabatan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <?php 
                                    $jabatans = ['Tiket', 'Validasi', 'Kebersihan', 'Admin'];
                                    foreach ($jabatans as $opt): 
                                ?>
                                    <option value="<?= $opt; ?>" <?= (@$pekerja->jabatan == $opt) ? 'selected' : ''; ?>><?= $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Shift</label>
                            <select name="shift" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Pagi', 'Siang', 'Sore', 'Malam'] as $opt): ?>
                                    <option value="<?= $opt; ?>" <?= (@$pekerja->shift == $opt) ? 'selected' : ''; ?>><?= $opt; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tipe Pekerja</label><br>
                            <label><input type="radio" name="tipe" value="Tetap" <?= (@$pekerja->tipe == 'Tetap' || $action == 'tambah') ? 'checked' : ''; ?>> Tetap</label>
                            <label style="margin-left: 15px;"><input type="radio" name="tipe" value="Freelance" <?= (@$pekerja->tipe == 'Freelance') ? 'checked' : ''; ?>> Freelance</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer text-right">
                <a href="<?= site_url('pekerja'); ?>" class="btn btn-default">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</section>