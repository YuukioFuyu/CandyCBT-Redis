<?php
include("core/c_admin.php"); 
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/dis.php");
date_default_timezone_set('Asia/Jakarta');
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;
$idserver = $setting['kode_sekolah'];
echo "<link rel='stylesheet' href='$homeurl/dist/css/cetak.min.css'>";


	if($_GET['kelas']==null){ $kelas='';}else{ $kelas =$_GET['kelas']; $name =$_GET['kelas']; }
	if($_GET['jrs']==null){ $idjrs='';}else{ $idjrs=$_GET['jrs']; $name =$_GET['jrs']; }


// $kelas ='semua';
// $idjrs='TP';

if($kelas=='' and $jrs==''){
	die('Tidak ada data yang dicetak. Cek Kembali !!!');
}
	// tahun pelajaran
if(date('m')>=7 AND date('m')<=12) {
	$ajaran = date('Y')."/".(date('Y')+1);
}elseif(date('m')>=1 AND date('m')<=6) {
	$ajaran = (date('Y')-1)."/".date('Y');
}


	// tampil tabel setting
$setting = $db->v_setting();
	//kelas -------------------------
$kelass= $db->v_kelas($kelas);
foreach ($kelass as $value) {
	$kelas1= $value; 	
} 
	//mapel------------------------
$mapel2= $db->v_mapel($mapel);
foreach ($mapel2 as $value) {
	$mapel3= $value;
}

//untuk ttd kajur atau wali kelas
if($idjrs=='semua'){
	//wali kelas------------------------
	$wali= $db->wali_kelas($kelas);
	foreach ($wali as $value) {
		$wali2= $value;
	}
	$nam_tag= "Wali Kelas";
}

else{
	$kajur= $db->kajur($idjrs);
	foreach ($kajur as $value) {
		$wali2= $value;
	}
	$nam_tag= "Ketua Jurusan";
}



	$tgl_ujian2 = $db->tgl_indo(date('Y-m-d', strtotime($ujian2['tgl_ujian'])));
	
	//pengawas --------------------------------
	$guru= $db->v_pengawas($ujian2['id_guru']);

	
	$nm_mapel2 = $db->load_mapel_title();
	foreach ($nm_mapel2 as $nm) {
		$a[]=$nm['id_mapel'];	
	}
	$row = count($a);
	$colspan = 4 + $row;
	 
$file = "LEGER_" . $name;
$file = str_replace(" ", "-", $file);
$file = str_replace(":", "", $file);
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls"); 
	?> 
<table>
	<tr>
		<td colspan='<?= $colspan; ?>'><b><font size="6"> DAFTAR LEGER NILAI </font></b></td>
	</tr>
	<tr>
		<td colspan='<?= $colspan; ?>'><b><font size="5">Tahun Pelajaran <?= $ajaran; ?> </font></b></td>
	</tr>
</table>
<br>

	<table class='it-grid it-cetak table' width='100%' border="1" >
		<thead >
			<tr style="background-color: #b9b7b7; font-weight: bold; height: 40px;" >
				<th width='4%' align=center>No</th>
				<th width='20%'  align='center'>No Peserta</th>
				<th align='center'>Nama</th>
				<th  align='center'>kelas</th>
				<?php
				$nm_mapel = $db->load_mapel_title();
				foreach ($nm_mapel as $nm) {
					echo "<th style='text-align:center'>$nm[nama]</th>";	
				}
				
				?>
			</thead>
			<tbody>
				<?php 
				$idkls = $kelas1['id_kelas'];
				//pilih siswa berdasarkan id_kelas atau jurusan
				$siswaQ =$db->v_siswa($kelas,$idjrs); ?>
				<?php while ($siswa = mysqli_fetch_array($siswaQ)) : ?>
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
						<?php
						$nm_mapel = $db->load_mapel_title();
						foreach ($nm_mapel as $nm) {
							//pangil nilai siswa berdasarkan id_siswa dan mapel
							$nilai2 = $db->v_nilai2($siswa['id_siswa'],$nm['id_mapel']);	
							$total = $nilai2['skor']+$nilai2['nilai_esai'];
							echo"<td style='text-align:center'>".$total."</td>";
						}
						?>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
		<br/>
				<table border='0'>
					<tr>
						<td style='vertical-align:middle; text-align:center;' colspan='8'>
							Mengetahui, <br/>
							Kepala Sekolah <br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<u><?= $setting['kepsek']?></u><br/>
							NIP. <?= $setting['nip'] ?>
						</td>
						<td style='vertical-align:middle; text-align:center;' colspan='8'>
							<?= $setting['kota']?> , <?= $db->tgl_indo(date('Y-m-d'))?><br/>
							<?= $nam_tag ?><br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<u><?= $wali2['nama'] ?></u><br/>
							NIP. <?= $wali2['nip'] ?>
						</td>
					</tr>
				</table>
