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
	
	if($_GET['sesi']==null){ $sesi='';}else{ $sesi =$_GET['sesi']; }
	if($_GET['mapel']==null){ $mapel='';}else{ $mapel =$_GET['mapel']; }
	if($_GET['ruang']==null){ $ruang='';}else{ $ruang =$_GET['ruang']; }
	if($_GET['kelas']==null){ $kelas='';}else{ $kelas =$_GET['kelas']; }
	
	// $kelas ='XIITP';
	// $mapel = 1 ;
	// $ruang = 'semua';
	// $sesi = 'semua';
	
	if($kelas=='' and $mapel==''){
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

	//ujian------------------------------
	$ujian= $ujian= $db->v_ujian_nilai($mapel);;
	foreach ($ujian as $value) {
		$ujian2= $value;
		if($value['bobot_pg']==0){
			$bobot_pg = "";
		}
		else{
			$bobot_pg = "Bobot PG : ".$value['bobot_pg']." %" ;
		}
		if($value['bobot_esai']==0){
			$bobot_esai = "";
		}
		else{
			$bobot_esai = "Bobot Esai : ".$value['bobot_esai']." %" ;
		}


	} //untuk buat waktu tanggal ujian

	$tgl_ujian2 = $db->tgl_indo(date('Y-m-d', strtotime($ujian2['tgl_ujian'])));
	
	//pengawas --------------------------------
	$guru= $db->v_pengawas($ujian2['id_guru']); 

	// //untuk hitung jumlah siswa beserta nila di filter------------------------
	// $nilai_siswa2= $db->form_nilai($mapel,$kelas,$sesi,$ruang);
	
	// //pembagian jumlah perhalaman --------------
	// $jumlahData = $db->row($nilai_siswa2);
	// $jumlahn = '20';
	// $n = ceil($jumlahData / $jumlahn);
	
	// // $lebarusername = '10%';
	// // $lebarnopes = '17%';


$file = "Rekap_Nilai_".$mapel3['nama']."_".$ujian2['tgl_ujian'];
$file = str_replace(" ", "-", $file);
$file = str_replace(":", "", $file);
header("Content-type: application/vnd-ms-excel");
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls"); 
?> 
Mata Pelajaran: <?= $mapel3['nama'] ?><br />
Tanggal Ujian: <?= buat_tanggal('D, d M Y - H:i', $ujian2['tgl_ujian']) ?><br />
Jumlah Soal: <?= $mapel3['jml_soal'] ?><br />

	<table class='it-grid it-cetak' width='100%' border="1" >
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
		<tr height=40px>
			<td width='4%' align=center>No</td>
			<td width='20%'  align='center'>No Peserta</td>
			<td align='center'>Nama</td>
			<td width='2%' align='center'>Kelas</td>
			<td width='2%' align='center'>Sesi</td>
			<td width='2%' align='center'>Ruang</td>
				<td width='5%' align='center'>NILAI PG</td>
				<td width='5%' align='center'>NILAI ESSAY</td>
				<td width='5%' align='center'>JUMLAH</td>
				<td width='5%' align='center'>KKM</td>
				<td width='5%' align='center'>STATUS</td>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=1;
			//jumlah siswa beserta nila di filter per halaman --------------
			$nilai_siswa= $db->form_nilai($mapel,$kelas,$sesi,$ruang);
			foreach ($nilai_siswa as $data) {
				$total = $data['skor']+$data['nilai_esai'];
				if($total >= $data['kkm']){
					$lulus= 'LULUS';
				}
				else{
					$lulus= 'BELUM LULUS';
				}
			?>
			<tr>
				<td align='center'><?= $no; ?></td>
				<td align='center'>&nbsp;<?= $data['no_peserta'] ?></td>
				<td><?= $data['nama'] ?></td>
				<td align='center'><?= $data['id_kelas'] ?></td>
				<td align='center'><?= $data['sesi'] ?></td>
				<td align='center'><?= $data['kode_ruang'] ?></td>
				<td align='center'><?= $data['skor'] ?></td>
				<td align='center'><?= $data['nilai_esai'] ?></td>
				<td align='center'><?= $total ?></td>
				<td align='center'><?= $data['kkm'] ?></td>
				<td align='center'><?= $lulus ?></td>
			</tr>
		<?php $no++; } ?>
		</tbody>
	</table>
