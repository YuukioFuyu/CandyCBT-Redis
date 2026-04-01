<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");
function export_nilai_ke_excel($id){
 
  $ci = & get_instance();
  $idujian=$id;
  $ujian = $ci->excel->get_row_ujian($idujian); 

  $idkelas =  $ci->session_kelas();
  $idjurusan =  $ci->session_jurusan();  

  $id_mapel = $ujian['id_mapel'];
  if (date('m') >= 7 and date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
  } elseif (date('m') >= 1 and date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
  }
  $file = "NILAI_" . $ujian['tgl_ujian'] . "_" . $ujian['nama'];
  $file = str_replace(" ", "-", $file);
  $file = str_replace(":", "", $file);
  //header("Content-type: application/octet-stream");
  header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  header("Pragma: no-cache");
  header("Expires: 0");
  header("Content-Disposition: attachment; filename=" . $file . ".xls"); 
?>

<style type="text/css">
  .center{
    text-align: center;
  }
</style>
<table border='0'>
  <tr>
    <td colspan='3'>
      Mata Pelajaran
    </td>
    <td style='vertical-align:middle; text-align:center;'>:</td>
    <td colspan='3'><?= $ujian['nama'] ?></td>
  </tr>
  <tr>
    <td colspan='3'>
      Tanggal Ujian
    </td>
    <td style='vertical-align:middle; text-align:center;'>:</td>
    <td colspan='3'>
      <?= buat_tanggal('D, d M Y - H:i', $ujian['tgl_ujian']) ?>
    </td>
  </tr>
  <tr>
    <td colspan='3'>Lama Ujian</td>
    <td style='vertical-align:middle; text-align:center;'>:</td>
    <td style='vertical-align:middle; text-align:left;' colspan='3'><?= $ujian['lama_ujian'] ?> Menit</td>
  </tr>
  <tr>
    <td colspan='3'>Jumlah Soal</td>
    <td style='vertical-align:middle; text-align:center;'>:</td>
    <td style='vertical-align:middle; text-align:left;' colspan='3'><?= $ujian['jml_soal'] ?></td>
  </tr>

</table><br/>

<table border='1'>
  <tr style="background-color: #b9b7b7;">
    <td rowspan='3'align='center'>No.</td>
    <td rowspan='3'align='center'>No. Peserta</td>
    <td rowspan='3'align='center'>Nama</td>
    <td rowspan='3'align='center'>Kelas</td>
    <td rowspan='3'align='center' >Lama Ujian</td>
    <td rowspan='3'align='center' >Benar</td>
    <td rowspan='3'align='center' >Salah</td>
    <td rowspan='3'align='center' >Nilai PG</td>
    <td rowspan='3'align='center' >Nilai Essai</td>
    <td rowspan='3'align='center' >Nilai / Skor</td>
    <td rowspan='3'align='center' >KKM</td>
    <td rowspan='3'align='center' >STATUS</td>
    <td colspan='<?= $ujian['jml_soal'] ?>'class="center" >Kunci Jawaban</td>
  </tr>
  <tr>
    <?php
    for ($num = 1; $num <= $ujian['jml_soal']; $num++) {
      $soal = $ci->excel->get_row_ujian($id_mapel,$num);
      ?>
      <td style="background-color: yellow">
        <?= $num.'.'.$soal['jawaban']
        ?></td> <!-- no urutl soal -->
      <?php } ?>
    </tr>
    <tr>
      <td colspan='<?= $ujian['jml_soal'] ?>'class="center" style="background-color: orange" >Jawaban Siswa</td>
    </tr>
    <?php
   
    $siswaQ = $ci->excel->get_excel_siswa($idkelas,$idjurusan,$idujian);
    $betul = array();
    $salah = array();
    $no=1;
    foreach($siswaQ as $siswa) {
      $no++;
      $benar = $salah = 0;
      $skor = $lama = '-';
      $selisih = 0;
      $nilai = $ci->excel->get_excel_nilai($id_mapel,$siswa->id_siswa);
      if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
        $selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);
      }
      $total= number_format($nilai['skor']+$nilai['nilai_esai'], 2, '.', '');
      ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $siswa->no_peserta ?></td>
        <td><?= $siswa->nama ?></td>
        <td><?= $siswa->id_kelas ?></td>
        <td><?= lamaujian($selisih) ?></td>
        <td><?= $nilai['jml_benar'] ?></td>
        <td><?= $nilai['jml_salah'] ?></td>
        <td class='str'><?= $nilai['skor'] ?></td>
        <td class='str'><?= $nilai['nilai_esai'] ?></td>
        <td class='str'><?= $total ?></td>
        <td class='str'><?= $ujian['kkm'] ?></td>
        <td class='str'>
          <?php 
          if($total >= $ujian['kkm']){
            echo"Lulus";
          }else{
            echo"-";
          } 
          ?></td>
          <?php

          $jawaban = unserialize($nilai['jawaban']);
          foreach ($jawaban as $key => $value) {
            $soal = $ci->excel->get_soal_byid($key);
            $nomor = $soal['nomor'];
            if ($soal) {
              if ($value == $soal['jawaban']) { ?>

                <td style='background:#00FF00;'><?= $soal['nomor'] . $value ?></td>
              <?php } else { ?>

                <td style='background:#FF0000;'><?= $soal['nomor'] . $value ?></td>
              <?php }
            } else { ?>
              <td>-</td>
            <?php }
          }
          ?>
        </tr>

      <?php } ?>

    </table>
<?php } ?>