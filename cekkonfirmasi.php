
<?php
require("config/config.login_siswa.php");
require("config/config.function.php");
require("config/functions.crud.php");

if($token == $token1) {

$ac = $_POST['idm'];
$id_siswa = $_POST['ids'];
$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
$idmapel = $query['id_mapel'];

if($query['status_reset']==1){ $reset=1; } //jika status reset di ujian aktif
else{ $reset=0; }

if ($query['token'] == 1) :
  $token = $_POST['token'];
  $tokencek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT token FROM token"));
  if ($token == $tokencek['token']) :

    $query = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$idmapel' AND id_siswa='$id_siswa' AND id_ujian='$ac'");
    $nilaix = mysqli_fetch_array($query);
    $ceknilai = mysqli_num_rows($query);
    if ($ceknilai <> 0) :
      if ($nilaix['ujian_selesai'] == '') :
              //jika lanjut
        include_once("aturanlanjut.php");
                // mysqli_query($koneksi, "UPDATE nilai set online='$reset' where id_mapel='$idmapel' AND id_siswa='$id_siswa' AND id_ujian='$ac'");
        jump("$homeurl/testongoing/$ac/$id_siswa");
      endif;
    else :
      include_once("aturan.php");
      jump("$homeurl/testongoing/$ac/$id_siswa");
    endif;
  else :
    echo "Kode Token Salah";
  endif;
else :
  $query = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$idmapel' AND id_siswa='$id_siswa' AND id_ujian='$ac'");
  $nilaix = mysqli_fetch_array($query);
  $ceknilai = mysqli_num_rows($query);
  if ($ceknilai <> 0) {
    if ($nilaix['ujian_selesai'] == '') :
            //jika lanjut
      include_once("aturanlanjut.php");
            // mysqli_query($koneksi, "UPDATE nilai set online='$reset' where id_mapel='$idmapel' AND id_siswa='$id_siswa' AND id_ujian='$ac'");
      jump("$homeurl/testongoing/$ac/$id_siswa");
    endif;
  } else {
    include_once("aturan.php");
    jump("$homeurl/testongoing/$ac/$id_siswa");
  }
endif;
?>
<?php 
}
else{
    jump("$homeurl");
    //exit;
}

?>
