<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");


cek_session_guru();

$id_mapel = $_POST['id_mapel'];
$id_guru = $_SESSION['id_pengawas'];
$materi = $_POST['materi'];
$judul = $_POST['judul'];
$tgl_rilis = $_POST['tgl_rilis'];

$path= '../../berkas/'.$id_guru;
if (!file_exists($path)) {
   mkdir($path, 0755, true);
}

$ektensi = ['jpg', 'png','xlsx','pdf','docx','doc','xls','ppt','pptx'];
if ($_FILES['file']['name'] <> '') {
   $file = $_FILES['file']['name'];
   $temp = $_FILES['file']['tmp_name'];
   $ext = explode('.', $file);
   $ext = end($ext);
   if (in_array($ext, $ektensi)) {
      $dest = '../../berkas/'.$id_guru.'/';
      $path = $dest . $file;
      $upload = move_uploaded_file($temp, $path);
      if ($upload) {
         $data = array(
            'id_mapel' => $id_mapel,
            'idguru' => $id_guru,
            'judul' => $judul,
            'materi' => $materi,
            'file' => $file,
            'materi2_tgl_rilis' =>$tgl_rilis,
         );
         insert($koneksi, 'materi', $data);
         echo "ok";
      } else {
         echo "gagal";
      }
   }
} else {
   $data = array(
      'id_mapel' => $id_mapel,
      'idguru' => $id_guru,
      'judul' => $judul,
      'materi' => $materi,
      'materi2_tgl_rilis' =>$tgl_rilis,
   );
   insert($koneksi, 'materi', $data);
   echo "ok";
}
