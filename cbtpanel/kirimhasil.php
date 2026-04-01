<?php
require("../config/config.koneksipusat.php");
require '../config/config.database.php';
$idujian = $_GET['id'];

function insert_manual($table,$data=null,$koneksi) {
    $command = 'INSERT INTO '.$table;
    $field = $value = null;
    foreach($data as $f => $v) {
        $field  .= ','.$f;
        $value  .= ", '".$v."'";
    }
    $command .=' ('.substr($field,1).')';
    $command .=' VALUES('.substr($value,1).')';
    //$exec = mysqli_query($koneksi, $command);
    $exec = mysqli_query($koneksi, $command)or die(mysqli_error($koneksi));
    ($exec) ? $status = 1 : $status = 0;
    return $status;
  }
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:index.php') : null;
// if($token == $token1) {
    if ($koneksipusat) {
        $tabel='nilai_pindah';
        $serverpusat = mysqli_fetch_array(mysqli_query($koneksipusat, "SELECT * from server where kode_server='$kodeServer'"));
        if ($serverpusat['status'] == 'aktif') {
            
            
            //kirim nilai
            //SELECT * FROM nilai_pindah WHERE STATUS IS NULL AND id_ujian='$idujian'
            //get data nilai dari local
            $nilai_local = mysqli_query($koneksi, "SELECT * from $tabel where STATUS=0 AND id_ujian=$idujian ");

            //cek data nilai di servre pusat
            $ada=0;
            $no=0;
            //cek apakah ada datanya
            // if (mysqli_num_rows($nilai_local) > 0) {
              foreach($nilai_local as $pusat){
              
                $idujian = $pusat['id_ujian'];
                $idsiswa = $pusat['id_siswa'];
                $cekdatapusat = mysqli_num_rows(mysqli_query($koneksipusat, "SELECT * from nilai_pindah where id_ujian=$idujian AND id_siswa=$idsiswa "));
                  
                  if($cekdatapusat > 0){
                    $ada++;
                    
                  }
                  else{
                      $data_array = array(
                        //"id_nilai"=> $pusat['id_ujian'],
                        "id_ujian"=> $pusat['id_ujian'],
                        "id_mapel"=> $pusat['id_mapel'],
                        "id_siswa"=> $pusat['id_siswa'],
                        "kode_ujian"=> $pusat['kode_ujian'],
                        "KodeMataPelajaran"=> $pusat['KodeMataPelajaran'],
                        "ujian_mulai"=> $pusat['ujian_mulai'],
                        "ujian_berlangsung"=> $pusat['ujian_berlangsung'],
                        "ujian_selesai"=> $pusat['ujian_selesai'],
                        "jml_benar"=> $pusat['jml_benar'],
                        "jml_salah"=> $pusat['jml_salah'],
                        "nilai_esai"=> $pusat['nilai_esai'],
                        "skor"=> $pusat['skor'],
                        "total"=> $pusat['total'],
                        "status"=> 2,
                        "ipaddress"=> $pusat['ipaddress'],
                        "hasil"=> $pusat['hasil'],
                        "jawaban"=> addslashes($pusat['jawaban']),
                        "jawaban_esai"=> addslashes($pusat['jawaban_esai']),
                        "online"=> $pusat['online'],
                        "blok"=> $pusat['blok'],
                        "id_soal"=> $pusat['id_soal'],
                        "id_opsi"=> $pusat['id_opsi'],
                        "id_esai"=> $pusat['id_esai'],
                        "nilai_esai2"=> $pusat['nilai_esai2'],
                        "selesai"=> $pusat['selesai'],
                        "cek_tombol_selesai"=> $pusat['cek_tombol_selesai'],
                        "nilaiPaketSoal"=> $pusat['nilaiPaketSoal'],
                      );
                      $ex= insert_manual('nilai_pindah',$data_array,$koneksipusat);
                      if($ex) {
                        $no++;
                        $sql_local = mysqli_query($koneksi, "update nilai_pindah set status = '1' where id_nilai='$pusat[id_nilai]'");
                      }
                  }
              }
              
              echo $no." Nilai Terkirim ".$ada." Nilai Suda Ada";
            // }
            // else{
            //   echo"Tidak Ada Data Nilai";
            // }
            
        } else {
            echo "server pusat tidak diaktifkan";
        }
    } else {
        echo "server tidak terhubung";
    }
// }else{
//     jump("$homeurl");
//     //exit;
// }
