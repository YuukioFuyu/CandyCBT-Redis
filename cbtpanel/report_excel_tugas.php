<?php
include("core/c_admin.php"); 
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/dis.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
echo "<style> .str{ mso-number-format:\@; } </style>";
if($token == $token1) {

$id_tugas = $_GET['id'];
$pengawas = fetch($koneksi, 'pengawas', array('id_pengawas' => $id_pengawas));
//$mapel = fetch($koneksi, 'mapel', array('id_mapel' => null));
$tugas = fetch($koneksi, 'tugas', array('id_tugas' => $id_tugas));

if (date('m') >= 7 and date('m') <= 12) :
	$ajaran = date('Y') . "/" . (date('Y') + 1);
elseif (date('m') >= 1 and date('m') <= 6) :
	$ajaran = (date('Y') - 1) . "/" . date('Y');
endif;

$file = "REKAP NILAI TUGAS" . $tugas['mapel'];
$file = str_replace(" ", "_", $file);
$file = str_replace(":", "", $file);
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls");
?>
	
	
	
<table border="1">
		<tr>
			<td colspan="5">REKAP NILAI TUGAS <?= $tugas['mapel']; ?></td>
		</tr>
		<tr >
			<td colspan="5" >JUDUL TUGAS <?= $tugas['judul']; ?></td>
		</tr>
		<tr>
			<td colspan="5"><?= $setting['sekolah'] ?></td>
		</tr>
</table>
<br>
<table border="1">
	<thead>
		<tr style="border: 1px solid black;border-collapse: collapse">
			<th width='5px'>#</th>
			<th style='text-align:center' >NIS</th>
			<th style='text-align:center'>ID PESERTA</th>
			<th style='text-align:center'>NAMA PSESERTA</th>
			<th style='text-align:center' >NILAI</th>
			<th style='text-align:center'>KELAS</th>
			<th style='text-align:center'>JURUSAN</th>
		</tr>
	</thead>
	<tbody>
		<?php $siswaQ = mysqli_query($koneksi, "SELECT * FROM jawaban_tugas INNER JOIN siswa ON siswa.id_siswa = jawaban_tugas.id_siswa WHERE id_tugas='$id_tugas' ORDER BY nama ASC"); ?>
		<?php while ($siswa = mysqli_fetch_array($siswaQ)) : ?>
			<?php
				$no++;
				?>
			<tr style="border: 1px solid black;border-collapse: collapse">
				<td><?= $no ?></td>
				<td style="text-align:center"><?= $siswa['nis'] ?></td>
				<td><?= $siswa['username'] ?></td>
				<td ><?= $siswa['nama'] ?></td>
				<td ><?= $siswa['nilai'] ?></td>
				<td ><?= $siswa['id_kelas'] ?></td>
				<td ><?= $siswa['idpk'] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<?php } else{ jump("$homeurl"); exit; } ?>