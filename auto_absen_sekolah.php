<?php

require("config/config.function.php");
require("config/functions.crud.php");
require("config/m_siswa.php");
$dbb= new Siswa(); 


  
  // $jamsekolah2 = $dbb->getJamSekolah();
  // //date_default_timezone_set('Asia/Jakarta');
  // $tgl = date("Y-m-d",strtotime($_POST['tgl']));
  // $jamsekolah2['jamAlpah'];


  // $data = array(
  //   'absIdSiswa' => $idsiswa,
  //   'absIdKelas' => $idkls,
  //   'absTgl' => $tgl,
  //   'absJamIn' => $jamin,
  //   'absJamOut' => $jamout,
  //   'absStatus' => $status_absen,
  //   'absJenis' => 1,
  // );
  // $cek = fetch($koneksi, 'absensi', array('absTgl' => $tgl, 'absIdSiswa' =>$idsiswa));
  // if(count($cek) > 0){
  //   echo 99;
  // }
  // else{
  //  $exc = insert($koneksi,'absensi',$data);
  //  if($exc =='OK'){
  //   echo 1;
  //  }
  //  else{
  //   echo 0;
  //  }
  // }
  $daftar_hari = array(
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
   );
  $tgl = date("Y-m-d");
  $jamAlpah = date("00:00");
  $namaHari = date("l",strtotime($tgl));
  $hariIndo = $daftar_hari[$namaHari];
  
  if($hariIndo == "Minggu" ){

  }
  else{

 
    $no=0;
    $getSiswa = $dbb->v_siswa2();
    foreach ($getSiswa as $siswa) {
      $idsiswa = $siswa['id_siswa'];
      $cekKelas = fetch($koneksi, 'kelas', array('id_kelas' => $siswa['id_kelas']));
      $cekAbsen = fetch($koneksi, 'absensi', array('absTgl' => $tgl, 'absIdSiswa' =>$idsiswa));
      if(count($cekAbsen) > 0){ }
      else{
        $data = array(
          'absIdSiswa' => $idsiswa,
          'absIdKelas' => $cekKelas['idkls'],
          'absTgl' => $tgl,
          'absJamIn' => $jamAlpah,
          'absJamOut' => $jamAlpah,
          'absStatus' =>'A',
          'absJenis' => 3,
        );
        $exc = insert($koneksi,'absensi',$data);
        $no++;
        
      }

    }
    if($exc){
          echo"Data Sudah Di Tambahkan Pada Hari ".$hariIndo;
        }
  
 
 ?>



    <?php 
    //bagian boot rekap absen sekolah
    $TokenTelegram2 ="xxxxxxxxxxxxxxxxxxxxxxxxxxx"; //token bot telegram
    $idGrubTeleku2 = "xxxxxxxxxxxxxxxxx"; //id grup telegram
    $message="<b><i>Cron Job Absensi Sekolah</i></b>\\n";
    $message.="<b>Berhasil di Lakukan Oleh Sistem</b>\\n";
    $message.="Jumlah Data di Proses <b>".$no."</b> Data Absensi Sekolah\\n";

    ?> 

    <html>
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script type="text/javascript">
      $(document).ready(function() {
      var settings2 = {
          "async": true,
          "crossDomain": true,
          "url": "https://api.telegram.org/bot<?= $TokenTelegram2; ?>/sendMessage",
          "method": "POST",
          "headers": {
          "Content-Type": "application/json",
          "cache-control": "no-cache"
        },
        "data": JSON.stringify({
        "chat_id": "<?= $idGrubTeleku2; ?>",
        "text": "<?= $message; ?>",
        "parse_mode":"HTML",
        })
        }
    

        $.ajax(settings2).done(); 
      });
      </script>

    </head>

    </html>
<?php } ?>