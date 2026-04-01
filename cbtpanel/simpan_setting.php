<?php
include("core/c_admin.php"); 
if($token == $token1) {

  (isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
      ($id_pengawas==0) ? header('location:index.php'):null;
?>



<?php
  $alamat = nl2br($_POST['alamat']);
  $header = nl2br($_POST['header']);



  if(!empty($_POST['db_token'])){ $token  = $_POST['db_token']; }else{ $db_token =null; }
  if(!empty($_POST['db_token1'])){ $token1  = $_POST['db_token1']; }else{ $db_token1 =null; }



  $protek = !empty($_POST['protek']) ? $_POST['protek'] : 0;
  $nip_protek = !empty($_POST['nip_protek']) ? $_POST['nip_protek'] : 0;
  $izin_pass = !empty($_POST['izin_pass']) ? $_POST['izin_pass'] : 0;
  $izin_materi = !empty($_POST['izin_materi']) ? $_POST['izin_materi'] : 0;
  $izin_tugas = !empty($_POST['izin_tugas']) ? $_POST['izin_tugas'] : 0;
  $izin_info = !empty($_POST['izin_info']) ? $_POST['izin_info'] : 0;
  $izin_ujian = !empty($_POST['izin_ujian']) ? $_POST['izin_ujian'] : 0;
  $izin_absen = !empty($_POST['izin_absen']) ? $_POST['izin_absen'] : 0;
  $izin_absen_mapel = !empty($_POST['izin_absen_mapel']) ? $_POST['izin_absen_mapel'] : 0;
  $pjj = !empty($_POST['pjj']) ? $_POST['pjj'] : 0;
  $izi_foto_absen = !empty($_POST['izi_foto_absen']) ? $_POST['izi_foto_absen'] : 0;
  $mainten = !empty($_POST['mainten']) ? $_POST['mainten'] : 0;

  $folder_baru = !empty($_POST['folder_baru']) ? $_POST['folder_baru'] : 0;
  $judul_pesan = !empty($_POST['judul_pesan']) ? $_POST['judul_pesan'] : 0;
  $isi_pesan = !empty($_POST['isi_pesan']) ? $_POST['isi_pesan'] : 0;
  $lisensi = !empty($_POST['serial']) ? $_POST['serial'] : 0;
  $namaSekolah = !empty($_POST['namasekolah']) ? $_POST['namasekolah'] : 0;
  $izin_sinkron = !empty($_POST['izin_sinkron']) ? $_POST['izin_sinkron'] : 0; 
  $izin_status = !empty($_POST['cek']) ? $_POST['cek'] : 0; 
  $elerning = !empty($_POST['elerning']) ? $_POST['elerning'] : 0;

  //mryes
  if(!empty($_POST['aplikasi'])){ $apliaksi = $_POST['aplikasi']; }else{ $apliaksi=null; }
  if(!empty($_POST['sekolah'])){ $sekolah = $_POST['sekolah']; }else{ $sekolah=null; }
  if(!empty($_POST['kode'])){ $kode_skl = $_POST['kode']; }else{ $kode_skl=null; }
  if(!empty($_POST['jenjang'])){ $jenjang = $_POST['jenjang']; }else{ $jenjang=null; }

  if($sekolah==null and $apliaksi==null and $kode_skl==null and $jenjang==null){
    echo"Cek Lagi Datanya ";
  }
  else{
    $data = array(
      'server'            =>$_POST['status_server'],
      'aplikasi'          =>$_POST['aplikasi'],
      'sekolah'           =>$_POST['sekolah'],
      'kode_sekolah'      =>$_POST['kode'],
      'jenjang'           =>$_POST['jenjang'],
      'kepsek'            =>$_POST['kepsek'],
      'nip'               =>$_POST['nip'],
      'alamat'            =>$alamat,
      'kecamatan'         =>$_POST['kec1'],
      'kota'              =>$_POST['kab1'],
      'telp'              =>$_POST['telp'],
      'fax'               =>$_POST['fax'],
      'web'               =>$_POST['web'],
      'email'             =>$_POST['email'],
      'header'            =>$header,
      'ip_server'         =>$_POST['ipserver'],
      'waktu'             =>$_POST['waktu'],
      'db_token'          =>$token,
      'db_token1'         =>$token1,
      'protek'            =>$protek,
      'nip_protek'        =>$nip_protek,
      'izin_pass'         =>$izin_pass,
      'izin_materi'       =>$izin_materi,
      'izin_tugas'        =>$izin_tugas,
      'izin_ujian'        =>$izin_ujian,
      'izin_absen'        =>$izin_absen,
      'izin_info'         =>$izin_info,
      'izin_absen_mapel'  =>$izin_absen_mapel,
      'izi_foto_absen'    =>$izi_foto_absen,
      'izin_status'       =>$izin_status,
      'izin_sinkron'      =>$izin_sinkron,
      'folder_admin'      =>$folder_baru,
      'namapjj'           =>$pjj,
      'LoginSiswaMainten' =>$mainten,
      'elerning'          =>$elerning,
      'IsiPesanSingkat'   =>$isi_pesan,
      'JudulPesanSingkat' =>$judul_pesan,
      'lisensiId'         =>$lisensi,
      'namaSekolah'       =>$namaSekolah,
    );
    $where = array(
      'id_setting'        =>1
    );
    $update = $db->update('setting',$data,$where);
  }
  ?>




  <?php
  if ($update) {
      echo 1;
      $extensionList = ['png','jpg','jpeg'];

      if ($_FILES['logo']['name'] <> '') {
            
              $logo = $_FILES['logo']['name'];
              $temp = $_FILES['logo']['tmp_name'];
              $ext1 = explode('.', $logo);
              $ext = end($ext1);

              $ekstensi = $ext1[1]; //ambil extensionya
            
            if(in_array($ekstensi, $extensionList)){
              if ($logo == "") {
              echo "Fatal Error";
              }
              else{ 
                  $dest = 'dist/img/logo' . rand(1, 100) . '.' . $ext;
                  $upload = move_uploaded_file($temp, '../' . $dest);
                  if ($upload) {
                      $exec = $db->update('setting',array('logo' => $dest),$where);
                  } else {
                      echo "gagal";
                  }
                }
            }
            else{
              echo"File Extension Tidak Sesuai";
            }
      }
      if ($_FILES['ttd']['name'] <> '') {
          $logo = $_FILES['ttd']['name'];
          $temp = $_FILES['ttd']['tmp_name'];
          $ext1 = explode('.', $logo);
          $ext = end($ext1);

          $ekstensi = $ext1[1]; //ambil extensionya
            if(in_array($ekstensi, $extensionList)){
              if ($logo == "") {
              echo "Fatal Error";
              }
              else{
                $dest = 'dist/img/ttd'.'.'.$ext;
                $upload = move_uploaded_file($temp, '../' . $dest);
              }
            }
            else{
              echo"File Extension Tidak Sesuai";
            }
              
      }
      if ($_FILES['instansi']['name'] <> '') {
          $logo = $_FILES['instansi']['name'];
          $temp = $_FILES['instansi']['tmp_name'];
          $ext1 = explode('.', $logo);
          $ext = end($ext1);
         
          $ekstensi = $ext1[1]; //ambil extensionya
          if(in_array($ekstensi, $extensionList)){
            if ($logo == "") {
              echo "Fatal Error";
            }
            else{
                $dest = 'dist/img/logo2'.'.'.$ext;
                $upload = move_uploaded_file($temp, '../' . $dest);
            }
          }
          else{
              echo"File Extension Tidak Sesuai";
            }


      }
      if ($_FILES['login_admin']['name'] <> '') {
          $logo = $_FILES['login_admin']['name'];
          $temp = $_FILES['login_admin']['tmp_name'];
          $ext1 = explode('.', $logo);
          $ext = end($ext1);

          $ekstensi = $ext1[1]; //ambil extensionya
            if(in_array($ekstensi, $extensionList)){
              if ($logo == "") {
              echo "Fatal Error";
              }
              else{
                $dest = 'dist/img/loginadmin'.'.'.$ext;
                $upload = move_uploaded_file($temp, '../' . $dest);
              }
            }
            else{
              echo"File Extension Tidak Sesuai";
            }
              
      }
      if ($_FILES['login_siswa']['name'] <> '') {
          $logo = $_FILES['login_siswa']['name'];
          $temp = $_FILES['login_siswa']['tmp_name'];
          $ext1 = explode('.', $logo);
          $ext = end($ext1);

          $ekstensi = $ext1[1]; //ambil extensionya
            if(in_array($ekstensi, $extensionList)){
              if ($logo == "") {
              echo "Fatal Error";
              }
              else{
                $dest = 'dist/img/loginsiswa'.'.'.$ext;
                $upload = move_uploaded_file($temp, '../' . $dest);
              }
            }
            else{
              echo"File Extension Tidak Sesuai";
            }
              
      }
      
  } else {
      echo "Gagal menyimpan";
  }

}
else{
  jump("$homeurl");
  //echo"keluar";
}