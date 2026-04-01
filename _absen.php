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
  

  function habist($jam_siswa_masuk,$jam_siswa_pulang,$jamsekolah_masuk,$jamsekolah_pulang,$jamsekolah_alpa,$jamsekolah_terlambat)
  {
    $jam_masuk = strtotime(date($jamsekolah_masuk));
    $jam_pulang = strtotime(date($jamsekolah_pulang));
    $jam_alpha=strtotime(date($jamsekolah_alpa));
    $jam_telat=strtotime(date($jamsekolah_terlambat));
    if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_masuk < $jam_telat and $jam_siswa_pulang >= $jam_pulang){
      $status = 'H'; //Hadir
    }
    else if($jam_siswa_masuk > $jam_masuk and $jam_siswa_masuk < $jam_telat and $jam_siswa_pulang >= $jam_pulang){
      $status = 'H'; //Hadir=
    }
    else if($jam_siswa_masuk >= $jam_masuk and $jam_siswa_masuk == $jam_telat and $jam_siswa_pulang >= $jam_pulang){
      $status = 'T'; //Hadir
    }
    //-----
    else if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_masuk > $jam_telat OR $jam_siswa_masuk == $jam_telat  and $jam_siswa_pulang == $jam_pulang){
      $status = 'A'; //Hadir
    }
    else if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_masuk > $jam_telat OR $jam_siswa_masuk == $jam_telat  and $jam_siswa_pulang >= $jam_pulang){
      $status = 'T'; //Hadir
    }
    else if($jam_siswa_masuk >= $jam_masuk and $jam_siswa_masuk > $jam_telat and $jam_siswa_pulang >= $jam_pulang){
      $status = 'T'; //Hadir
    }
    //-----
    else if($jam_siswa_masuk >= $jam_masuk and $jam_siswa_masuk > $jam_telat and $jam_siswa_pulang == $jam_pulang){
      $status = 'T'; //Hadir
    }
    else if($jam_siswa_masuk == $jam_alpha and $jam_siswa_pulang == $jam_alpha){
      $status = 'A'; //Hadir
    }
    else if($jam_siswa_masuk >= $jam_masuk and $jam_siswa_masuk > $jam_telat and $jam_siswa_pulang < $jam_pulang){
      $status = 'B'; //Hadir
    }
     else if($jam_siswa_masuk >= $jam_masuk and $jam_siswa_masuk > $jam_telat and $jam_siswa_pulang < $jam_pulang){
      $status = 'B'; //Hadir
    }
    else if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_masuk > $jam_telat and $jam_siswa_pulang < $jam_pulang){
      $status = 'B'; //Hadir
    }
    else if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_masuk >= $jam_telat and $jam_siswa_pulang < $jam_pulang){
      $status = 'B'; //Hadir
    }
    else{
      $status='L';
    }

          //   if($jam_siswa_masuk == $jam_alpha and $jam_siswa_pulang == $jam_alpha){
          //     $status = 'A'; //alpha
          //   }
          //   else if($jam_siswa_masuk == $jam_alpha and $jam_siswa_pulang >= $jam_pulang){
          //     $status = 'T'; //terlambar
          //   }
          //   else if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_pulang == $jam_alpha){
          //     $status = 'B'; //bolos
          //   }
          //   else if($jam_siswa_masuk > $jam_masuk and $jam_siswa_pulang == $jam_alpha){
          //     $status = 'B'; //bolos
          //   }
          //   else if($jam_siswa_masuk > $jam_masuk and $jam_siswa_pulang >= $jam_pulang){
          //     $status = 'T'; //terlambar
          //   }
          //   else if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_pulang < $jam_pulang){
          //     $status = 'B'; //terlambar
          //   }
          //   else if($jam_siswa_masuk > $jam_masuk and $jam_siswa_pulang < $jam_pulang){
          //     $status = 'T'; //terlambar
          //   }
          //   else if($jam_siswa_masuk <= $jam_masuk and $jam_siswa_pulang >= $jam_pulang){
          //   $status = 'H'; //Hadir
          // }
          // else{ }

    return $status;
  }
  $jamsekolah2 = $dbb->getJamSekolah();
  //date_default_timezone_set('Asia/Jakarta');
  $tgl = date("Y-m-d",strtotime($_POST['tgl']));
  $idsiswa = $_POST['idsiswa'];
  $idkls = $_POST['idkls'];
  $jamin = date("H:i"); //mencatat jam masuk siswa automatis
  //$jamin = date("07:00");
  //$jamout= date($jamsekolah2['jamOut']); //mencatat jam pulang  
  //$jamout= date("H:i"); //mencatat jam pulang  

  //random jam pulang ---------------------------------------------
  $randomJam = "13";

  //random menit dari 10 sampai 59
  //jika jam pulang 13.30
  //makan ganti angka 10 menjadi 30
  $randomMenit = rand( 10, 59 );

  //random detik dari 10 sampai 59
  $randomDetik = rand( 10, 59 );

  $jamout= $randomJam.":".$randomMenit.":".$randomDetik;

  //random jam pulang ---------------------------------------------


  $status_absen = habist(strtotime($jamin),strtotime($jamout),$jamsekolah2['jamIn'],$jamsekolah2['jamOut'],$jamsekolah2['jamAlpah'],$jamsekolah2['jamTerlambat']);
  $data = array(
    'absIdSiswa' => $idsiswa,
    'absIdKelas' => $idkls,
    'absTgl' => $tgl,
    'absJamIn' => $jamin,
    'absJamOut' => $jamout,
    'absStatus' => $status_absen,
    'absJenis' => 1,
  );
  $cek = fetch($koneksi, 'absensi', array('absTgl' => $tgl, 'absIdSiswa' =>$idsiswa));
  $token_bot = fetch($koneksi, "bot_telegram"); 
  if(count($cek) > 0){
    echo 99;
  }
  else{
   $exc = insert($koneksi,'absensi',$data);
   if($exc =='OK'){
    echo 1;
   }
   else{
    echo 0;
   }
  }
 
 
}
