<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
   ($id_pengawas==0) ? header('location:index.php'):null;


   $post = $_POST;
   
   $id_ujian=$post['id_ujian'];
   $sesi = $post['sesi'];
   $ruang = $post['ruang'];
   $kode_ujian = $post['kode_ujian'];
   $mulai = $post['mulai'];
   $selesai = $post['selesai'];

   $nama_proktor = $post['nama_proktor'];
   $nip_proktor = $post['nip_proktor'];
   $nama_pengawas = $post['nama_pengawas'];
   $nip_pengawas = $post['nip_pengawas'];
   $catatan = $post['catatan'];
   $tgl_ujian = $post['tgl_ujian'];


   $data = array(
      'id_mapel' => $id_ujian,
      'sesi' => $sesi,
      'ruang' => $ruang,
      'jenis' => $kode_ujian,
      'mulai' => $mulai,
      'selesai' => $selesai,
      'nama_proktor' => $nama_proktor,
      'nip_proktor' => $nip_proktor,
      'nama_pengawas' => $nama_pengawas,
      'nip_pengawas' => $nip_pengawas,
      'catatan' => $catatan,
      'tgl_ujian' => $tgl_ujian
   );
   $tabel ='berita';
   $cek = insert($koneksi,$tabel,$data);

   if($cek==true){
      echo "oke";
   }
   else{
      echo"no";
   }

?>