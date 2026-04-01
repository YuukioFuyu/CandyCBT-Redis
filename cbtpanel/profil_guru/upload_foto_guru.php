<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
//absen jenis pada tabel databse absensi
//1 untuk absen 
//2 untuk edit sakit izin alpah

  function UploadImageResize($new_name,$file,$dir,$width){
   //direktori gambar
   $vdir_upload = $dir;
   $vfile_upload = $vdir_upload . $_FILES[''.$file.'']["name"];

   //Simpan gambar dalam ukuran sebenarnya
   $upload = move_uploaded_file($_FILES[''.$file.'']["tmp_name"], $dir.$_FILES[''.$file.'']["name"]);

   //identitas file asli
   $im_src = imagecreatefromjpeg($vfile_upload);
   $src_width = imageSX($im_src);
   $src_height = imageSY($im_src);

   //Set ukuran gambar hasil perubahan
   $dst_width = $width;
   $dst_height = ($dst_width/$src_width)*$src_height;

   //proses perubahan ukuran
   $im = imagecreatetruecolor($dst_width,$dst_height);
   imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

   //Simpan gambar
   imagejpeg($im,$vdir_upload . $new_name,100);
   
   //Hapus gambar di memori komputer
   imagedestroy($im_src);
   imagedestroy($im);
   $remove_small = unlink("$vfile_upload");
   if($upload){
    return true;
   }
   else{
    return false;
   }
   
 }

  $date = date('Y-m-d H:i:s');
  $datetime = strtotime($date);
  $idguru = $_SESSION['id_pengawas'];
  $ektensi = ['jpg','png','jpeg','JPG','JPEG','PNG'];
  $path2= '../../guru/fotoguru/'.$idguru;
  if (!file_exists($path2)) {
   mkdir($path2, 0755, true);
  }
  if ($_FILES['foto_guru']['name'] <> '') {
    $file = $_FILES['foto_guru']['name'];
    $temp = $_FILES['foto_guru']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if (in_array($ext, $ektensi)) {
      $dest= '../../guru/fotoguru/'.$idguru.'/';
      $file2 = $idguru.$datetime.'.'. $ext;
      $path = $dest . $file2;
      //$upload = move_uploaded_file($temp, $path);
      //--------------------------------------------
      $new_name=$file2;
      $file='foto_guru'; //name pada inputan type file
      $dir=$dest; //tutjuan file di letakan
      $width=400;//satuan dalam pixel / px
      
      //variabel array untuk di upload
      $where = array(
          'id_pengawas' => $idguru,
        );
      $data = array(
          'foto_pengawas' => $file2,
          'pengawas_created' => date("Y-m-d h:i:s")
        );
      
          $upload = UploadImageResize($new_name,$file,$dir,$width);
          if($upload){
            update($koneksi, 'pengawas', $data, $where);
            echo 1;
          }
          else{
            echo 0;
          }   
    }
    else{
      echo 99;
    }
  }

