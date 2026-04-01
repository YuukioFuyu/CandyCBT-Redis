<?php
include("core/c_admin.php"); 
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/dis.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
echo "<style> .str{ mso-number-format:\@; } </style>";

if($token == $token1) {
//digunakan mengganti tujuan nama tabel pada database
$tabel='nilai_pindah';
$getBankSoalPerMapel = $db->getMatapelajaranBerdasarkanNilai();

$id_kelas = $_GET['k'];
$pengawas = fetch($koneksi, 'pengawas', array('id_pengawas' => $id_pengawas));
$mapel = fetch($koneksi, 'mapel', array('id_mapel' => null));
$kelas = fetch($koneksi, 'kelas', array('id_kelas' => $id_kelas));

if (date('m') >= 7 and date('m') <= 12) :
	$ajaran = date('Y') . "/" . (date('Y') + 1);
elseif (date('m') >= 1 and date('m') <= 6) :
	$ajaran = (date('Y') - 1) . "/" . date('Y');
endif;

$file = "REKAP SEMUA NILAI KELAS " . $kelas['nama'];
$file = str_replace(" ", "_", $file);
$file = str_replace(":", "", $file);
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls");
?>
	REKAP NILAI HASIL UJIAN
	<br>
	<?= $setting['sekolah'] ?>
<table border="1">
	<thead>
		<tr style="border: 1px solid black;border-collapse: collapse">
			<th rowspan='3' width='5px'>#</th>
			<th style='text-align:center' rowspan='3'>No Peserta</th>
			<th style='text-align:center' rowspan='3'>Nama Peserta</th>
			<th style='text-align:center' rowspan='3'>Kelas</th>
			<?php
			foreach ($getBankSoalPerMapel as $mapel):
				echo "<th style='text-align:center' colspan='4'>$mapel[nama_mapel]</th>";
			endforeach;
			?>
		</tr>
		<tr>
			<?php
			foreach ($getBankSoalPerMapel as $mapel):
				echo "<th style='text-align:center' colspan='4'>$mapel[kode_ujian]</th>";
			endforeach;
			?>
		</tr>
		<tr>
			<?php
			foreach ($getBankSoalPerMapel as $mapel):
				echo"<th style='text-align:center'>PAKET</th>";
				echo"<th style='text-align:center'>B</th>";
				echo"<th style='text-align:center'>S</th>";
				echo"<th style='text-align:center'>SKOR</th>";

			endforeach;
			?>
		</tr>
	</thead>
	<tbody>
		<?php 
								//get data siswa berdasarkan id kelas
		$siswaQ = $db->v_siswa($id_kelas);
		?>
		<?php foreach ($siswaQ as $siswa) : ?>
			<?php
			$no++;
			$ket = '';
			$esai = $lama = $jawaban = $skor = $total = '--';
			?>
			<tr>
				<td><?= $no ?></td>
				<td style="text-align:center"><?= $siswa['no_peserta'] ?></td>
				<td><?= $siswa['nama'] ?></td>
				<td style="text-align:center"><?= $siswa['id_kelas'] ?></td>
				<?php $getBankSoalGroupBy = $db->getBankSoalGroupBy() ?>
				<?php foreach ($getBankSoalGroupBy as $mapel2): ?>
					<?php 
                    	//getdata nilai siswa berdasarka Id Ujian da Id Siswa 
					$nilai = $db->getNilaiSiswa($siswa['id_siswa'],$mapel2['KodeMapel']);
					?>
					<td style="text-align:center"><?= $nilai['nilaiPaketSoal'] ?></td>
					<td style="text-align:center"><?= $nilai['jml_benar'] ?></td>
					<td style="text-align:center"><?= $nilai['jml_salah'] ?></td>
					<td style="text-align:center"><?= $nilai['skor'] ?></td>
				<?php endforeach; ?>

			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php } else{ jump("$homeurl"); exit; } ?>