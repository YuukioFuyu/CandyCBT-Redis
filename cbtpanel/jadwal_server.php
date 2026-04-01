<?php
require '../config/config.koneksipusat.php';
require '../config/config.database.php';
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
            $jadwal_pusat = mysqli_query($koneksipusat, "SELECT * from ujian where status=1 ");
            $no=0;
            $ada=0;
            // var_dump(mysqli_num_rows($jadwal_pusat));
            if(mysqli_num_rows($jadwal_pusat) > 0){
              foreach($jadwal_pusat as $j){
                $cekdata = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * from ujian where id_ujian='$j[id_ujian]'"));
                if($cekdata > 1){
                  $ada++;
                }
                else{
                  $data_array = array(
                    "id_ujian"=> $j['id_ujian'],
                    "id_pk"=> $j['id_pk'],
                    "id_guru"=> $j['id_guru'],
                    "id_mapel"=> $j['id_mapel'],
                    "kode_ujian"=> $j['kode_ujian'],
                    "KodeMataPelajaran"=> $j['KodeMataPelajaran'],
                    "nama"=> $j['nama'],
                    "slagNama"=> $j['slagNama'],
                    "jml_soal"=> $j['jml_soal'],
                    "jml_esai"=> $j['jml_esai'],
                    "bobot_pg"=> $j['bobot_pg'],
                    "opsi"=> $j['opsi'],
                    "bobot_esai"=> $j['bobot_pg'],
                    "tampil_pg"=> $j['tampil_pg'],
                    "tampil_esai"=> $j['tampil_esai'],
                    "lama_ujian"=> $j['lama_ujian'],
                    "tgl_ujian"=> $j['tgl_ujian'],
                    "tgl_selesai"=> $j['tgl_selesai'],
                    "waktu_ujian"=> $j['waktu_ujian'],
                    //"selesai_ujian" => $waktu_selesai,
                    "level"=> $j['level'],
                    "kelas"=> addslashes($j['kelas']),
                    "siswa"=> addslashes($j['siswa']),
                    "sesi"=> $j['sesi'],
                    "acak"=> $j['acak'],
                    "token"=> $j['token'],
                    "status"=> $j['status'],
                    "hasil"=> $j['hasil'],
                    "kkm"=> $j['kkm'],
                    "ulang"=> $j['ulang'],
                    "tombol_selsai"=> $j['tombol_selsai'],
                    "acak_opsi"=> $j['acak_opsi'],
                    "history"=> $j['history'],
                    "status_reset"=> $j['status_reset'],
                    "jenisSoalUjian"=> $j['jenisSoalUjian'],
                    "soalAgama"=>$j['soalAgama'],
                    "soalAgamaList"=> $j['soalAgamaList'],
                    "soalPaket"=> $j['soalPaket'],
                  );
                  $ex= insert_manual('ujian',$data_array,$koneksi);
                  if($ex) {
                    $no++;
                  }
                }
                
                  
              }
              echo $no." Jadwal Terambil ". $ada." Jadwal Sudah Ada";
            }
            else{
              echo "Tidak Ada Jadwal Yang Aktif";
            }
            
        } else {
            echo "server pusat tidak diaktifkan";
        }
    } else {
        echo "server tidak terhubung";
    }
// }else{
//     jump("$homeurl");
//         //exit;
// }
/*
 try { 
                    $sql = mysqli_query($koneksi, "INSERT INTO ujian (id_ujian,id_pk,
                id_guru,id_mapel,kode_ujian,KodeMataPelajaran,nama,slagNama,jml_soal,jml_esai,bobot_pg,opsi,
                bobot_esai,tampil_pg,tampil_esai,lama_ujian,tgl_ujian,tgl_selesai,waktu_ujian,selesai_ujian,
                level,kelas,siswa,sesi,acak,token,status,hasil,kkm,ulang,tombol_selsai,acak_opsi,historystatus_reset,
                jenisSoalUjian,soalAgama,soalAgamaList,soalPaket)
                values ('$j[id_ujian]','$j[id_pk]','$j[id_guru]','$j[id_mapel]','$j[KodeMataPelajaran]','$j[nama]','$j[slagNama]',
                '$j[jml_soal]','$j[jml_esai]','$j[bobot_pg]',
                '$j[opsi],'$j[bobot_esai]','$j[tampil_pg]','$j[tampil_esai]','$j[lama_ujian]',
                '$j[tgl_ujian]','$j[tgl_selesai]','$j[waktu_ujian]','$j[selesai_ujian]','$j[level]','$j[kelas]','$j[siswa]',
                '$j[sesi]','$j[acak]','$j[token]','$j[status]','$j[hasil]','$j[kkm]','$j[ulang]','$j[tombol_selsai]',
                '$j[acak_opsi]','$j[history]','$j[status_reset]','$j[jenisSoalUjian]','$j[soalAgama]','$j[soalAgamaList]','$j[soalPaket]')")
                or die(mysqli_error($koneksi)); //
                } catch (mysqli_sql_exception $e) { 
                    var_dump($e);
                    exit; 
                } 
*/
/*
// print_r($j['slagNama']);
                // die;
              //   try { 
              //     $sql = mysqli_query($koneksi, "INSERT INTO ujian (id_ujian,id_pk,
              // id_guru,id_mapel,kode_ujian,KodeMataPelajaran,nama,slagNama,jml_soal,jml_esai,bobot_pg,opsi,
              // bobot_esai,tampil_pg,tampil_esai,lama_ujian,
              // level,sesi,acak,token,status,hasil,kkm,ulang,tombol_selsai,acak_opsi,historystatus_reset,
              // jenisSoalUjian,soalAgama,soalAgamaList,soalPaket)
              // values ($j[id_ujian],'$j[id_pk]',$j[id_guru],$j[id_mapel],'$j[KodeMataPelajaran]','$j[nama]','$j[slagNama]',
              // $j[jml_soal],$j[jml_esai],$j[bobot_pg],
              // '$j[opsi],'$j[bobot_esai]','$j[tampil_pg]','$j[tampil_esai]',".$j['lama_ujian'].",
              // '$j[level]','$j[sesi]','$j[acak]','$j[token]','$j[status]','$j[hasil]','$j[kkm]','$j[ulang]','$j[tombol_selsai]',
              // '$j[acak_opsi]','$j[history]','$j[status_reset]','$j[jenisSoalUjian]','$j[soalAgama]','$j[soalAgamaList]','$j[soalPaket]')")
              // or die(mysqli_error($koneksi)); //
              // } catch (mysqli_sql_exception $e) { 
              //     var_dump($e);
              //     exit; 
              // } 
              //   if($sql) {
              //       $no++;
              //   }
*/
