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

	$id_ujian = $_GET['m'];
	if(empty($_GET['kls'])){ $kelas2=null;}else{ $kelas2 = $_GET['kls']; }
	if(empty($_GET['jrs'])){  $jrs2=null;}else{ $jrs2 = $_GET['jrs']; }


	$pengawas = fetch($koneksi, 'pengawas', array('id_pengawas' => $id_pengawas));
	$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT DISTINCT * FROM ujian WHERE KodeMataPelajaran ='$id_ujian' GROUP BY KodeMataPelajaran"));


	$mapel2 = mysqli_query($koneksi, "SELECT * FROM ujian WHERE KodeMataPelajaran ='$id_ujian'");

	if (date('m') >= 7 and date('m') <= 12) {
		$ajaran = date('Y') . "/" . (date('Y') + 1);
	} elseif (date('m') >= 1 and date('m') <= 6) {
		$ajaran = (date('Y') - 1) . "/" . date('Y');
	}
	$file = "NILAI_" . $mapel['tgl_ujian'] . "_" . $mapel['slagNama'];
	$file = str_replace(" ", "-", $file);
	$file = str_replace(":", "", $file);
	header("Content-type: application/octet-stream");
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
			<td colspan='3'><?= $mapel['slagNama'] ?></td>
		</tr>
		<tr>
			<td colspan='3'>
				Tanggal Ujian
			</td>
			<td style='vertical-align:middle; text-align:center;'>:</td>
			<td colspan='3'>
				<?= buat_tanggal('D, d M Y', $mapel['tgl_ujian']) ?>
				|
				<?= buat_tanggal('H:i', $mapel['tgl_ujian']) ?>
				-
				<?= buat_tanggal('H:i', $mapel['tgl_selesai']) ?>
			</td>
		</tr>
		<tr>
			<td colspan='3'>Jumlah Soal</td>
			<td style='vertical-align:middle; text-align:center;'>:</td>
			<td style='vertical-align:middle; text-align:left;' colspan='3'>
				<?php 
					foreach ($mapel2 as $value) {
						echo"Paket ".$value['soalPaket']." : ".$value['jml_soal']." | ";
					}
				?>
			</td>
		</tr>
		<!-- <tr>
			<td colspan='2'>
				Kelas
			</td>
			<td style='vertical-align:middle; text-align:center;'>
			:</td>
			<td colspan='2'>$id_kelas</td>
		</tr> -->
	</table><br/>

	<table border='1'>
		<tr style="background-color: #b9b7b7;">
			<td rowspan='1'align='center'>No.</td>
			<td rowspan='1'align='center'>No. Peserta</td>
			<td rowspan='1'align='center'>Nama</td>
			<td rowspan='1'align='center'>Kelas</td>
			<td rowspan='1'align='center' >Lama Ujian</td>
			<td rowspan='1'align='center' >Benar</td>
			<td rowspan='1'align='center' >Salah</td>
			<td rowspan='1'align='center' >Nilai PG</td>
			<td rowspan='1'align='center' >Nilai Essai</td>
			<td rowspan='1'align='center' >Nilai / Skor</td>
			<td rowspan='1'align='center' >Paket</td>
			<td rowspan='1'align='center' >KKM</td>
			<td rowspan='1'align='center' >STATUS</td>
		</tr>
		
		<?php
		if($kelas2 != null and $id_ujian != ""){
			$where = " where id_kelas='".$kelas2."' and b.KodeMataPelajaran='".$id_ujian."'";
		}
		elseif($jrs2 !=null and $id_ujian != ""){
			$where = " where idpk='".$jrs2."' and b.KodeMataPelajaran='".$id_ujian."'";
		}
		else{
			$where = " where b.KodeMataPelajaran='".$id_ujian."'";
		}
		
		$siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa a join $tabel b ON a.id_siswa=b.id_siswa ".$where." ORDER BY id_kelas ASC");
		$betul = array();
		$salah = array();

		foreach ($siswaQ as $siswa) {
			$no++;
			$benar = $salah = 0;
			$skor = $lama = '-';
			$selisih = 0;
			$nilai = fetch($koneksi, $tabel, array('KodeMataPelajaran' => $id_ujian, 'id_siswa' => $siswa['id_siswa']));
			if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
				$selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);
			}
			$total= number_format($nilai['skor']+$nilai['nilai_esai'], 2, '.', '');
		?>
			<tr>
				<td><?= $no ?></td>
				<td><?= $siswa['no_peserta'] ?></td>
				<td><?= $siswa['nama'] ?></td>
				<td><?= $siswa['id_kelas'] ?></td>
				<td><?= lamaujian($selisih) ?></td>
				<td><?= $nilai['jml_benar'] ?></td>
				<td><?= $nilai['jml_salah'] ?></td>
				<td class='str'><?= $nilai['skor'] ?></td>
				<td class='str'><?= $nilai['nilai_esai'] ?></td>
				<td class='str'><?= $total ?></td>
				<td class='str'><?= $siswa['nilaiPaketSoal'] ?></td>
				<td class='str'><?= $mapel['kkm'] ?></td>
				<td class='str'>
				<?php 
				if($total >= $mapel['kkm']){
					echo"Lulus";
				}else{
					echo"-";
				} 
				?></td>
				
			</tr>

		<?php } ?>

	</table>
<?php } else{ jump("$homeurl"); exit; } ?>
