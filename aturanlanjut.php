<?php

//defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
if(!isset($_SESSION['id_siswa'])){
  header('location:logout.php');
}else{

$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
$idmapel = $query['id_mapel'];
$kode_ujian = $query['kode_ujian'];

$tombol_selesai = $query['tombol_selsai'];
$acaksoal = $query['acak'];

$jenis_soal = $query['jenisSoalUjian'];

if($tombol_selesai == 0){ $time=20; }
else{ $time = floor(($query['lama_ujian'] * 60)/ 1.5 ); }//7.200}


$acak_soale = $query['acak'];
$acak_opsi = $query['acak_opsi'];
$jml_opsi = $query['opsi'];
$idSiswa = $_SESSION['id_siswa'];

if($query['status_reset']==1){ $reset=1; }  //jika status reset di ujian aktif
else{ $reset=0; }

//laod jawaban -------------------------------------------------------------------------------- 
$where_jawaban=array(
  'id_ujian' => $ac,
  'id_siswa' => $idSiswa,
  'id_mapel' => $idmapel,
  'jenis' => 1,
);
$where_jawabanEsai=array(
  'id_ujian' => $ac,
  'id_siswa' => $idSiswa,
  'id_mapel' => $idmapel,
  'jenis' => 2,
);

if($jenis_soal==1 or $jenis_soal==3){
    $jawaban_load = select($koneksi, 'jawaban', $where_jawaban);
    foreach ($jawaban_load as $data) :
      $array_jawaban[] = array(
        'idsoal' =>$data['id_soal'],
        'jawaban' =>$data['jawaban'],
        'status' =>1,
        'idsiswa' =>$data['id_siswa'],
        'idmapel' =>$data['id_mapel'],
        'id_ujian' =>$data['id_ujian'],
        'jenissoal' =>$data['jenis'],
      );
    endforeach;
    $jawabanpg = json_encode($array_jawaban);
}
if($jenis_soal==2 or $jenis_soal==3){
    $jawaban_load2 = select($koneksi, 'jawaban', $where_jawabanEsai);
    foreach ($jawaban_load2 as $data) :
      $array_jawaban2[] = array(
        'idsoal' =>$data['id_soal'],
        'jawaban' =>$data['esai'],
        'status' =>1,
        'idsiswa' =>$data['id_siswa'],
        'idmapel' =>$data['id_mapel'],
        'id_ujian' =>$data['id_ujian'],
        'jenissoal' =>$data['jenis'],
      );
    endforeach;
    $jawaban_esai = json_encode($array_jawaban2);
}

//laod jawaban --------------------------------------------------------------------------------

?>

<script>
  var idmapel = <?= $idmapel; ?>;
  localStorage.setItem("idmapel",idmapel); 
  localStorage.setItem("warning",0); 
  localStorage.setItem("jenissoal",<?= $jenis_soal; ?>);
  localStorage.setItem("ragu",JSON.stringify(""));  

  // Waktu untuk tombol Selesai
  var time = <?= $time; ?>;
  sessionStorage.setItem("counter",time);

  <?php if($jenis_soal==1){ ?>
    
    var opsi = <?= $jml_opsi;?>;
    localStorage.setItem("opsi",opsi);
    var jumlahsoal = <?= $query['jml_soal']; ?>;
    localStorage.setItem("jumlahsoal",jumlahsoal);
    // buat storeg Jawaban PG null
    var jawab = <?= $jawabanpg; ?>;
    localStorage.setItem("jwbs",JSON.stringify(jawab));
   
  <?php }
  
  if($jenis_soal==2){ ?>
    var jumlahsoal = <?= $query['jml_esai']; ?>;
    localStorage.setItem("jumlahsoalesai",jumlahsoal);
    var jawabesai = <?= $jawaban_esai; ?>;
    localStorage.setItem("jwbesai",JSON.stringify(jawabesai)); // buat storeg Jawaban Esai null

  <?php } 
  if($jenis_soal==3){ ?>
    //pg ----------------------------
    var opsi = <?= $jml_opsi;?>;
    localStorage.setItem("opsi",opsi);
    var jumlahsoal = <?= $query['jml_soal']; ?>;
    localStorage.setItem("jumlahsoal",jumlahsoal);
    // buat storeg Jawaban PG null
    var jawab = <?= $jawabanpg; ?>;
    localStorage.setItem("jwbs",JSON.stringify(jawab));

    // esai -------------------------
    var jumlahsoalesai = <?= $query['jml_esai']; ?>;
    localStorage.setItem("jumlahsoalesai",jumlahsoalesai);

    var jawabesai = <?= $jawaban_esai; ?>;
    localStorage.setItem("jwbesai",JSON.stringify(jawabesai)); // buat storeg Jawaban Esai null

  <?php } ?>
</script>
<?php } //end if session ?>