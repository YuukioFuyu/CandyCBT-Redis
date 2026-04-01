<?php
require("config/config.function.php");
require("config/functions.crud.php");
include("core/c_user.php"); 

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
  //end fungsi compres image

  $id_tugas = $_POST['id_tugas'];
  $id_guru = $_POST['id_guru'];
  $mapel = $_POST['mapel2'];
  $id_siswa = $_SESSION['id_siswa'];
  $nama_depan = $_SESSION['nama_depan'];
  $jawaban = addslashes($_POST['jawaban']);

  $id_telegram = $_POST['id_telegram'];

  $datetime = date('Y-m-d H:i:s');
  $ektensi = ['jpg','jpeg', 'png', 'docx', 'pdf', 'xlsx', 'xls','ppt','pptx'];
  $path= 'guru/tugas_siswa/'.$id_guru.'/'.$id_tugas;
  if (!file_exists($path)) {
   mkdir($path, 0755, true);
  }
   $file = count(array_filter($_FILES['file']['name']));
  if ($file > 0) {
    $jmlFile = count($_FILES['file']['name']);

    for($i=0; $i < $jmlFile; $i++){
    
      $file = $_FILES['file']['name'][$i];
      $temp = $_FILES['file']['tmp_name'][$i];
      $ext = explode('.', $file);
      $ext = end($ext);
   
      if (in_array($ext, $ektensi)) {
        //cek data extensi file
       
        if($ext =='jpg' or $ext =='png' or $ext =='jpeg'){
          //cek jika file adalah gamabar 
          $dest = 'guru/tugas_siswa/'.$id_guru.'/'.$id_tugas.'/';
          $file2 = $id_tugas. '_' .str_replace(' ', '', $mapel) . '_' . $id_siswa . '_' . $nama_depan.'_'.$i. '.' . $ext;
          $path = $dest . $file2;
          
          //upload foto ------------------------------------------------------
          $upload = compress($temp, $path, 90); //panggil fungsi compress, 
          //upload foto ------------------------------------------------------
        }
        else{
          //jika file adalah dokument atau selain gambar 
          $dest = 'guru/tugas_siswa/'.$id_guru.'/'.$id_tugas.'/';
          $file2 = $id_tugas. '_' .str_replace(' ', '', $mapel) . '_' . $id_siswa . '_' . $nama_depan.'_'.$i. '.' . $ext;
          $path = $dest . $file2;
          $upload = move_uploaded_file($temp, $path);
        }
          
          
          
      } //end if in_array
      $dataArray[]=$file2;
    } //end for looping
    $dataNamaFile =serialize($dataArray);
    //var_dump($data2);

      if ($upload) {
        $data = array(
          'id_tugas' => $id_tugas,
          'id_siswa' => $id_siswa,
          'id_guru' => $id_guru,
          'jawaban' => $jawaban,
          'file' => $dataNamaFile,
          'tgl_dikerjakan' => date("Y-m-d h:i:s")
        );
        $data2 = array(
          'id_tugas' => $id_tugas,
          'id_siswa' => $id_siswa,
          'id_guru' => $id_guru,
          'jawaban' => $jawaban,
          'file' => $dataNamaFile,
        );
        $where = array(
          'id_siswa' => $id_siswa,
          'id_tugas' => $id_tugas,
          'id_guru' => $id_guru,
        );
        $cek = rowcount($koneksi, 'jawaban_tugas', $where);
        if ($cek == 0) {
          insert($koneksi, 'jawaban_tugas', $data);
          
          echo "ok";
        } else {
          update($koneksi, 'jawaban_tugas', $data2, $where);
         
          echo "update";
        }
      } else {
        echo "gagal";
      }
    
  } else {
    $data = array(
      'id_tugas' => $id_tugas,
      'id_siswa' => $id_siswa,
      'id_guru' => $id_guru,
      'jawaban' => $jawaban,
      'tgl_dikerjakan' => date("Y-m-d h:i:s")

    );
    $data2 = array(
      'id_tugas' => $id_tugas,
      'id_siswa' => $id_siswa,
      'id_guru' => $id_guru,
      'jawaban' => $jawaban,
    );
    $where = array(
      'id_siswa' => $id_siswa,
      'id_tugas' => $id_tugas,
      'id_guru' => $id_guru,
    );
    $cek = rowcount($koneksi, 'jawaban_tugas', $where);
    if ($cek == 0) {
      insert($koneksi, 'jawaban_tugas', $data);
      if(!empty($id_telegram)){
        $pesan='---Tugas Sudah Di Kirim ---';
        $cekSend = $dbb->CekAktifSend();
          if($cekSend['botSendTugas']==1){
            $dbb->KirimAbsenTelegram($pesan,$_SESSION['token_bot_telegram'],$id_telegram,$_SESSION['full_nama'],$_SESSION['id_kelas'],$_SESSION['nama_sekolah'],$mapel);
          }
        }
    } else {
      update($koneksi, 'jawaban_tugas', $data2, $where);
      if(!empty($id_telegram)){
        $pesan='---Update Tugas ---';
        $cekSend = $dbb->CekAktifSend();
          if($cekSend['botSendTugas']==1){
            $dbb->KirimAbsenTelegram($pesan,$_SESSION['token_bot_telegram'],$id_telegram,$_SESSION['full_nama'],$_SESSION['id_kelas'],$_SESSION['nama_sekolah'],$mapel);
          }
        }
    }
    echo "ok";
    
  }
 


}
