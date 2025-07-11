<?php
if (!isset($pekerja)) {
    $CI =& get_instance();
    $CI->load->model('Pekerja_dashboard_model');
    $pekerja = $CI->Pekerja_dashboard_model->get_by_user_id($CI->session->userdata('user_id'));
}
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>

            <li class="<?= $this->uri->segment(1) == 'dashboard_pekerja' ? 'active' : '' ?>">
                <a href="<?= site_url('dashboard_pekerja') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>

            <?php if (isset($pekerja) && strtolower($pekerja->jabatan) == 'tiket'): ?>
                <li class="<?= $this->uri->segment(1) == 'tiket_pekerja' ? 'active' : '' ?>">
                    <a href="<?= site_url('tiket_pekerja') ?>"><i class="fa fa-ticket"></i> <span>Input Tiket</span></a>
                </li>
            <?php endif; ?>

            <li>
                <a href="<?= site_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
            </li>
        </ul>
    </section>
</aside>