<?php
require '../config/config.default.php';
require '../config/config.redis_load.php';
$db = new RedisBudut();
$kodeSkl = $db->KodeSekolah();
$db->RedisDelKey('setting'.$kodeSkl);

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;

if($_GET['setting'] =='ganti'){
  // var_dump($_POST);
  $exec = mysqli_query($koneksi, "UPDATE setting set catat_login='$_POST[data]' where id_setting=$_POST[id]");
  if ($exec==true) {
    echo 1;
  }
}
else if ($_GET['setting'] =='mode_jawab') {
  $exec = mysqli_query($koneksi, "UPDATE setting set mode_jawab='$_POST[data]' where id_setting=$_POST[id]");
  if ($exec==true) {
    echo 1;
  }
}
  else if ($_GET['key'] <> '1616161616') {
    echo "script tidak bisa diakses";
  } 
  else {

    foreach ($_POST['ujian'] as $ujian) {
      if ($_POST['aksi'] <> 'hapus') {
        $exec = mysqli_query($koneksi, "UPDATE ujian set status='$_POST[aksi]',sesi='$_POST[sesi]' where id_ujian='$ujian'");
        if ($exec) {
          echo "update";
        }
      } else {
        $exec = mysqli_query($koneksi, "DELETE from ujian where id_ujian='$ujian'");
        if ($exec) {
          echo "hapus";
        }
      }
    }
  }

