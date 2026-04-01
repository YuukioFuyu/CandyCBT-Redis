<?php

include("core/c_user.php");
require("config/config.function.php");
require("config/functions.crud.php");
require("config/config.candy2.php");


(isset($_SESSION['id_siswa'])) ? $id_siswa = $_SESSION['id_siswa'] : $id_siswa = 0;
($id_siswa == 0) ?  header("Location:$homeurl/login.php") : null;
($pg == 'testongoing') ? $sidebar = 'sidebar-collapse' : $sidebar = '';
($pg == 'testongoing') ? $disa = '' : $disa = 'offcanvas';
//agar navbar hiden saat ujian
if ($pg == 'testongoing') {
  $navbarhide = 'style="display: none;"';
} else {
  $navbarhide = '';
}

$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'"));
$kelasdb = fetch($koneksi, 'kelas', array('id_kelas' => $siswa['id_kelas']));
$idkelas = $kelasdb['idkls'];

$idsesi = $siswa['sesi'];
$idpk = $siswa['idpk'];
$level = $siswa['level'];
$pk = fetch($koneksi, 'pk', array('id_pk' => $idpk));
$tglsekarang = time();
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
  <title><?= $setting['aplikasi'] ?></title>
  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />
  <link rel='shortcut icon' href='<?= $homeurl ?>/favicon.ico' />
  <link rel='stylesheet' href='<?= $homeurl ?>/dist/bootstrap/css/bootstrap.min.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/fontawesome/css/all.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/dist/css/AdminLTE.min.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/dist/css/skins/skin-green-light.min.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/iCheck/square/green.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/animate/animate.min.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/toastr/toastr.min.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/radio/css/style.css'>

  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.css' />
  <link href="<?= $homeurl ?>/plugins/summernote/summernote-bs4.css" rel="stylesheet">
  <script src='<?= $homeurl ?>/plugins/jQuery/jquery-2.2.3.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/datatables/jquery.dataTables.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/tinymce/tinymce.min.js'></script>
  <script src="<?= $homeurl ?>/plugins/summernote/summernote-bs4.js"></script>
  <script src='<?= $homeurl ?>/plugins/datatables/jquery.dataTables.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.min.js'></script>


  <style type="text/css">
    .rapih {
      position: relative;
      display: inline-block;
      width: 20rem;

    }

    .btn {
      display: inline-block;
      /*padding: 6px 12px;*/
      margin-bottom: 3px;
      font-size: 14px;
      font-weight: 400;
      line-height: 1.42857143;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      -ms-touch-action: manipulation;
      touch-action: manipulation;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-image: none;
      border: 1px solid transparent;
      border-radius: 15px;
    }

    .btn-app>.badge {
      position: absolute;
      top: -3px;
      right: -10px;
      font-size: 10px;
      font-weight: 400;
    }

    .btn .badge {

      top: -1px;
    }

    .badge {
      display: inline-block;
      min-width: 10px;
      padding: 3px 7px;
      font-size: 12px;
      font-weight: 700;
      line-height: 1;
      color: #fff;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      background-color: #777;
      border-radius: 10px;
    }

    .soal img {
      max-width: 100%;
      height: auto;
    }

    .main-header .sidebar-baru {
      float: left;
      color: white;
      padding: 15px 15px;
      cursor: pointer;
    }

    .callout {
      border-left: 0px;
    }

    .btn {
      border-radius: 20em;
    }

    .btn.btn-flat {
      border-radius: 20em;
    }

    .skin-red-light .sidebar-menu>li:hover>a,
    .skin-red-light .sidebar-menu>li.active>a {
      color: #fff;
      background: #e111e8;
    }

    $('.soaltanya > p > span').css( {
        fontSize: fontSize + 'pt'
      }

    );

    .wrapper-page {
      margin: 7.5% auto;
      width: 360px;
    }

    .wrapper-page .form-control-feedback {
      left: 15px;
      top: 3px;
      color: rgba(76, 86, 103, 0.4);
      font-size: 20px;
    }

    .logo {
      color: #3bafda !important;
      font-size: 18px;
      font-weight: 700;
      letter-spacing: .02em;
      line-height: 70px;
    }

    .logo-lg {
      font-size: 28px !important;
    }

    .logo i {
      color: red;
    }

    .skin-green-light .sidebar-menu>li:hover>a,
    .skin-green-light .sidebar-menu>li.active>a {
      color: #fff;
      background: #0030a7;
      <?php
      if ($setting['jenjang'] == 'SMK') {
        echo "color: #fff;";
        //echo "background:#00a896;";
        echo "background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;";
      } elseif ($setting['jenjang'] == 'SMP') {
        echo "color: #fff;";
        echo "background:#0030a7;";
      } elseif ($setting['jenjang'] == 'SD') {
        echo "color: #fff;";
        echo "background:#c74230;";
      } else {
        echo "color: #fff;";
        echo "background:#00a896;";
      }
      ?>
    }

    /*Mode Gelap*/
    .theme-switch-wrapper {
      display: flex;
      margin-top: 0;
      /*margin-left: 2em;*/
    }

    em {
      margin-top: 0.5em;
      margin-left: 1em;
      font-size: 1rem;
    }

    .theme-switch {
      display: inline-block;
      height: 34px;
      position: relative;
      width: 60px;
    }

    .theme-switch input {
      display: none;
    }

    .slider {
      background-color: #ccc;
      bottom: 0;
      cursor: pointer;
      left: 0;
      position: absolute;
      right: 0;
      top: 0;
      transition: .4s;
    }

    .slider:before {
      background-color: #fff;
      bottom: 4px;
      content: "";
      height: 26px;
      left: 4px;
      position: absolute;
      transition: .4s;
      width: 26px;
    }

    input:checked+.slider {
      background-color: #66bb6a;
    }

    input:checked+.slider:before {
      transform: translateX(26px);
    }

    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }

    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      text-align: center;
    }

    .loading {
      position: absolute;
      left: 50%;
      top: 70%;
      transform: translate(-50%, -50%);
      font: 14px arial;
    }
  </style>
  <link rel='stylesheet' href='<?= $homeurl ?>/dist/css/costum.css' />
  <script type="text/javascript">
    $(document).ready(function() {
      $('.loader').fadeOut('slow');
    });
  </script>
</head>

<body class='hold-transition skin-green-light  fixed <?= $sidebar ?>'>
  <div id='pesan'></div>
  <div class='loader'>
    <div class="loading">
      <p id="pesanku">Harap Tunggu</p>
    </div>
  </div>
  <span id='livetime'></span>
  <?php if ($pg == 'testongoing') {
    $hilang = 'style="display: none;"';
    $displayn = "";
  } else {
    $hilang = '';
    $displayn = "content-wrapper";
  }  ?>
  <div class='wrapper'>
    <header class='main-header' <?= $hilang ?>>
      <a class='logo' style='background-color:#f9fafc'>
        <span class='animated flipInX logo-mini'>
          <img src="<?= $homeurl . "/" . $setting['logo'] ?>" height="30px">
        </span>
        <span class='animated flipInX logo-lg' style="margin:-3px;color:#000">
          <img src="<?= $homeurl . '/' . $setting['logo'] ?>" height="40px"> <?= $setting['sekolah'] ?>
        </span>
      </a>
      <?php

      if ($setting['jenjang'] == 'SMK') {
        //$style="style='background-color:#00a896;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
        $style = "style='background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;'";
      } elseif ($setting['jenjang'] == 'SMP') {
        $style = "style='background-color:#060151;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
      } elseif ($setting['jenjang'] == 'SD') {
        $style = "style='background-color:#dd4c39;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
      } else {
        $style = "style='background-color:#00a896;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
      }
      ?>


      <nav <?= $navbarhide; ?> class='navbar navbar-static-top navbarhiden' <?= $style; ?> role='navigation'>
        <a href='#' class='sidebar-baru' data-toggle='<?= $disa ?>' role='button'>
          <i class="fa fa-bars fa-lg fa-fw"></i> MENU
        </a>

        <div class='navbar-custom-menu'>
          <ul class='nav navbar-nav'>
            <li class="visible-xs"><a><?= $siswa['nama'] ?></a></li>
            <li class='dropdown user user-menu'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                <?php
                if ($siswa['foto'] <> '') :
                  if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
                    echo "<img src='$homeurl/dist/img/avatar_default.png' class='user-image'   alt='+'>";
                  else :
                    echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='user-image'   alt='+'>";
                  endif;
                else :
                  echo "<img src='$homeurl/dist/img/avatar_default.png' class='user-image'   alt='+'>";
                endif;
                ?>
                <span class='hidden-xs'><?= $siswa['nama'] ?> &nbsp; <i class='fa fa-caret-down'></i></span>
              </a>
              <ul class='dropdown-menu'>
                <li class='user-header'>
                  <?php
                  if ($siswa['foto'] <> '') :
                    if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
                      echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-circle' alt='User Image'>";
                    else :
                      echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img-circle' alt='User Image'>";
                    endif;
                  else :
                    echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-circle' alt='User Image'>";
                  endif;
                  ?>
                  <p>
                    <?= $siswa['nama'] ?>
                  </p>
                </li>
                <li class='user-footer'>
                  <div class='pull-right'>
                    <a href='<?= $homeurl ?>/logout.php' class='btn btn-sm btn-default btn-flat'><i class='fa fa-sign-out'></i> Keluar</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class='main-sidebar' <?= $hilang ?>>
      <section class='sidebar'>
        <hr style="margin:0px">
        <div class='user-panel'>
          <div class='pull-left image'>
            <?php
            if ($siswa['foto'] <> '') :
              if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
                echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:60px' alt='+'>";
              else :
                echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img'  style='max-width:60px' alt='+'>";
              endif;
            else :
              echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:60px' alt='+'>";
            endif;
            ?>
          </div>
          <div class='pull-left info' style='left:65px'>
            <?php
            if (strlen($siswa['nama']) > 15) {
              $nama = substr($siswa['nama'], 0, 15) . "...";
            } else {
              $nama = $siswa['nama'];
            }
            ?>
            <p title="<?= $siswa['nama'] ?>"><?= $nama ?></p>
            <a href='#'><i class='fa fa-circle text-green'></i> online</a><br>
            <a href='#'><i class='fa fa-circle text-blue'></i> <?= $siswa['id_kelas'] ?></a><br>
            <a href='#'><i class='fa fa-circle text-red'></i> <?= $siswa['idpk'] ?></a>
          </div>
        </div>
        <hr style="margin:0px">
        <ul class='sidebar-menu tree' data-widget='tree'>
          <li class='header'>Main Menu Peserta Ujian</li>
          <li><a href='<?= $homeurl ?>'><i class='fas fa-tachometer-alt fa-fw fa-2x '></i> <span> Dashboard</span></a></li>
          <hr style="margin:0px">
          <?php if ($setting['izin_info'] == 1) { ?>
            <li><a href='<?= $homeurl ?>/pengumuman'><img src="<?= $homeurl ?>/icon_siswa/megaphone.svg" width="30" height="30"> <span> Pengumuman</span></a></li>
            <hr style="margin:0px">
          <?php } else {
          } ?>
          <?php if ($setting['izin_absen'] == 1) { ?>
            <li><a href='<?= $homeurl ?>/absen/'><img src="<?= $homeurl ?>/icon_siswa/attendance_sekolah.svg" width="30" height="30"> <span> Absen Sekolah</span></a></li>
          <?php }
          if ($setting['izin_absen_mapel'] == 1) { ?>
            <li><a href='<?= $homeurl ?>/absen_mapel/'><img src="<?= $homeurl ?>/icon_siswa/attendance.svg" width="30" height="30"> <span> Absen Mata Pelajaran</span></a></li>
          <?php } ?>
          <?php if ($setting['izin_materi'] == 1) { ?>
            <li><a href='<?= $homeurl ?>/materi/'><img src="<?= $homeurl ?>/icon_siswa/book.svg" width="30" height="30"><span> Materi</span></a></li>
            <hr style="margin:0px">
          <?php } else {
          } ?>
          <?php if ($setting['izin_tugas'] == 1) { ?>
            <li><a href='<?= $homeurl ?>/tugassiswa'><img src="<?= $homeurl ?>/icon_siswa/tugas.svg" width="30" height="30"><span> Tugas Siswa</span></a></li>
            <hr style="margin:0px">
          <?php } else {
          } ?>
          <?php if ($setting['izin_ujian'] == 1) { ?>
            <li><a href='<?= $homeurl ?>/hasil'><img src="<?= $homeurl ?>/icon_siswa/result.svg" width="30" height="30"><span> Hasil Ujian</span></a></li>
            <hr style="margin:0px">
            <li><a href='brocandycbt.apk'><i class='fas fa-fw fa-2x fa-star'></i> <span>Exambro</span></a></li>
          <?php } ?>

          <?php if ($setting['izin_pass'] == 1) { ?>
            <li><a href='<?= $homeurl ?>/pass'><img src="<?= $homeurl ?>/icon_siswa/login.svg" width="30" height="30"> <span> Ganti Password</span></a></li>
            <hr style="margin:0px">
          <?php } else {
          } ?>

          <hr style="margin:0px">

        </ul><!-- /.sidebar-menu -->
      </section>
    </aside>
    <?php
    if ($setting['jenjang'] == 'SMK') {
      $style1 = "height:102px;z-index:0; background:#587ea3; ";
      /* #587ea3,#00a896,#007bb6,#2c4762 */
    } elseif ($setting['jenjang'] == 'SMP') {
      $style1 = "height:102px;z-index:0; background:#0030a7";
    } elseif ($setting['jenjang'] == 'SD') {
      $style1 = "height:102px;z-index:0; background:#c74230";
    } else {
      $style1 = "height:102px;z-index:0; background:#00a896";
    }
    ?>
    <div class='<?= $displayn ?>' style='background-image: url(admin/backgroun.jpg);background-size: cover;'>
      <section class='content-header' style="<?= $style1; ?>">
      </section>
      <!-- Halaman Dashbord Siswa -->
      <section class='content' style="margin-top:-95px">
        <?php if ($pg == '') : ?>
          <div class='row'>
            <div class='col-md-12'>
              <div class='alert alert-info alert-dismissible'>
                <?php if ($setting['izin_ujian'] == 1) { ?>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>
                  <i class='icon fa fa-info'></i>
                  Tombol ujian akan aktif bila waktu sudah sama dengan jadwal ujian,
                  Refresh browser atau tekan F5 jika waktu ujian belum aktif
                <?php } else {
                  echo "Selamat Datang " . $siswa['nama'];
                }
                ?>
              </div>
            </div>

            <div class='col-md-12'>
              <div class='box box-solid'>
                <div class='box-header with-border'>
                  <div class="text-center">
                    <h3 class='box-title'><i class="fa fa-bars fa-lg fa-fw"></i> MENU <?php if ($setting['izin_ujian'] == 1) { ?> CBT <?php } ?> E-LEARNING</h3>
                  </div>
                </div>
                <!-- menu e-learing siswa -->
                <div class='box-body'>
                  <div class="text-center">
                    <div class="row">
                      <div class="col-md-12">
                        <style type="text/css">
                          .btn {
                            border-radius: 3px;
                            -webkit-box-shadow: none;
                            box-shadow: none;
                            border: 1px solid transparent;
                          }
                        </style>
                        <!-- bagian ujian -->

                        <div class="row">
                          <div class="col-md-12">
                            <?php if ($setting['izin_ujian'] == 1) { ?>
                              <?php if ($siswa['status_siswa'] == 1) { ?>
                                <a style="width: 320px;" href="<?= $homeurl ?>/ujian" class="rapih btn btn-app btn-primary">
                                  <img src="icon_siswa/ubk.svg" width="30" height="30"> <b> Ujian Sekolah</b>
                                </a>
                              <?php } else { ?>
                                <button disabled class="rapih btn btn-app">
                                  <b> Status OFF, Hubungi Admin</b>
                                </button>
                              <?php } ?>

                            <?php } ?>
                          </div>
                        </div>

                        <div class="row">

                          <?php if ($setting['izin_info'] == 1) { ?>
                            <a href="<?= $homeurl ?>/pengumuman/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/megaphone.svg" width="30" height="30"> <b> Informasi Sekolah</b>
                            </a>
                          <?php } ?>

                          <?php if ($setting['izin_ujian'] == 1) { ?>
                            <a href="<?= $homeurl ?>/hasil/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/result.svg" width="30" height="30"> <b> Hasil Ujian</b>

                            </a>
                          <?php } ?>

                        </div>

                        <!-- bagian absensi -->
                        <div class="row">
                          <?php if ($setting['izin_absen'] == 1) { ?>
                            <a href="<?= $homeurl ?>/absen/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/attendance_sekolah.svg" width="30" height="30">
                              <b> Absen Sekolah</b>
                            </a>
                          <?php } ?>
                          <?php if ($setting['izin_absen_mapel'] == 1) { ?>
                            <a href="<?= $homeurl ?>/absen_mapel/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/attendance.svg" width="30" height="30"> <b> Absen Mapel</b>
                            </a>
                          <?php } ?>
                        </div>

                        <div class="row">
                          <?php if ($setting['izin_materi'] == 1) { ?>
                            <a href="<?= $homeurl ?>/materi/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/book.svg" width="30" height="30"> <b> Materi</b>
                            </a>
                          <?php } ?>
                          <?php if ($setting['izin_tugas'] == 1) { ?>
                            <a href="<?= $homeurl ?>/tugassiswa/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/tugas.svg" width="30" height="30"> <b> Tugas</b>
                            </a>
                          <?php } ?>
                        </div>

                        <?php if ($setting['izin_pass'] == 1) { ?>
                          <div class="row">
                            <a href="<?= $homeurl ?>/pass/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/login.svg" width="30" height="30"> <b> Ganti Password</b>
                            </a>
                          </div>
                        <?php } ?>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        <?php elseif ($pg == 'ujian') : ?>
          <div id="boxtampil" class='col-md-12'>
            <div id='formjadwalujian' class='box box-solid'>
              <div class="row">
                <div class="col-md-4">
                  <a href='<?= $homeurl ?>/logout.php' class='btn btn-sm btn-danger'><i class="fa fa-sign-out" aria-hidden="true"></i> Keluar Dari Ujian</a>
                </div>
              </div>
              <div class='box-header with-border'>
                <h3 class='box-title'><i class="fas fa-calendar-alt"></i> Jadwal Ujian Hari ini</h3>
                <div class='box-tools'>
                  <button class='btn btn-flat btn-primary'><span id='waktu' style="font-family:'OCR A Extended'"><?= $waktu ?> </span></button>
                </div>
              </div><!-- /.box-header -->
              <div class='box-body'>
                <!-- mryes untuk meanmpilkan jadwal pada halaman dashbor siswa -->
                <?php
                $id_siswa = $siswa['id_siswa'];
                $agamaSiswa = $siswa['agama'];
                $idKelas = $siswa['id_kelas'];
                $paketSoalSiswa = $siswa['soalPaket'];
                $mapelQ = $dbb->JadwalUjian($idpk, $level, $idsesi, $id_siswa, $agamaSiswa, $idKelas, $paketSoalSiswa);
                //var_dump($mapelQ);
                ?>
                <span class="btn btn-primary">Paket Anda <?= $paketSoalSiswa ?></span><br><br>
                <div class="table-responsive ">
                  <table class="table table-bordered">
                    <thead style="background-color: #337ab7;border-color:#337ab7;color:#fff;">
                      <tr>
                        <th>No</th>
                        <th>Aksi</th>
                        <th>Nama Ujian</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <style type="text/css">
                        .btn {
                          border-radius: 5px;
                          -webkit-box-shadow: none;
                          box-shadow: none;
                          border: 1px solid transparent;
                        }
                      </style>
                      <?php $no = 1;
                      foreach ($mapelQ as $dataUjian) { ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $dataUjian['tombol']; ?></td>
                          <td><b><?= $dataUjian['slagNama']; ?></b></td>
                          <td><label class="badge bg-blue"><?= $dataUjian['tgl_ujian']; ?></label></td>
                          <td><label class="badge bg-green"><?= $dataUjian['tgl_selesai']; ?></label></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <script>
            //tampilkan halaman Komfirmasi Untuk Ujian
            $(document).on('click', '.btnmulaitest', function() {
              var idm = $(this).data('id');
              var ids = $(this).data('ids');
              console.log(idm + '-' + ids);

              $.ajax({
                type: 'POST',
                url: 'konfirmasi.php',
                data: 'idm=' + idm + '&ids=' + ids,
                success: function(response) {
                  $('#formjadwalujian').hide();
                  $('#boxtampil').html(response).slideDown();

                }
              });

            });
          </script>
        <?php elseif ($pg == 'absen') : ?>
          <?php include "absen.php" ?>
        <?php elseif ($pg == 'absen_mapel') : ?>
          <?php include "absen_mapel.php" ?>
        <?php elseif ($pg == 'materi') : ?>
          <?php include "materi.php" ?>
        <?php elseif ($pg == 'pass') : ?>
          <?php include "pass.php" ?>
        <?php elseif ($pg == 'tugassiswa') : ?>
          <?php include "tugas.php" ?>
        <?php elseif ($pg == 'lihattugas') : ?>
          <?php include "lihattugas.php" ?>
        <?php elseif ($pg == 'daftarnilaitugas') : ?>
          <?php include "daftar_nilai_tugas.php" ?>
        <?php elseif ($pg == 'pengumuman') : ?>
          <?php include "pengumuman.php" ?>
        <?php elseif ($pg == 'lihathasil') : ?>
          <?php include "hlihathasil.php" ?>
        <?php elseif ($pg == 'hasil') : ?>
          <?php include "hhasil.php" ?>
          <!-- masuk ke soal tampilan soal -->
        <?php elseif ($pg == 'testongoing') : ?>
          <?php
          $qcek = mysqli_query($koneksi, "select * from nilai where id_ujian='$ac' and id_siswa='$id'");
          $cek = mysqli_num_rows($qcek);
          if ($cek <> 0) :
            $query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
            $idmapel = $query['id_mapel'];
            $jenisSoal = $query['jenisSoalUjian'];
            $id_mapel = $idmapel;

            $id_siswa = $id;

            // $where = array(
            //   'id_siswa' => $id_siswa,
            //   'id_mapel' => $id_mapel
            // );
            $where22 = array(
              'id_siswa' => $id_siswa,
              'id_mapel' => $id_mapel,
              'id_ujian' => $ac
            );
            $mapel = fetch($koneksi, 'ujian', array('id_mapel' => $id_mapel, 'id_ujian' => $ac));
            //$soal = fetch($koneksi, 'soal', array('id_mapel' => $id_mapel, 'id_soal' => $pengacak[$no_soal]));

            //$jawab = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $soal['id_soal'], 'id_ujian' => $ac));

            // update timer waktu ujian --------------
            update($koneksi, 'nilai', array('ujian_berlangsung' => $datetime), $where22);

            $nilai = fetch($koneksi, 'nilai', $where22);
            $habis = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);
            $detik = ($mapel['lama_ujian'] * 60) - $habis;
            $dtk = $detik % 60;
            $mnt = floor(($detik % 3600) / 60);
            $jam = floor(($detik % 86400) / 3600);
            $ujianselesai = $nilai['ujian_selesai'];
            $blokir = $nilai['blok'];
            $StatusDeteksi = $nilai['blokirStatus'];
            $idnilai = $nilai['id_nilai'];
            $AdminBukaBlokir = $nilai['blokBukaAdmin'];
            
            // update timer waktu ujian --------------

            if ($nilai['selesai'] == 1) { //jiksa sudah selesai atau selesai paksa di lempar ke home
              jump("$homeurl" . "/ujian");
            } else {
          ?>
              <!-- bagian ujian ------------------------------------------------------------>
              <div class='row' style='margin-right:-25px;margin-left:-25px;' id="appin" >
                <div class='col-md-12'>
                  <!--style="background-color: #0f0f17; color: #cccccc"-->
                  <div class='box box-solid' id="thema" style=" ">
                    <div class='box-header with-border'>
                      <style type="text/css">
                        .affix {
                          top: 50px;
                          position: fixed;
                          width: 100%;
                          background-color: white;
                          z-index: 777;
                        }
                      </style>

                      <div class="row">
                        <!-- data-spy="affix" data-offset-top="50" -->
                        <div class="col-md-12">
                          <table class="table">
                            <tr>
                              <td>
                                <div class="theme-switch-wrapper">
                                  <label class="theme-switch" for="checkbox">
                                    <input type="checkbox" id="checkbox" />
                                    <div class="slider round"></div>
                                  </label>
                                  <em id="modeag">Gelap / Terang</em>
                                </div>
                              </td>
                              <td>
                                <!--    -->
                                <button style="margin-left: 2px;" onclick="openFullscreen();" id="fullscreen"  class='btn btn-flat btn-primary'><i class="fa fa-expand "></i></button>
                              </td>
                              <td>
                                <div class='box-title pull-right'>
                                  <i class="fa fa-clock fa-lg hidden-xs "></i>
                                  <style type="text/css">
                                    .merah {
                                      color: red;
                                    }
                                  </style>
                                  <div id="waktu_ujian_user" class='btn-group'>
                                    <!-- waktu berjalan mryes -->
                                    <span style=" font-family:'OCR A Extended';font-size:35px" id='countdown'><span id='htmljam'><?= $jam ?></span>:<span id='htmlmnt'><?= $mnt ?></span>:<span id='htmldtk'><?= $dtk ?></span></span>
                                  </div>
                                  <div class='btn-group'>
                                    <!-- aksi tombol selesai ujian -->
                                    <input type='text' id="idnilai" name='idnilai' value="<?= $idnilai; ?>" style="display: none;" />
                                    <input type='text' id="siswaid" name='siswaid' value="<?= $_SESSION['id_siswa']; ?>" style="display: none;" />
                                    <input type='text' id="ujianid" name='ujianid' value="<?= $ac; ?>" style="display: none;" />
                                    <input type='text' id="jenissoalid" name='jenissoalid' value="<?= $jenisSoal; ?>" style="display: none;" />
                                    <input type='text' id="mapelid" name='mapelid' value="<?= $idmapel; ?>" style="display: none;" />
                                    <input type='submit' name='done' style="display: none;" id='done-submit' />
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <?php //-----Konfirmasi Selesai Ujian---- ?>
                        <?php
                          if($blokir ==1 ){ 
                            include "template/peringatan.php";
                            $hidenDiv = 'style="display: none;"';
                          }
                          else{
                            $hidenDiv='style="color: black;"';
                          }
                        ?>
                      <?php //-----End Konfirmasi Selesai Ujian---- ?>

                      <div id="laod_soal" <?php echo $hidenDiv; ?> >

                      </div>
                      <div id="modalPeringatan" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal"></button>
                              
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div style="color: black;">
                                    <span style="text-align:center;">
                                      <h3 class="modal-title" style="color: black;">
                                      <span id="pringatan" style="center; color: red;">PERINGATAN</span>
                                    </h3>
                                    </span>
                                    <center>
                                      <span id="peringataninfo1">
                                        SISTEM MENDETEKSI ANDA MELAKUKAN KECURANGAN <br>
                                        DENGAN MENINGGALAKAN HALAMAN UJIAN <BR>
                                        TETEP FOKUS PADA HALAMAN UJIAN ANDA <BR>
                                        APABILA ANDA MELAKUAKN KECURANGA SAMPAI 3 KALI <BR>
                                        ANDA AKAN DI BLOKIR OTOMATIS OLEH SISTEM <br>
                                        <br>
                                        <h4 id="peringatan_terakhir" style="color: black;"></h4>
                                      </span>
                                    </center>

                                  </div>
                                  <br><br>
                                  <center>
                                    <div id="peringataninfo2" style="color: black; text-align: center;"></div>
                                    <center>
                                      <br><br>
                                      <button type="button" id="btnpelanggaran" class="btn btn-danger" data-dismiss="modal">
                                        SIAP SAYA MENGERTI
                                      </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <script type="text/javascript">

                        <?php 
                        #bagian sistem blokir siswa otomatis 
                        if($StatusDeteksi == 1){ #cek jika fitu deteksi di aktifkan

                          if($blokir != 1 ){ #!=1
                          ?>
                          document.addEventListener('visibilitychange', function(event) {
                            if (document.hidden) {
                              console.log('user melanggar');
                                
                                var idnilai = $('#idnilai').val();
                                
                                $.ajax({
                                  type: 'POST',
                                  url: '../../c_jawaban.php?peringatan=count',
                                  data: {
                                    idnilai: idnilai,
                                    //ujianid: ujianid,
                                  },
                                  success: function(response) {
                                    console.log(response);
                                  }
                                });
                                var cek_war = localStorage.getItem("warning");
                                if(cek_war >= 3 ) {
                                  // var urlujian = '<?= $homeurl ?>'+'/ujian';
                                  // document.location.href = urlujian;
                                  $.ajax({
                                    type: 'POST',
                                    url: '../../c_jawaban.php?peringatan=warning',
                                    data: {
                                      idnilai: idnilai,
                                    },
                                    success: function(response) {
                                      console.log(response);
                                      location.reload();
                                    }
                                  });
                                  
                                }

                            } else {
                              $('#modalPeringatan').modal('show');
                              var cek_war = localStorage.getItem("warning");
                              var war = 1;
                              if (cek_war === "undefined" || cek_war === "null") {
                                localStorage.setItem("warning", war);
                                $('#peringataninfo2').html('INI PERINGATAN ANDA KE ' + war);
                              } else {
                                cek_war++;
                                localStorage.setItem("warning", cek_war);
                                $('#peringataninfo2').html('INI PERINGATAN ANDA KE ' + cek_war);
                                if(cek_war == 3){
                                  $('#peringatan_terakhir').html('INI PERINGATAN TERAKHIR UNTUK ANDA, MOHON UNTUK TETAP FOKUS TERHADAP UJIAN');
                                }
                                

                              }


                            }
                          });

                        <?php } } #bagian sistem blokir siswa otomatis ?>

                        $('#done-submit').click(function(e) {
                          e.preventDefault();
                          var siswaid = $('#siswaid').val();
                          var ujianid = $('#ujianid').val();
                          var mapelid = $('#mapelid').val();
                          var jenissoalid = $('#jenissoalid').val();
                          $.ajax({
                            type: 'POST',
                            url: '../../c_jawaban.php?jawaban=proses_nilai',
                            data: {
                              siswaid: siswaid,
                              ujianid: ujianid,
                              mapelid: mapelid,
                              jenissoalid: jenissoalid
                            },
                            success: function(response) {
                              console.log(response);
                              if (response == 1) {
                                toastr.success('Ujian Berhasil Di Selesaikan');
                                setTimeout(function() {
                                  window.location.replace(window.location.href + "/ujian");

                                }, 1000);
                                localStorage.clear();
                              } else if (response == 0) {
                                toastr.error('Gagal Update Nilai');
                              } else if (response == 99) {
                                toastr.error('Gagal Hapus Pengacak');
                              } else if (response == 90) {
                                toastr.error('Upsss Siswa Sudah Di Isi Nilainya');
                              } else {
                                toastr.error('Upsss Sistem');
                              }
                            }
                          });
                        });

                        function loadsoalpg(nosoal, jenis) {
                          $('#myModal').modal('hide');
                          let opsi = localStorage.getItem('opsi');
                          let jumlahsoal = localStorage.getItem('jumlahsoal');
                          let jumlahsoalesai = localStorage.getItem('jumlahsoalesai');
                          let idmapel = localStorage.getItem('idmapel');
                          let idsiswa = <?= $_SESSION['id_siswa']; ?>;
                          let jenissoal = localStorage.getItem('jenissoal');
                          let urutansoal = nosoal;
                          let homeurl = '<?= $homeurl ?>';
                          let idujian = '<?= $ac; ?>';
                          let modejawab = '<?= $setting['mode_jawab']; ?>';
                          let idNilai =$('#idnilai').val();

                          if (jenissoal == 1) {
                            var geturl = homeurl + '/soal.php';
                          } else if (jenissoal == 2) {
                            var geturl = homeurl + '/soalesai.php';
                          } else if (jenissoal == 3) {
                            var geturl = homeurl + '/soalpgesai.php';
                          } else {}
                          $.ajax({
                            type: 'POST',
                            url: geturl,
                            data: {
                              homeurl: homeurl,
                              opsi: opsi,
                              idmapel: idmapel,
                              idsiswa: idsiswa,
                              jumlahsoal: jumlahsoal,
                              urutansoal: urutansoal,
                              jenissoal: jenissoal,
                              homeurl: homeurl,
                              idujian: idujian,
                              modejawab: modejawab,
                              jumlahsoalesai: jumlahsoalesai,
                              idNilai: idNilai,
                            },

                            success: function(response) {
                              $('#laod_soal').html(response);
                              $('#myModal').modal('hide');
                              $(".modal-backdrop.in").hide();
                              //$('.modal-backdrop').remove();
                              document.getElementsByTagName("body")[0].style.overflowY = "auto";
                            }
                          });

                        };

                        <?php /*saat di refres tampilkan soal no 1 */ ?>
                        $(document).ready(function() {

                          let opsi = localStorage.getItem('opsi');
                          let jumlahsoal = localStorage.getItem('jumlahsoal');
                          let idmapel = localStorage.getItem('idmapel');
                          let jenissoal = localStorage.getItem('jenissoal');
                          let idsiswa = <?= $_SESSION['id_siswa']; ?>;
                          let urutansoal = 0;

                          let homeurl = '<?= $homeurl ?>';
                          let idujian = '<?= $ac; ?>';
                          let modejawab = '<?= $setting['mode_jawab']; ?>';
                          let idNilai =$('#idnilai').val();

                          if (jenissoal == 1) {
                            var geturl = homeurl + '/soal.php';
                          } else if (jenissoal == 2) {
                            var geturl = homeurl + '/soalesai.php';
                          } else if (jenissoal == 3) {
                            var geturl = homeurl + '/soalpgesai.php';
                          } else {
                            alert("Opsss Jenis Soal Tidak di Ketahui !!! ");
                          }

                          $.ajax({
                            type: 'POST',
                            url: geturl,
                            data: {
                              homeurl: homeurl,
                              opsi: opsi,
                              idmapel: idmapel,
                              idsiswa: idsiswa,
                              jumlahsoal: jumlahsoal,
                              urutansoal: urutansoal,
                              jenissoal: jenissoal,
                              homeurl: homeurl,
                              idujian: idujian,
                              modejawab: modejawab,
                              idNilai: idNilai,
                            },
                            success: function(response) {
                              $('#laod_soal').html(response);
                            }
                          });

                        });
                      </script>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end bagian ujian -------------------------------------------------------->
            <?php } ?>
          <?php else : ?>
            <?php jump($homeurl); ?>
          <?php endif; ?>
        <?php else : ?>
          <?php jump($homeurl); ?>
        <?php endif;  ?>

      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <footer class='main-footer hidden-xs' <?= $hilang; ?>>
      <div class='container'>
        <div class='pull-left hidden-xs'>
          <strong>
            <span id='end-sidebar'>
              &copy; 2020 <?= APLIKASI . " " . VERSI . " " . REVISI ?>
            </span>
          </strong>
        </div>
      </div>
    </footer>

    <footer class='footer hidden-lg' <?= $hilang; ?>>
      <style type="text/css">
        .btn {
          border-radius: 3px;
          -webkit-box-shadow: none;
          box-shadow: none;
          border: 1px solid transparent;
        }
      </style>
      <div class='pull-right hidden-lg' style="padding-right: 10px; padding-bottom: 5px;">
        <div class="text-center">
          <a href="<?= $homeurl ?>" class="btn btn-success"><i class="fa fa-home"></i> MENU</a>
        </div>
      </div>
      <div class='pull-left hidden-lg' style="padding-left: 10px; padding-bottom: 5px;">
        <div class="text-center">
          <a class="btn btn-success " onclick="location.reload();"><i class="fa fa-spinner fa-spin "></i> Refres</a>
        </div>
    </footer>


  </div><!-- ./wrapper -->



  <script src='<?= $homeurl ?>/dist/bootstrap/js/bootstrap.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/slimScroll/jquery.slimscroll.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/iCheck/icheck.min.js'></script>
  <script src='<?= $homeurl ?>/dist/js/app.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu.js'></script>
  <script src='<?= $homeurl ?>/plugins/mousetrap/mousetrap.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/MathJax-2.7.3/MathJax.js?config=TeX-AMS_HTML-full'></script>
  <script src='<?= $homeurl ?>/plugins/toastr/toastr.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/zoom-master/jquery.zoom.js'></script>

  <script>
    var url = window.location;
    $('ul.sidebar-menu a').filter(function() {
      return this.href == url;
    }).parent().addClass('active');
    // for treeview
    $('ul.treeview-menu a').filter(function() {
      return this.href == url;
    }).closest('.treeview').addClass('active');
    <?php
    if ($setting['izin_ujian'] == 1) {
    ?>

    <?php } else {
    } ?>
  </script>
  <?php if ($pg == 'testongoing') : ?>
    <?php //disabel tombol back history 
    ?>
    â€‹<script type="text/javascript">
      history.pushState(null, null, location.href);
      history.back();
      history.forward();
      window.onpopstate = function() {
        history.go(1);
      };

      var homeurl;
      homeurl = '<?= $homeurl ?>';


      /* Font Adjusments */
      let defaultFontSize = 16;
      let fontSize = 0;
      fontSize = localStorage.getItem('fontSize');
      if (!fontSize) {
        fontSize = defaultFontSize;
        localStorage.setItem('fontSize', fontSize);
      }
      soalFont(fontSize);

      function soalFont(fontSize) {
        $('div.soal > p > span').css({
          fontSize: fontSize + 'pt'
        });
        $('span.soal > p > span').css({
          fontSize: fontSize + 'pt'
        });
        $('.soal').css({
          fontSize: fontSize + 'pt'
        })
        $('.callout soal').css({
          fontSize: fontSize + 'pt'
        })
      }
    </script>
    <?php //Bagian Js Tombol Selesai dan Timer 
    ?>
    <script type="text/javascript">
      $(document).ready(function() {
        //cek dulu sebelum tekan tombol selesai
        //Tombol proses nilai ----
        $(document).on('click', '.done-btn', function() {
          let jenissoal = JSON.parse(localStorage.getItem("jenissoal"));
          let belum = [];
          let sudah = [];
          let belum1;
          let sudah1;
          if (jenissoal == 1) {
            var jawab_all2 = JSON.parse(localStorage.getItem("jwbs"));
          } else if (jenissoal == 2) {
            var jawab_all2 = JSON.parse(localStorage.getItem("jwbesai"));
          } else if (jenissoal == 3) {
            let jawab_all = JSON.parse(localStorage.getItem("jwbs"));
            let jawab_allesai = JSON.parse(localStorage.getItem("jwbesai"));
            var jawab_all2 = jawab_all.concat(jawab_allesai);
          } else {

          }

          jawab_all2.map(function(item, index) {
            if (item.status != 1) {
              belum++;
            } else {
              sudah++;
            }
            if (belum == "") {
              belum1 = 0;
            } else {
              belum1 = belum;
            }
            if (sudah == "") {
              sudah1 = 0;
            } else {
              sudah1 = sudah;
            }
          });
          swal({
            title: 'Apakah Kamu Yakin Ingin Menyelesaikan Ujian Ini ?',
            html: '<B>Pastikan Jawaban Sudah Terkirim Semua !</B><br>Jawaban Sudah Terkirim : <b style="color:blue;">' + sudah1 + '</b> Soal<br>Jawaban Belum Terkirim : <b style="color:red;">' + belum1 + '</b> Soal',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya'
          }).then((result) => {
            if (result.value) {
              window.onbeforeunload = null;
              let send = [];
              if (jenissoal == 1) {
                var jawabanall = JSON.parse(localStorage.getItem("jwbs"));
                var url_jawaban = 'kirim_jawaban';
              } else if (jenissoal == 2) {
                var jawabanall = JSON.parse(localStorage.getItem("jwbesai"));
                var url_jawaban = 'kirim_jawabanesai';
              } else if (jenissoal == 3) {
                let jawab_all = JSON.parse(localStorage.getItem("jwbs"));
                let jawab_allesai = JSON.parse(localStorage.getItem("jwbesai"));
                var jawabanall = jawab_all.concat(jawab_allesai);
                var url_jawaban = 'kirim_jawabanpgesai';
              } else {

              }

              jawabanall.map(function(item, index) {
                if (item.status != 1) {
                  send.push(item);
                }
              });
              $.ajax({
                type: 'POST',
                url: '../../c_jawaban.php?siswa=' + url_jawaban,
                data: {
                  nilai: send
                },
                beforeSend: function() {
                  $('#selesa_ujian').html('<i class="fa fa-spinner fa-spin "> </i>Loding');
                },
                success: function(response) {
                  $('#done-submit').click();
                }
              });

            }
          })

        });

        var jam = $('#htmljam').html();
        var menit = $('#htmlmnt').html();
        var detik = $('#htmldtk').html();

        function hitung() {
          setTimeout(hitung, 1000);
          $('#countdown').html(jam + ':' + menit + ':' + detik);
          detik--;
          if (detik < 0) {
            detik = 59;
            menit--;
            if (menit < 18) {
              $("#waktu_ujian_user").addClass("merah");
            }
            if (menit < 0) {
              menit = 59;
              jam--;
              if (jam < 0) {
                jam = 0;
                menit = 0;
                detik = 0;
                waktuhabis();
              }
            }
          }
        }
        hitung();
      });

      function cekwaktu() {
        $('#divujian').load(window.location.href + ' #divujian');
        var status = $('#htmlujianselesai').html();
        if (status != '') {
          location = homeurl;
        }
      }

      function waktuhabis() {

        swal({
          title: 'Oooo Oooww!',
          text: 'Waktu Ujian Telah Habis',
          timer: 1000,
          onOpen: () => {
            swal.showLoading()
          }
        }).then((result) => {
          let send = [];
          let jenissoal = JSON.parse(localStorage.getItem("jenissoal"));
          if (jenissoal == 1) {
            var jawabanall = JSON.parse(localStorage.getItem("jwbs"));
            var url_jawaban = 'kirim_jawaban';
          } else if (jenissoal == 2) {
            var jawabanall = JSON.parse(localStorage.getItem("jwbesai"));
            var url_jawaban = 'kirim_jawabanesai';
          } else if (jenissoal == 3) {
            let jawab_all = JSON.parse(localStorage.getItem("jwbs"));
            let jawab_allesai = JSON.parse(localStorage.getItem("jwbesai"));
            var jawabanall = jawab_all.concat(jawab_allesai);
            var url_jawaban = 'kirim_jawabanpgesai';
          } else {

          }
          jawabanall.map(function(item, index) {
            if (item.status != 1) {
              send.push(item);
            }
          });
          $.ajax({
            type: 'POST',
            url: '../../c_jawaban.php?siswa=' + url_jawaban,
            data: {
              nilai: send
            },
            beforeSend: function() {
              $('#finis').html('<i class="fa fa-spinner fa-spin "> </i>Loding');
            },
            success: function(response) {
              console.log(response);
              $('#done-submit').click();
            }
          });

        });
      }
    </script>
    <?php //----------Timer Waktu tombol selesai muncul -------- 
    ?>
    <script type="text/javascript">
      $(document).ready(function() {
        if ("counter" in sessionStorage) {
          if (sessionStorage.getItem("counter") === null || sessionStorage.getItem("counter") === 'NaN' || localStorage.getItem("counter") == 'undefined') {
            $(".done-btn").removeAttr("disabled");
            clearInterval(interval);
          }
        }

        let counter = function() {
          let value = sessionStorage.getItem("counter");
          value2 = parseInt(value);
          if (value == 0) {
            $(".done-btn").removeAttr("disabled");
            clearInterval(interval);
          } else {
            value3 = value2 - 1;
            sessionStorage.setItem("counter", value3);
            let x = value3 % 3600;
            let jam = Math.floor(value3 / 3600);
            let menit = Math.floor(x / 60);
            let detik = Math.floor(x % 60);

            $("#divCounter").html(jam + ' Jam ' + menit + ' Menit ' + detik + ' Detik');
          }

        }
        var interval = setInterval(counter, 1000);
      });
    </script>
    <?php //----------Timer Waktu tombol selesai muncul -------- 
    ?>
    <?php //-------kirim Jawaban Otomatis ---------------- 
    ?>
    <script type="text/javascript">
      $(document).ready(function() {
        setInterval(function() {
          let send = [];
          let jenissoal = JSON.parse(localStorage.getItem("jenissoal"));
          if (jenissoal == 1) {
            var jawabanall = JSON.parse(localStorage.getItem("jwbs"));
            var url_jawaban = 'kirim_jawaban';
          } else if (jenissoal == 2) {
            var jawabanall = JSON.parse(localStorage.getItem("jwbesai"));
            var url_jawaban = 'kirim_jawabanesai';
          } else if (jenissoal == 3) {
            let jawab_all = JSON.parse(localStorage.getItem("jwbs"));
            let jawab_allesai = JSON.parse(localStorage.getItem("jwbesai"));
            var jawabanall = jawab_all.concat(jawab_allesai);
            var url_jawaban = 'kirim_jawabanpgesai';
          } else {}
          if (jawabanall.length > 0) {
            jawabanall.map(function(item, index) {
              if (item.status == 0) {
                send.push(item);
              }
            });
            $.ajax({
              type: 'POST',
              url: '../../c_jawaban.php?siswa=' + url_jawaban,
              data: {
                nilai: send
              },

              success: function(response) {
                console.log(response);

                function get(item) {
                  return JSON.parse(localStorage.getItem(item));
                }

                function getPanjang(item) {
                  return JSON.parse(localStorage.getItem(item)).length;
                }
                if (response == 1) {
                  // tantai jawaban pg sudah di kirim ------------------- 
                  let jawab_all2 = JSON.parse(localStorage.getItem("jwbs"));
                  let jawaban_ganti = [];
                  let jawaban_ganti2 = [];
                  let gabung = [];
                  let arr = [];
                  let arr2 = [];
                  let jwb = getPanjang('jwbs');
                  if (jwb > 0) {
                    jawab_all2.map(function(item, index) {
                      if (item.status != 1) {
                        arr = {
                          "idsoal": item.idsoal,
                          "jawaban": item.jawaban,
                          "status": 1,
                          "idsiswa": item.idsiswa,
                          "idmapel": item.idmapel,
                          "idujian": item.idujian,
                          "jenissoal": item.jenissoal
                        };
                        jawaban_ganti.push(arr);
                      } else {
                        arr2 = item;
                        jawaban_ganti2.push(arr2);
                      }
                    });
                    gabung = jawaban_ganti.concat(jawaban_ganti2);
                    localStorage.setItem('jwbs', JSON.stringify(gabung));
                  }

                  // tantai jawaban esai sudah di kirim  -------------------
                  let otojawabesai = JSON.parse(localStorage.getItem("jwbesai"));
                  let otojwbesai = getPanjang('jwbesai');
                  let otojawaban_ganti = [];
                  let otojawaban_ganti2 = [];
                  let otogabung = [];
                  let otoarr = [];
                  let otoarr2 = [];
                  if (otojwbesai > 0) {
                    otojawabesai.map(function(item, index) {
                      if (item.status != 1) {
                        arr = {
                          "idsoal": item.idsoal,
                          "jawaban": item.jawaban,
                          "status": 1,
                          "idsiswa": item.idsiswa,
                          "idmapel": item.idmapel,
                          "idujian": item.idujian,
                          "jenissoal": item.jenissoal
                        };
                        otojawaban_ganti.push(arr);
                      } else {
                        otoarr2 = item;
                        otojawaban_ganti2.push(otoarr2);
                      }
                    });
                    otogabung = otojawaban_ganti.concat(otojawaban_ganti2);
                    localStorage.setItem('jwbesai', JSON.stringify(otogabung));
                  }

                } else {

                }
              }
            });
          } else {
            console.log("kosong");
          }

        }, 300000);
        //30000 = 30 detik, 300000 = 5 menit, 3000 = 3 detik, 60000 = 1 Menit
      });

      
    </script>
    <?php //-------kirim Jawaban Otomatis ---------------- 
    ?>

  <?php endif; ?>
</body>

</html>