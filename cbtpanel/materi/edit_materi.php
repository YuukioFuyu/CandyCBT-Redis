<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
//setting up one redis-----------------------------------------
require "../../vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------

cek_session_guru();

//print_r($_POST);
// print_r($_FILES);
$id = $_POST['id'];
//$mapel = addslashes($_POST['mapel']);

if(empty($_POST['idguru'])){ $id_guru = $_SESSION['id_pengawas']; }else{ $id_guru =$_POST['idguru']; }

$isimateri = addslashes($_POST['isimateri']);
$judul = addslashes($_POST['judul_materi']);
$kelas = serialize($_POST['kelas']);

$gdrive=$_POST['gdrive']; 
$youtube=$_POST['youtube']; 
$idyoutube=$_POST['idyoutube'];
$tgl_rilis = $_POST['tgl_rilis'];

$path2= '../../'.$linkguru.'/berkas2/'.$id_guru;
if (!file_exists($path2)) {
   mkdir($path2, 0755, true);
}

$ektensi = ['jpg', 'png','xlsx','pdf','docx','doc','xls','ppt','pptx'];
if ($_FILES['file_materi']['name'] <> '') {
   $file = str_replace(" ","_",$_FILES['file_materi']['name']);
   $temp = $_FILES['file_materi']['tmp_name'];
   $ext = explode('.', $file);
   $ext = end($ext);
   if (in_array($ext, $ektensi)) {
      $dest = '../../'.$linkguru.'/berkas2/'.$id_guru.'/';
      $path = $dest . $file;
      $upload = move_uploaded_file($temp, $path);
      if ($upload) {
         $data = array(
            //'materi2_mapel' => $mapel,
            'kelas' => $kelas,
            'id_guru' => $id_guru,
            'materi2_judul' => $judul,
            'materi2_isi' => $isimateri,
            'materi2_file' => $file,
            'url_gdrive' => $gdrive,
            'url_youtube' => $youtube,
            'url_embed' =>$idyoutube,
            'materi2_tgl_rilis' =>$tgl_rilis,
         );
         $cek = update($koneksi, 'materi2', $data, ['materi2_id' => $id]);
         try { $Redis->del("baca_materi".$id); }
         catch (Exception $e) { } 
         if($cek=='OK'){
             echo "ok";
         }
        
      } else {
         echo "gagal";
      }
   }
} else {
   $data = array(
      //'materi2_mapel' => $mapel,
      'kelas' => $kelas,
      'id_guru' => $id_guru,
      'materi2_judul' => $judul,
      'materi2_isi' => $isimateri,
      'url_gdrive' => $gdrive,
      'url_youtube' => $youtube,
      'url_embed' =>$idyoutube,
      'materi2_tgl_rilis' =>$tgl_rilis,
   );
   $cek = update($koneksi, 'materi2', $data, ['materi2_id' => $id]);
   try { $Redis->del("baca_materi".$id); }catch (Exception $e) { } 
   if($cek=='OK'){
     echo "ok";
  }
   
}
