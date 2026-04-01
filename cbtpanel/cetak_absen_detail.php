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

	//untuk hitung jumlah siswa beserta nila di filter------------------------
	$nilai_siswa2= $db->getAbsenDetail();
	
	//pembagian jumlah perhalaman --------------
	$jumlahData = $db->row($nilai_siswa2);
	$jumlahn = '10';
	$n = ceil($jumlahData / $jumlahn);
	
	// $lebarusername = '10%';
	// $lebarnopes = '17%';
?>
<?php 
$no=1;
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
						REKAPITULASI DETAIL ABSEN SISWA <br />
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
			<?php if($setting['izi_foto_absen'] ==1){ ?><th>FOTO</th><?php } ?>
			<th>NAMA</th>
			<th>KELAS</th>
			<th>TANGGAL</th>
			<th>JAM MASUK</th>
			<th>JAM PULANG</th>
			<th>KETERANGAN</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			
			$absen = $db->getAbsenDetail2($batas,$jumlahn);
			foreach ($absen as $abs ) {
				$total = $abs['hadir']+$abs['alpa']+$abs['bolos']+$abs['izin']+$abs['sakit']+$abs['terlambat'];
				?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<?php if($setting['izi_foto_absen'] ==1){ ?>
					<td>
						<?php if(empty($abs['absUrlFoto'])){ ?>
							<img width="50" src="<?= $homeurl.'/foto/avatar.jpg'?>" class="img-thumbnail img-responsive" alt="Foto Tidak Ada">
						<?php }else{

							?>
							<img width="50" src="<?= $homeurl.'/'.$abs['absUrlFoto'].'?date='.time(); ?>" class="img-thumbnail img-responsive" alt="Foto Tidak Ada">
						<?php } ?>
					</td>
					<?php } ?>
					<td><?= $abs['namasiswa'] ?></td>
					<td><?= $abs['nama'] ?></td>
					<td align='center'><?= date('d-m-Y',strtotime($abs['absTgl'])) ?></td>
					<td align='center'><?= JamNull($abs['absJamIn']) ?></td>
					<td align='center'><?= JamNull($abs['absJamOut']) ?></td>
					<td align='center'> <?= $abs['absStatus'] ?></td>
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
						REKAPITULASI DETAIL ABSEN SISWA <br />
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
			<?php if($setting['izi_foto_absen'] ==1){ ?><th>FOTO</th><?php } ?>
			<th>NAMA</th>
			<th>KELAS</th>
			<th>TANGGAL</th>
			<th>JAM MASUK</th>
			<th>JAM PULANG</th>
			<th>KETERANGAN</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			
			$absen = $db->getAbsenDetail2($batas,$jumlahn);
			foreach ($absen as $abs ) {
				$total = $abs['hadir']+$abs['alpa']+$abs['bolos']+$abs['izin']+$abs['sakit']+$abs['terlambat'];
				?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<?php if($setting['izi_foto_absen'] ==1){ ?>
					<td>
						<?php if(empty($abs['absUrlFoto'])){ ?>
							<img width="50" src="<?= $homeurl.'/foto/avatar.jpg'?>" class="img-thumbnail img-responsive" alt="Foto Tidak Ada">
						<?php }else{

							?>
							<img width="50" src="<?= $homeurl.'/'.$abs['absUrlFoto'].'?date='.time(); ?>" class="img-thumbnail img-responsive" alt="Foto Tidak Ada">
						<?php } ?>
					</td>
					<?php } ?>
					<td><?= $abs['namasiswa'] ?></td>
					<td><?= $abs['nama'] ?></td>
					<td align='center'><?= date('d-m-Y',strtotime($abs['absTgl'])) ?></td>
					<td align='center'><?= JamNull($abs['absJamIn']) ?></td>
					<td align='center'><?= JamNull($abs['absJamOut']) ?></td>
					<td align='center'> <?= $abs['absStatus'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	
</div>
<?php endfor; ?>