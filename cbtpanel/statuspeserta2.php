<?php

// include "../config/config.default.php";
include("core/c_admin.php"); 
include "../config/config.function.php";
if($token == $token1) {

if (empty($_GET['kls']) and !empty($_GET['jrs'])) {
  $jrs = $_GET['jrs'];
  $get =" AND s.idpk='$jrs' ";
}
elseif(empty($_GET['jrs']) and !empty($_GET['kls'])){
  $kls = $_GET['kls'];
  $get =" AND s.id_kelas='$kls' ";
}
else{
  $get = '';

}


function waktu($waktu){
    if(($waktu>0) and ($waktu<60)){
        $lama=number_format($waktu,2)." detik";
        return $lama;
    }
    if(($waktu>60) and ($waktu<3600)){
        $detik=fmod($waktu,60);
        $menit=$waktu-$detik;
        $menit=$menit/60;
        $lama=$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
    elseif($waktu >3600){
        $detik=fmod($waktu,60);
        $tempmenit=($waktu-$detik)/60;
        $menit=fmod($tempmenit,60);
        $jam=($tempmenit-$menit)/60;    
        $lama=$jam." Jam ".$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
}
$requestData= $_REQUEST;
$columns = array( 
 0 =>'ujian_mulai', 
 1 =>'selesai', 
 2 => 'ujian_mulai',
 3 => 's.nama',
 4 => 's.id_kelas',
 5 => 'n.id_mapel',
 6 => 'ujian_berlangsung',
 7 => 'n.jml_benar',
 8 => 'n.skor',
 9 => 'n.ipaddress',
 10 => 'n.cek_tombol_selesai',
 11 => 's.nis',
);

$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));
$tglsekarang = date('Y-m-d');
if ($pengawas['level'] == 'admin') { $sqlguru=' ';}else{ $sqlguru=" AND u.id_guru='$_SESSION[id_pengawas]' "; }
  
  $arrayNilaiq = mysqli_query($koneksi, "SELECT *, s.soalPaket as pakesiswa  FROM nilai  n 
    INNER JOIN ujian u ON n.id_ujian=u.id_ujian  
    INNER JOIN siswa s ON s.id_siswa=n.id_siswa 
    WHERE u.status='1' and s.id_siswa<>'' $get $sqlguru");
    $sqlCount = mysqli_num_rows($arrayNilaiq);
    $totalFiltered = $sqlCount;

    
    $sql  = "SELECT * ";
    $sql .= " FROM nilai n";
    $sql .=" INNER JOIN ujian u ON n.id_ujian=u.id_ujian";
    $sql .=" INNER JOIN siswa s ON s.id_siswa=n.id_siswa"; 
    $sql .=" WHERE u.status='1' AND n.id_siswa<>'' $get $sqlguru";
    //if ($pengawas['level'] == 'admin') { }else{ $sql .=" AND c.id_guru='$_SESSION[id_pengawas]' "; }

    //--------Jika ada Post Pencarian  ----------------------------------------------------------
      if (!empty($requestData['search']['value'])) {
        $sql .=" AND ( s.nama LIKE '".$requestData['search']['value']."%' ";    
        $sql .=" OR s.username LIKE '".$requestData['search']['value']."%' )";
      }
      $query1 = mysqli_query($koneksi, $sql) or die($koneksi->error);
      $totalFiltered = mysqli_num_rows($query1);
    
    //------------------------------------------------------------------------------------------
    //limit databaase berdasarkan post dari datatables
    $limit = $requestData['length'] === '-1' ? " " : "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . $limit;
    
    //----------------------------------------------------------------------------------
    
    
    $arrayNilaiq=mysqli_query($koneksi, $sql) or die($koneksi->error);
  


$data =array();
while ($nilai = mysqli_fetch_array($arrayNilaiq)) {
  $tglx = strtotime($nilai['ujian_mulai']);
  $tgl = date('Y-m-d', $tglx);
  if ($tglsekarang >= $tgl) {
    $no++;
    $ket = '';
    $lama = $jawaban = $skor = '--';
    $nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$nilai[id_siswa]'");
    $nilaiC = mysqli_num_rows($nilaiQ);
    if ($nilaiC <> 0) {
      $lama = '';
      if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
        $selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);
        $jam = round((($selisih % 604800) % 86400) / 3600);
        $mnt = round((($selisih % 604800) % 3600) / 60);
        $dtk = round((($selisih % 604800) % 60));
        ($jam <> 0) ? $lama .= "$jam jam " : null;
        ($mnt <> 0) ? $lama .= "$mnt menit " : null;
        ($dtk <> 0) ? $lama .= "$dtk detik " : null;
        $jawaban = "<small class='label bg-green'>$nilai[jml_benar] <i class='fa fa-check'></i></small>  <small class='label bg-red'>$nilai[jml_salah] <i class='fa fa-times'></i></small>";
        $skor = "<small class='label bg-green'>" . number_format($nilai['skor'], 2, '.', '') . "</small>";
        $ket = "<label class='label label-success'>Selesai</label>";
        $btn = "<button onclick='ulang_ujian(" . $nilai['id_nilai'] . ")' class='ulang btn btn-xs btn-danger'>ulang</button>";
      } elseif ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] == '') {
        $selisih = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);
        $jam = round((($selisih % 604800) % 86400) / 3600);
        $mnt = round((($selisih % 604800) % 3600) / 60);
        $dtk = round((($selisih % 604800) % 60));
        ($jam <> 0) ? $lama .= "$jam jam " : null;

        if($nilai['blokirStatus'] == 1){
      
          if($nilai['blok']==0){
            $btn2 = "<button data-aksi='1' data-nilai='$nilai[id_nilai]' data-id='$nilai[id_siswa]' class='block btn btn-xs btn-warning'>blok</button>";
            $ket = "<label class='label label-primary'><i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>&nbsp;Ujian</label>";
          }
          elseif($nilai['blokBukaAdmin']==1){
            $btn2 = "<button data-aksi='1' data-nilai='$nilai[id_nilai]' data-id='$nilai[id_siswa]' class='block btn btn-xs btn-warning'>blok</button>";
            $ket = "<label class='label label-warning'><i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>&nbsp;Proses</label>";
          }
          else{
            $ket = "<label class='label label-danger'>&nbsp;Di Blokir</label>";
            $btn2 = "<button data-aksi='0' data-nilai='$nilai[id_nilai]' data-id='$nilai[id_siswa]' class='block btn btn-xs btn-primary'>buka</button>";
          }
        }
        ($mnt <> 0) ? $lama .= "$mnt menit " : null;
        ($dtk <> 0) ? $lama .= "$dtk detik " : null;
        

        $btn = "<button onclick='selesaikan_ujian(" . $nilai['id_nilai'] . ")' class='btn btn-xs btn-danger'>selesai</button>";
          
      
      }
    }
    $waktu_sedang_ujian =lamaujian($selisih);

    $ujian_berlangsung = strtotime($nilai['ujian_berlangsung']);
    $waktu_sekarang = strtotime(date("Y-m-d H:i:sa"));

    $tombol_selsai = $nilai['tombol_selsai'];
    if($tombol_selsai==1){ $muncul="<small class='label bg-blue'>Aktif</small>"; }
    else{ $muncul="<small class='label bg-red'>Tidak Aktif</small>"; }
    

  //-----------------------------------------------------------------------------------------------------------------------------
  $nestedData = array();
  $nestedData[]=$no;
  if($nilai['blokirStatus'] == 1){ #jika status di blokir
    if($nilai['ujian_selesai'] !=""){ 
      $nestedData[]=$btn;
     }else{ 
      $nestedData[]=$btn." | ".$btn2;
    }
    
  }
  else{
    $nestedData[]=$btn;
  }
  $nestedData[]=$ket;
  $nestedData[]=$nilai['nama'];
  $nestedData[]=$nilai['id_kelas'];
  $nestedData[]="<small class='label bg-red'>$nilai[kode_ujian]</small> <small class='label bg-purple'>$nilai[slagNama]</small> <small class='label bg-blue'>$nilai[level]</small>";
  $nestedData[]=$waktu_sedang_ujian;
  $nestedData[]=$jawaban;
  $nestedData[]=$skor;
  $nestedData[]=$nilai['ipaddress'];
  $nestedData[]=$nilai['soalPaket'];
  $nestedData[]=$muncul;
  //$nestedData[]=$nilai['nis'];


  $data[]=$nestedData;

  } //end if tgl

}
$json_data = array(
  "draw"             => intval($requestData['draw']),
  "recordsTotal"     => intval ($sqlCount),
  "recordsFiltered"  => intval( $totalFiltered ), 
  "recordssFiltered" => $requestData['search']['value'],
  "data"             => $data
  );
echo json_encode($json_data);


}else{
  jump("$homeurl");
  //exit;
}
?>

