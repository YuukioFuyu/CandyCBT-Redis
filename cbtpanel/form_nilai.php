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
	
	if($_GET['id_sesi']==null){ $sesi='';}else{ $sesi =$_GET['id_sesi']; }
	if($_GET['id_mapel']==null){ $mapel='';}else{ $mapel =$_GET['id_mapel']; }
	if($_GET['id_ruang']==null){ $ruang='';}else{ $ruang =$_GET['id_ruang']; }
	if($_GET['id_kelas']==null){ $kelas='';}else{ $kelas =$_GET['id_kelas']; }
	
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

	//untuk hitung jumlah siswa beserta nila di filter------------------------
	$nilai_siswa2= $db->form_nilai($mapel,$kelas,$sesi,$ruang);
	
	//pembagian jumlah perhalaman --------------
	$jumlahData = $db->row($nilai_siswa2);
	$jumlahn = '20';
	$n = ceil($jumlahData / $jumlahn);
	
	// $lebarusername = '10%';
	// $lebarnopes = '17%';

?>
<?php 
for ($i = 1; $i <= $n; $i++) : 
		$mulai = $i - 1;
		$batas = ($mulai * $jumlahn);
		$startawal = $batas;
		$batasakhir = $batas + $jumlahn;
?>
<?php if ($i == $n) : ?>
<div class='page'>
	<!--/cover header-->
	<table width='100%'>
		<tr>
			<td width='100'><img src='<?php echo $homeurl.'/dist/img/logo2.png'.'?date='.time(); ?>' height='75'></td>
			<td>
				<CENTER>
					<strong class='f12'>
						REKAPITULASI NILAI <br />
						<?= $setting['nama_ujian']?><br />TAHUN PELAJARAN <?= $ajaran ?>
					</strong>
				</CENTER></td>
			<td width='100'><img src='<?php echo $homeurl.'/'.$setting['logo'].'?date='.time(); ?>' height='75'></td>
		</tr>
	</table>
	<hr>
	<!--/cover header-->
	<table class='detail'>
		<tr>
			<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $setting['sekolah'] ?></span></td>
		</tr>
		<tr>
			<td>KELAS</td><td>:</td><td><span style='width:450px;'>&nbsp;<?= $kelas1['nama'];?></span></td>
		</tr>
		<tr>
			<td>MATA PELAJARAN</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $mapel3['nama'];?> |&nbsp;&nbsp;<?= $bobot_pg; ?>  |&nbsp;&nbsp;<?= $bobot_esai; ?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' >
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
			$nilai_siswa= $db->form_nilai2($mapel,$kelas,$sesi,$ruang,$batas,$jumlahn);
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
				<td align='center'><?= $no++; ?></td>
				<td align='center'>&nbsp;<?= $data['no_peserta'] ?></td>
				<td><?= $data['nama'] ?></td>
				<td align='center'><?= $data['id_kelas'] ?></td>
				<td align='center'><?= $data['sesi'] ?></td>
				<td align='center'><?= $data['ruang'] ?></td>
				<td align='center'><?= $data['skor'] ?></td>
				<td align='center'><?= $data['nilai_esai'] ?></td>
				<td align='center'><?= $total ?></td>
				<td align='center'><?= $data['kkm'] ?></td>
				<td align='center'><?= $lulus ?></td>
			</tr>
		<?php $no++; } ?>
		</tbody>
	</table>
	<!-- BAGIAN TANDA TANGGAN -->
	<div style='padding-left: 50px;'>
		<style type="text/css">
			.panjang{
				width: 200px;
			}
			.panjang_mapel{
				width: 200px;
			}
			.panjang_protek{
				width: 200px;
			}
		</style>
		<br><br>
		<table border='0' width='100%'>
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td width='0.1%'><?= $setting['kecamatan'] ?>, <?= $tgl_ujian2 ?></td>
			</tr>
			<tr>
				<td >Mengetahui,</td>
				<td></td>
				<td >Mengetahui,</td>
				<td ></td>
				<td width='0.1%'>Mengetahui,</td>
			</tr>
			<tr>
				<td>Kepala Sekolah,</td>
				<td width='0%'></td>
				<td>Guru Mapel,</td>
				<td width='0%'></td>
				<td>Proktor/Teknisi,</td><!-- proktor -->
				
			</tr>
			<tr>
				<td class="panjang"><br><br><br><br><br><strong><?= $setting['kepsek'] ?></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_mapel"><br><br><br><br><br><strong><?= $guru['nama'] ?></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_protek"><br><br><br><br><br><strong><?= $setting['protek'] ?></strong></td>
				
			</tr>
			<tr>
				<td>NIP.<?= $setting['nip'] ?></td>
				<td width='0%'></td>
				<td>NIP.<?= $guru['nip'] ?> </td>
				<td width='0%'></td>
				<td>NIP.<?= $setting['nip_protek'] ?> </td>
				
			</tr>
		</table>
	</div>
	<!-- /BAGIAN TANDA TANGGAN -->
	<!-- footernya -->
	<div class='footer'>
		<table width='100%' height='30'>
			<tr>
				<td width='25px' style='border:1px solid black'></td>
				<td width='5px'>&nbsp;</td>
				<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['nama_ujian']) . " " . $setting['sekolah'] ?></td>
				<td width='5px'>&nbsp;</td>
				<td width='25px' style='border:1px solid black'></td>
			</tr>
		</table>
	</div> 
	<!-- /footer -->

</div>
			
</div>
<?php break; ?>
<?php endif; ?>
<!-- tabel ke 2 untuk halaman pertama -->
<div class='page'>
	<!--/cover header-->
	<table width='100%'>
		<tr>
			<td width='100'><img src='<?php echo $homeurl.'/dist/img/logo2.png'.'?date='.time(); ?>' height='75'></td>
			<td>
				<CENTER>
					<strong class='f12'>
						REKAPITULASI NILAI <br />
						<?= $setting['nama_ujian']?><br />TAHUN PELAJARAN <?= $ajaran ?>
					</strong>
				</CENTER></td>
			<td width='100'><img src='<?php echo $homeurl.'/'.$setting['logo'].'?date='.time(); ?>' height='75'></td>
		</tr>
	</table>
	<hr>
	<!--/cover header-->

	<table class='detail'>
		<tr>
			<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $setting['sekolah'] ?></span></td>
		</tr>
		<tr>
			<td>KELAS</td><td>:</td><td><span style='width:450px;'>&nbsp;<?= $kelas1['nama'];?></span></td>
		</tr>
		<tr>
			<td>MATA PELAJARAN</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $mapel3['nama'];?> |&nbsp;&nbsp;<?= $bobot_pg; ?>  |&nbsp;&nbsp;<?= $bobot_esai; ?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%'>
		<thead>
		<tr height=40px>
			<td width='4%' align=center>No</td>
			<td width='20%'  align='center'>No Peserta</td>
			<td align='center'>Nama</td>
			<td width='2%' align='center'>Kelas</td>
			<td width='2%'align='center'>Sesi</td>
			<td width='2%'align='center'>Ruang</td>
				<td width='5%' align='center'>NILAI PG</td>
				<td width='5%' align='center'>NILAI ESSAY</td>
				<td width='5%' align='center'>JUMLAH</td>
				<td width='5%' align='center'>KKM</td>
				<td width='5%' align='center'>STATUS</td>
			</tr>
		</thead>
		<tbody>
			<?php 
			$s = $i - 1;
			$no=1;
			$nilai_siswa= $db->form_nilai2($mapel,$kelas,$sesi,$ruang,$batas,$jumlahn);
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
				<td align='center'><?= $no++; ?></td>
				<td align='center'>&nbsp;<?= $data['no_peserta'] ?></td>
				<td><?= $data['nama'] ?></td>
				<td align='center'><?= $data['id_kelas'] ?></td>
				<td align='center'><?= $data['sesi'] ?></td>
				<td align='center'><?= $data['ruang'] ?></td>
				<td align='center'><?= $data['skor'] ?></td>
				<td align='center'><?= $data['nilai_esai'] ?></td>
				<td align='center'><?= $total ?></td>
				<td align='center'><?= $data['kkm'] ?></td>
				<td align='center'><?= $lulus ?></td>
			</tr>
		<?php $no++; } ?>
		</tbody>
	</table>
	<!-- footernya -->
	<div class='footer'>
		<table width='100%' height='30'>
			<tr>
				<td width='25px' style='border:1px solid black'></td>
				<td width='5px'>&nbsp;</td>
				<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['nama_ujian']) . " " . $setting['sekolah'] ?></td>
				<td width='5px'>&nbsp;</td>
				<td width='25px' style='border:1px solid black'></td>
			</tr>
		</table>
	</div> 
	<!-- /footer -->
</div>
<?php endfor; ?>