<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");

function export_nilai_tugas($id){
 
   $ci = & get_instance();
   $idtugas=$id;

   $tugas = $ci->excel->get_tugas_id($idtugas);
   $setting = $ci->excel->setting();
 
  if (date('m') >= 7 and date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
  } elseif (date('m') >= 1 and date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
  }
  $file = "REKAP NILAI TUGAS" . $tugas['mapel'];
  $file = str_replace(" ", "_", $file);
  $file = str_replace(":", "", $file);
  header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  header("Pragma: no-cache");
  header("Expires: 0");
  header("Content-Disposition: attachment; filename=" . $file . ".xlsx");
?>


<table border="1">
    <tr>
      <td colspan="7" align="center"><b>REKAP NILAI TUGAS <?= $tugas['mapel']; ?></b></td>
    </tr>
    <tr>
      <td colspan="7" align="center"><b>JUDUL TUGAS <?= $tugas['judul']; ?></b></td>
    </tr>
    <tr>
      <td colspan="7" align="center"><b><?= $setting['sekolah'] ?></b></td>
    </tr>
</table>
<br>
<table border="1">
  <thead style="background-color: red">
    <tr style="border: 1px solid black;border-collapse: collapse">
      <th width='15px'>#</th>
      <th width='150px' style='text-align:center' >NIS</th>
      <th width='250px' style='text-align:center'>USERNAME PESERTA</th>
      <th width='250px' style='text-align:center'>NAMA PSESERTA</th>
      <th width='150px' style='text-align:center' >NILAI</th>
      <th width='150px'style='text-align:center'>KELAS</th>
      <th width='150px' style='text-align:center'>JURUSAN</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $siswaQ = $ci->excel->get_nilai_tugas($idtugas);?>
    <?php $no=1; foreach ($siswaQ as $siswa) { ?>
      <tr style="border: 1px solid black;border-collapse: collapse">
        <td><?= $no++ ?></td>
        <td style="text-align:center"><?= $siswa->nis ?></td>
        <td><?= $siswa->username ?></td>
        <td ><?= $siswa->nama ?></td>
        <td ><?= $siswa->nilai ?></td>
        <td ><?= $siswa->id_kelas ?></td>
        <td ><?= $siswa->idpk ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<?php } ?>