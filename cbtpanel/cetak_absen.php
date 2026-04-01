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
	
	$tahun=$_GET['tahun'];
	$bulan=$_GET['bulan'];
	$kelas=$_GET['kelas'];
	
	// tahun pelajaran
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}


	// tampil tabel setting
	$setting = $db->v_setting();
	//kelas -------------------------
	$kelass= $db->getKelasId($kelas);
	foreach ($kelass as $value) {
		$kelas1= $value; 	
	} 

	//absen------------------------------
	$absen= $db->getAbsen();
	foreach ($ujian as $value) {
		
	} //untuk buat waktu tanggal ujian

	
	//untuk hitung jumlah siswa beserta nila di filter------------------------
	$nilai_siswa2= $db->getAbsen();
	
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
			<td width='120'><img src='<?php echo $homeurl.'/dist/img/logo2.png'.'?date='.time(); ?>' height='95'></td>
			<td>
				<CENTER>
					<strong class='f12' style="font-size: 25px;">
						REKAPITULASI ABSEN SISWA <br />
						<?=  strtoupper($setting['namapjj'])?><br />
						<?= strtoupper($setting['sekolah'])?>
						<br>
						TAHUN PELAJARAN <?= $ajaran ?>
					</strong>
				</CENTER></td>
			<td width='120'><img src='<?php echo $homeurl.'/'.$setting['logo'].'?date='.time(); ?>' height='95'></td>
		</tr>
	</table>
	<br>
	<hr>
	<!--/cover header-->
	<table class='detail'>
		<tr>
			<td>TAHUN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tahun ?></span></td>
		</tr>
		<tr>
			<td>BULAN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= strtoupper(bulanIndo($bulan)) ?></span></td>
		</tr>
		<tr>
			<td>KELAS</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $kelas1['nama'];?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' >
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
		<tr height=40px>
			<th width='4%' align=center>No</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>H</th>
			<th>A</th>
			<th>B</th>
			<th>I</th>
			<th>S</th>
			<th>T</th>
			<th>TOTAL</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=1;
			$absen = $db->getAbsen2($batas,$jumlahn);
			$no=1;
			foreach ($absen as $abs ) {
				$total = $abs['hadir']+$abs['alpa']+$abs['bolos']+$abs['izin']+$abs['sakit']+$abs['terlambat'];
				?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<td><?= $abs['namasiswa'] ?></td>
					<td align='center'><?= $abs['nama'] ?></td>
					<td align='center'><?= $abs['hadir'] ?></td>
					<td align='center'><?= $abs['alpa'] ?></td>
					<td align='center'><?= $abs['bolos'] ?></td>
					<td align='center'><?= $abs['izin'] ?></td>
					<td align='center'><?= $abs['sakit'] ?></td>
					<td align='center'><?= $abs['terlambat'] ?></td>
					<td align='center'><?= $total ?></td>
				</tr>
			<?php } ?>
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
				<td width='0.1%'><?= $setting['kecamatan'] ?>, <?= $db->tgl_indo(date('Y-m-d')); ?></td>
			</tr>
			<tr>
				<td ></td>
				<td></td>
				<td ></td>
				<td ></td>
				<td width='0.1%'>Mengetahui,</td>
			</tr>
			<tr>
				<td></td>
				<td width='0%'></td>
				<td></td>
				<td width='0%'></td>
				<td>Kepala Sekolah,</td><!-- proktor -->
				
			</tr>
			<tr>
				<td class="panjang"><br><br><br><br><br><strong></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_mapel"><br><br><br><br><br><strong></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_protek"><br><br><br><br><br><strong><?= $setting['kepsek'] ?></strong></td>
				
			</tr>
			<tr>
				<td></td>
				<td width='0%'></td>
				<td></td>
				<td width='0%'></td>
				<td>NIP.<?= $setting['nip'] ?> </td>
				
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
				<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['sekolah']) ?></td>
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
			<td width='120'><img src='<?php echo $homeurl.'/dist/img/logo2.png'.'?date='.time(); ?>' height='95'></td>
			<td>
				<CENTER>
					<strong class='f12' style="font-size: 25px;">
						REKAPITULASI ABSEN SISWA <br />
						<?=  strtoupper($setting['namapjj'])?><br />
						<?= strtoupper($setting['sekolah'])?>
						<br>
						TAHUN PELAJARAN <?= $ajaran ?>
					</strong>
				</CENTER></td>
			<td width='120'><img src='<?php echo $homeurl.'/'.$setting['logo'].'?date='.time(); ?>' height='95'></td>
		</tr>
	</table>
	<hr>
	<!--/cover header-->
	<table class='detail'>
		<tr>
			<td>TAHUN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tahun ?></span></td>
		</tr>
		<tr>
			<td>BULAN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= strtoupper(bulanIndo($bulan)) ?></span></td>
		</tr>
		<tr>
			<td>KELAS</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $kelas1['nama'];?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' >
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
		<tr height=40px>
			<th width='4%' align=center>No</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>H</th>
			<th>A</th>
			<th>B</th>
			<th>I</th>
			<th>S</th>
			<th>T</th>
			<th>TOTAL</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=1;
			$absen = $db->getAbsen2($batas,$jumlahn);
			$no=1;
			foreach ($absen as $abs ) {
				$total = $abs['hadir']+$abs['alpa']+$abs['bolos']+$abs['izin']+$abs['sakit']+$abs['terlambat'];
				?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<td><?= $abs['namasiswa'] ?></td>
					<td align='center'><?= $abs['nama'] ?></td>
					<td align='center'><?= $abs['hadir'] ?></td>
					<td align='center'><?= $abs['alpa'] ?></td>
					<td align='center'><?= $abs['bolos'] ?></td>
					<td align='center'><?= $abs['izin'] ?></td>
					<td align='center'><?= $abs['sakit'] ?></td>
					<td align='center'><?= $abs['terlambat'] ?></td>
					<td align='center'><?= $total ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<!-- footernya -->
	<div class='footer'>
		<table width='100%' height='30'>
			<tr>
				<td width='25px' style='border:1px solid black'></td>
				<td width='5px'>&nbsp;</td>
				<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['sekolah']) ?></td>
				<td width='5px'>&nbsp;</td>
				<td width='25px' style='border:1px solid black'></td>
			</tr>
		</table>
	</div> 
	<!-- /footer -->

</div>
<?php endfor; ?>