<?php

require("config/config.function.php");
require("config/functions.crud.php");
include("core/c_user.php"); 
//absen jenis pada tabel databse absensi
//1 untuk absen 
//2 untuk edit sakit izin alpah
if(!isset($_SESSION['id_siswa'])){
  header('location:logout.php');
}else{
  
  //print_r($_POST);
  $jamin = date("H:i");
  $tgl = date("Y-m-d",strtotime($_POST['tgl']));
  $data = array(
    'amaIdAbsenMapel' =>$_POST['idam'],
    'amaIdSiswa' =>$_POST['idsiswa'],
    'amaIdKelas' =>$_POST['idkelas'],
    'amaIdMapel' =>$_POST['idmapel'],
    'amaTgl' =>$tgl,
    'amaJamIn' =>$jamin,
    'amaStatus' =>'H',

  );
  $cek = fetch($koneksi, 'absensi_mapel_anggota', array('amaTgl' => $tgl, 'amaIdSiswa' =>$_POST['idsiswa'], 'amaIdMapel'=>$_POST['idmapel']));

  if(count($cek) > 0){
    echo 99;
  }
  else{
   $exc = insert($koneksi,'absensi_mapel_anggota',$data);
   if($exc =='OK'){
    echo 1;
      
   }
   else{
    echo 0;
   }
  }

 
 
 
}
