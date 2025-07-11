<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= isset($title) ? $title : 'EfiTix'; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <base href="<?= base_url(); ?>">

  <link rel="stylesheet" href="assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="assets/adminlte/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">

  <style>
    .navbar-custom-menu .dropdown-menu {
      width: 320px !important;
    }

    .navbar-custom-menu .dropdown-menu .menu {
      max-height: 350px;
      overflow-y: auto;
    }

    .navbar-custom-menu .dropdown-menu li a {
      white-space: normal !important;
      font-size: 14px;
      padding: 10px;
    }

    .navbar-custom-menu .dropdown-menu .header {
      font-weight: bold;
      padding: 10px;
      background-color: #f4f4f4;
      border-bottom: 1px solid #ddd;
    }

    .navbar-custom-menu .dropdown-menu .footer {
      padding: 10px;
      text-align: center;
      border-top: 1px solid #ddd;
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <a href="<?= site_url('dashboard') ?>" class="logo">
      <span class="logo-mini"><b>E</b>T</span>
      <span class="logo-lg"><b>Efi</b>Tix</span>
    </a>

    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i>
              <?php
              $jumlahNotif = isset($notifikasi) ? count($notifikasi) : 0;
              if ($jumlahNotif > 0): ?>
                <span class="label label-warning"><?= $jumlahNotif ?></span>
              <?php endif; ?>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda memiliki <?= $jumlahNotif ?> notifikasi</li>
              <li>
                <ul class="menu">
                  <?php if (!empty($notifikasi)): ?>
                    <?php foreach ($notifikasi as $n): ?>
                      <li>
                        <a href="#">
                          <i class="fa fa-circle text-<?= htmlspecialchars($n->tipe) ?>"></i>
                          <?= htmlspecialchars($n->pesan) ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <li><a>Tidak ada notifikasi</a></li>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="footer"><a href="<?= site_url('notifikasi') ?>">Lihat semua</a></li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user-circle-o"></i> <span class="hidden-xs"><?= $username; ?></span>
            </a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <?php $this->load->view('templates/sidebar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <h1><?= $title; ?></h1>
    </section>

    <section class="content">