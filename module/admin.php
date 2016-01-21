<?php

use Landingo\Resources\Auth;

Auth::isNot(array('cms_login' => true))->redirect('login');

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>CMS Administrator</title>
    <link rel="stylesheet" href="<?=$base_url?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$base_url?>/assets/awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/admin.css">
    <script src="<?=$base_url?>/assets/js/jquery.min.js"></script>
    <script src="<?=$base_url?>/assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
          <span class="glyphicon glyphicon-leaf"></span>
          aidi CMS
      </a>
    </div>
      <div>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">  <span class="fa fa-cogs"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#"><span class="fa fa-user"></span>Profil Saya</a></li>
              <li><a href="#"><span class="fa fa-picture-o"></span>Ganti Avatar</a></li>
              <?php
                if(Auth::isNot(array('cms_login_as' => 'superuser'))->cek())
                {
                    echo '<li>';
                    echo '<a href="#"><span class="fa fa-wrench"></span>Konfigurasi App</a>';
                    echo '</li>';
                }
              ?>  
              <li role="separator" class="divider"></li>
              <li><a href="<?=$base_url?>/do-login.php"><span class="fa fa-sign-out"></span>Keluar</a></li>
            </ul>
          </li>
        </ul>
      </div>
  </div>
</nav>

<div class="container-fluid">
<div class="row">


<div class="col-md-2" id="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=$base_url?>/img/ava/ava.jpg" class="img-circle">
      </div>
      <div class="pull-left info">
        <p>Indra Daud</p>
        <a href="#">
          <span class="fa fa-circle text-success"></span>
          Online
        </a>
      </div>
    </div>
    <div class="clearfix"></div>
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li>
        <a href="<?=$base_url?>/index.php/admin">
          <span class="fa fa-dashboard"></span>
          Dashboard
        </a>
      </li>
      <li>
        <a href="<?=$base_url?>" target="_blank">
          <span class="fa fa-desktop"></span>
          Tampilan Depan
        </a>
      </li>

      <li class="dropdown-link">
        <a aria-expanded="false" data-toggle="collapse" aria-controls="menuBerita" href="#menuBerita">
          <span class="fa fa-newspaper-o"></span>
            Berita
          <span class="fa fa-angle-left pull-right"></span>
        </a>
        <ul class="dropdown-contents collapse" id="menuBerita">
          <li>
            <a href="<?=$base_url?>/index.php/admin/berita">
              <span class="fa fa-th"></span>
                Managemen Berita
            </a>
          </li>
          <li>
            <a href="<?=$base_url?>/index.php/admin/berita/tulis">
              <span class="fa fa-pencil-square-o"></span>
                Tulis Berita
            </a>
          </li>
        </ul>
      </li>
      <li class="dropdown-link">
        <a aria-expanded="false" data-toggle="collapse" aria-controls="menuKategori" href="#menuKategori">
          <span class="fa fa-link"></span>
            Kategori
          <span class="fa fa-angle-left pull-right"></span>
        </a>
        <ul class="dropdown-contents collapse" id="menuKategori">
          <li>
            <a href="<?=$base_url?>/index.php/admin/kategori">
              <span class="fa fa-list"></span>
                Semua Kategori
            </a>
          </li>
          <li>
            <a href="<?=$base_url?>/index.php/admin/kategori/tambah">
              <span class="fa fa-plus-square-o"></span>
                Tambah Kategori
            </a>
          </li>
        </ul>
      </li>

      <li>
        <a href="<?=$base_url?>/index.php/admin/user">
          <span class="fa fa-user"></span>
          User
        </a>
      </li>
      <li>
        <a href="<?=$base_url?>/index.php/admin/statistik">
          <span class="fa fa-area-chart"></span>
          Statistik
        </a>
      </li>
      <li>
        <a href="<?=$base_url?>/license.txt">
          <span class="fa fa-certificate"></span>
          Lisensi
        </a>
      </li>
      
    </ul>
</div>

<div class="col-md-10" id="wrapper">

<?php $this->loadPage() ?>

</div>

</div>
</div>

<script type="text/javascript">
$('#sidebar').height($(document).height() - $('.navbar').height() - 2);

  $('.dropdown-link a').click(function(event) {
    $(this).parent('li').find('span.fa.fa-angle-left').toggleClass('fa-angle-down');
  });
</script>
</body>
</html>