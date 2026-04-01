<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
//absen jenis pada tabel databse absensi
//1 untuk absen 
//2 untuk edit sakit izin alpah
if(!isset($_SESSION['id_siswa'])){
  header('location:logout.php');
}else{
 
  //fungsi compres image
    function compress($source, $destination, $quality) {
      $info = getimagesize($source);
      if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);
      elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);
      elseif ($info['mime'] == 'image/jpg') 
        $image = imagecreatefromgif($source);
      elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);
      imagejpeg($image, $destination, $quality);
      return $destination;
    }


  $tgl = date("Y-m-d");
  $date = date('Y-m-d H:i:s');
  $datetime = strtotime($tgl);
  $bulan = date('n',$datetime);
  $id_siswa = $_SESSION['id_siswa'];
  $ektensi = ['jpg','png','jpeg','JPG','JPEG','PNG'];
  $path= 'guru/absen_siswa/'.$bulan.'/'.$id_siswa;


  if (!file_exists($path)) {
   mkdir($path, 0755, true);
  }
  if ($_FILES['file']['name'] <> '') {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if (in_array($ext, $ektensi)) {
      
       

      
      //variabel array untuk di upload
      $where = array(
          'absIdSiswa' => $id_siswa,
          'absTgl' => $tgl,
        );
     
        
        $cek = rowcount($koneksi, 'absensi', $where);



        if ($cek == 0) {
          echo 0;
        } 
        else {
          // //cek jika file adalah gamabar 
          $dest = 'guru/absen_siswa/'.$bulan.'/'.$id_siswa.'/';
          $file2 = $id_siswa.$datetime.'.'. $ext;
          $path = $dest . $file2;
            
          //upload foto ------------------------------------------------------
          $upload = compress($temp, $path, 30); //panggil fungsi compress, 
          //upload foto ------------------------------------------------------
          if($upload){
            $data = array(
            'absFoto' => $file2,
            'absUrlFoto' =>$path,
            'absCreated' => date("Y-m-d h:i:s")
            );
            update($koneksi, 'absensi', $data, $where);
            echo 1;
          }
          else{
            echo 'error';
          }
          
        }
        
    }
    else{
      echo 99;
    }
  }
}
