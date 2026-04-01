<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");

cek_session_guru();

$id_mapel = addslashes($_POST['mapel']);
// $id_guru = $_SESSION['id_pengawas'];
if(empty($_POST['idguru'])){ $id_guru = $_SESSION['id_pengawas']; }else{ $id_guru =$_POST['idguru']; }
$tugas = addslashes($_POST['isitugas']);
$judul = addslashes($_POST['judul']);
$tgl_mulai = $_POST['tgl_mulai'];
$tgl_selesai = $_POST['tgl_selesai'];
$kelas = serialize($_POST['kelas']);
$kode_level = $_POST['idlevel'];



$path2= '../../'.$linkguru.'/tugas/'.$id_guru;

// if (!mkdir($path, 0755, true)) {
//     die('Failed to create folders...');
// }
// else{
//   mkdir($path, 0755, true);
// }
if (!file_exists($path2)) {
   mkdir($path2, 0755, true);
}

$ektensi = ['jpg', 'png','xlsx','pdf','docx','doc','xls','ppt','pptx'];
if ($_FILES['file']['name'] <> '') {
   $file = str_replace(" ","_",$_FILES['file']['name']);
   $temp = $_FILES['file']['tmp_name'];
   $ext = explode('.', $file);
   $ext = end($ext);
   if (in_array($ext, $ektensi)) {
      $dest = '../../'.$linkguru.'/tugas/'.$id_guru.'/';
      $path = $dest . $file;
      $upload = move_uploaded_file($temp, $path);
      if ($upload) {
         $data = array(
            'mapel' => strtoupper($id_mapel),
            'kelas' => $kelas,
            'id_guru' => $id_guru,
            'judul' => strtoupper($judul),
            'tugas' => $tugas,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'file' => $file,
            'kode_level' =>$kode_level,
            
         );
         insert($koneksi, 'tugas', $data);
         echo "ok";
      } else {
         echo "gagal";
      }
   }
} else {
   $data = array(
      'mapel' => strtoupper($id_mapel),
      'kelas' => $kelas,
      'id_guru' => $id_guru,
      'judul' => strtoupper($judul),
      'tugas' => $tugas,
      'tgl_mulai' => $tgl_mulai,
      'tgl_selesai' => $tgl_selesai,
      'kode_level' =>$kode_level,
      
   );
   insert($koneksi, 'tugas', $data);
   echo "ok";
}
