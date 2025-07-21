<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">NAVIGASI UTAMA</li>

      <li class="<?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
        <a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
      </li>

      <li class="<?= $this->uri->segment(1) == 'pekerja' ? 'active' : '' ?>">
        <a href="<?= base_url('pekerja') ?>"><i class="fa fa-users"></i> <span>Manajemen Pekerja</span></a>
      </li>

            <li class="<?= $this->uri->segment(2) == 'prediksi' ? 'active' : '' ?>">
        <a href="<?= site_url('prediksi') ?>"><i class="fa fa-line-chart"></i> <span>Prediksi Kebutuhan</span></a>
      </li>
      
      <li class="<?= $this->uri->segment(2) == 'jadwal' ? 'active' : '' ?>">
        <a href="<?= site_url('jadwal'); ?>"><i class="fa fa-calendar"></i> <span>Jadwal Pekerja</span></a>
      </li>

      <li>
        <a href="<?= site_url('tiket') ?>"><i class="fa fa-ticket"></i> <span>Penjualan Tiket</span></a>
      </li>

      <li class="<?= $this->uri->segment(1) == 'laporan' ? 'active' : '' ?>">
        <a href="<?= base_url('laporan') ?>"><i class="fa fa-file-text"></i> <span>Laporan</span></a>
      </li>

      <li>
        <a href="<?= base_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
      </li>
    </ul>
  </section>
</aside>