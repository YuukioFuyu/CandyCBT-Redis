<?php
if(!isset($_SESSION['id_siswa'])){
    header('location:logout.php');
  }else{

//defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));

$idmapel = $query['id_mapel']; //id bank soal
$kode_ujian = $query['kode_ujian'];
$statusBlokir = $query['blokir'];

//get bank soal
$mataPelajaran = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel=$idmapel"));
$soalPaket = $mataPelajaran['soalPaket'];

$tombol_selesai = $query['tombol_selsai'];
$acaksoal = $query['acak'];

$jenis_soal = $query['jenisSoalUjian'];

if($tombol_selesai == 0){ $time=20; }
else{ $time = floor(($query['lama_ujian'] * 60)/ 1.5 ); }//7.200}


$acak_soale = $query['acak'];
$acak_opsi = $query['acak_opsi'];
$jml_opsi = $query['opsi'];

$order = array(
    "nomor ASC",
    "nomor DESC",
    "soal ASC",
    "soal DESC",
    "pilA ASC",
    "pilA DESC",
    "pilB ASC",
    "pilB DESC",
    "pilC ASC",
    "pilC DESC",
    "pilD ASC",
    "pilD DESC",
    "pilE ASC",
    "pilE DESC",
    "jawaban ASC",
    "jawaban DESC",
    "file ASC",
    "file DESC"
);
$ordera = array(
    "nomor ASC",
    "nomor DESC",
    "soal ASC",
    "soal DESC",
    "file ASC",
    "file DESC"
);
$where = array(
    'id_mapel' => $idmapel, //mapel PG
    'jenis' => '1',
);
$where2 = array(
    'id_mapel' => $idmapel, //Mapel essai
    'jenis' => '2', 
);

$r = ($acak_soale == 1) ? mt_rand(0, 17) : 0; //acak soal pg
$m = ($acak_soale == 1) ? mt_rand(0, 17) : 0; //acak soal esai

if($query['status_reset']==1){ $reset=1; }  //jika status reset di ujian aktif
else{ $reset=0; }

$soal = selectSoalPgBsMc($koneksi, 'soal', $where, $order[$r]);

$id_soal = '';
$id_esai = '';
$id_opsi = "";
foreach ($soal as $s) :
    if ($jml_opsi == 5) :
        $acz = array("A", "B", "C", "D", "E");
    elseif ($jml_opsi == 4) :
        $acz = array("A", "B", "C", "D");
    elseif ($jml_opsi == 3) :
        $acz = array("A", "B", "C");
    endif;
    shuffle($acz);
    $ack1 = $acz[0];
    $ack2 = $acz[1];
    $ack3 = $acz[2];
    if ($jml_opsi == 3) :
        $id_soal .= $s['id_soal'] . ',';

        //kondisi di acak atau tida mryes
        if ($acak_opsi == 1): //CEK APAKAH PG di status 1 (acak)
            $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',';
        endif;
        if ($acak_opsi == 0):
            $id_opsi .= 'A,B,C,';
        endif;
     

    elseif ($jml_opsi == 4) :
        $ack4 = $acz[3];
        $id_soal .= $s['id_soal'] . ',';
        if ($acak_opsi == 1):
            $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',';
        endif;
        if ($acak_opsi == 0):
            $id_opsi .= 'A,B,C,D,';
        endif;

    elseif ($jml_opsi == 5) :
        $ack4 = $acz[3];
        $ack5 = $acz[4];
        $id_soal .= $s['id_soal'] . ',';
        if ($acak_opsi == 1):
            $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',' . $ack5 . ',';
        endif;
        if ($acak_opsi == 0):
            $id_opsi .= 'A,B,C,D,E,';
        endif;

    endif;
endforeach;
if ($query['jml_esai'] <> 0) {
    $soalesai = select($koneksi, 'soal', $where2, $ordera[$m]);
    foreach ($soalesai as $m) :
        $id_esai .= $m['id_soal'] . ',';
    endforeach;
}

$dataku=array(
    'id_ujian' => $ac,
    'id_siswa' => $id_siswa,
    'id_mapel' => $idmapel,
    'id_soal' => $id_soal,
    'id_opsi' => $id_opsi,
    'id_esai' => $id_esai
);



$logdata = array(
    'id_siswa' => $id_siswa,
    'type' => 'testongoing',
    'text' => 'sedang ujian',
    'date' => $datetime
);
$nilaidata = array(
    'id_mapel' => $idmapel,
    'id_ujian' => $ac,
    'id_siswa' => $id_siswa,
    'kode_ujian' => $kode_ujian,
    'KodeMataPelajaran' =>$mataPelajaran['KodeMapel'],
    'ujian_mulai' => $datetime,
    'ipaddress' => $_SERVER['REMOTE_ADDR'],
    'hasil' => $query['hasil'],
    'online' => $reset,
    'id_soal' => $id_soal,
    'id_opsi' => $id_opsi,
    'id_esai' => $id_esai,
    'nilaiPaketSoal'=>$soalPaket,
    'blokirStatus'  =>$statusBlokir,
);



$insertnilai = insert($koneksi, 'nilai', $nilaidata);
if ($insertnilai) {
    insert($koneksi, 'log', $logdata);
    insert($koneksi, 'pengacak', $dataku);
}



$jawab2 = $a[]=array(''=>'');
$jawabEsai =$b[]=array(''=>'');

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
    var jawab = <?= $jawab2; ?>;
    localStorage.setItem("jwbs",JSON.stringify(jawab));
   
  <?php }
  
  if($jenis_soal==2){ ?>
    var jumlahsoal = <?= $query['jml_esai']; ?>;
    localStorage.setItem("jumlahsoalesai",jumlahsoal);
    var jawabesai = <?= $jawabEsai; ?>;
    localStorage.setItem("jwbesai",JSON.stringify(jawabesai)); // buat storeg Jawaban Esai null

  <?php } 
  if($jenis_soal==3){ ?>
    //pg ----------------------------
    var opsi = <?= $jml_opsi;?>;
    localStorage.setItem("opsi",opsi);
    var jumlahsoal = <?= $query['jml_soal']; ?>;
    localStorage.setItem("jumlahsoal",jumlahsoal);
    // buat storeg Jawaban PG null
    var jawab = <?= $jawab2; ?>;
    localStorage.setItem("jwbs",JSON.stringify(jawab));

    // esai -------------------------
    var jumlahsoalesai = <?= $query['jml_esai']; ?>;
    localStorage.setItem("jumlahsoalesai",jumlahsoalesai);

    var jawabesai = <?= $jawabEsai; ?>;
    localStorage.setItem("jwbesai",JSON.stringify(jawabesai)); // buat storeg Jawaban Esai null

  <?php } ?>
</script>
<?php } //end if session ?>