<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pekerja</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/AdminLTE.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/skins/skin-blue.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/custom/sweetalert.min.css') ?>">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<header class="main-header">
  <a href="#" class="logo">
    <span class="logo-mini"><b>E</b>X</span>
    <span class="logo-lg"><b>Effi</b>Tix</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="notifBell">
            <i class="fa fa-bell"></i>
            <?php if (!empty($notifikasi)): ?>
              <span class="label label-warning"><?= count($notifikasi) ?></span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu">
            <li class="header">Notifikasi</li>
            <li>
              <ul class="menu">
                <?php foreach ($notifikasi as $n): ?>
                  <li>
                    <a href="#">
                      <i class="fa fa-info-circle text-blue"></i> <?= $n->pesan ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>
          </ul>
        </li>

        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user-circle"></i> <?= $pekerja->nama_lengkap ?>
          </a>
          <ul class="dropdown-menu">
            <li class="user-body text-center">
              <strong><?= $pekerja->nama_lengkap ?></strong><br>
              <small><?= $pekerja->jabatan ?></small>
            </li>
            <li class="user-footer">
              <div class="text-center">
                <a href="<?= site_url('auth/logout') ?>" class="btn btn-default btn-flat">Logout</a>
              </div>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </nav>
</header>