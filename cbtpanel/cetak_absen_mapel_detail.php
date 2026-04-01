<?php
	include("core/c_admin.php"); 
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	require("../config/dis.php");
if($token == $token1) {
	date_default_timezone_set('Asia/Jakarta');
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	
	$idserver = $setting['kode_sekolah'];
	echo "<link rel='stylesheet' href='$homeurl/dist/css/cetak.min.css'>";
	
	$tahun=$_GET['tahun'];
	$bulan=$_GET['bulan'];
	$kelas=$_GET['kelas'];
	$mapel=$_GET['mapel'];
	// tahun pelajaran
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}



	$kalender = CAL_GREGORIAN;
	$bulan2 =date($bulan);
	$tahun2 = date('y');
	$hari2 = cal_days_in_month($kalender,$bulan2,$tahun2);

	// tampil tabel setting
	$setting = $db->v_setting();
  $kelass = $db->getKelasId($kelas);
  $kelas1 = $kelass->fetch_array();
	
	//mata pelajaran dan kelas
	$mapel = $db->getMapelAbsen($mapel);
	$mapel1 = $mapel->fetch_array();
	if($_SESSION['level']=='admin'){ 	$guru = fetch($koneksi, 'pengawas',array('id_pengawas'=>$mapel1['id_pengawas'])); }
	else{ $guru = fetch($koneksi, 'pengawas',array('id_pengawas'=>$_SESSION['id_pengawas'])); }


	//untuk hitung jumlah siswa beserta nila di filter------------------------
	$nilai_siswa2= $db->get_absen_siswa_mapel3();
	
	//pembagian jumlah perhalaman --------------
	$jumlahData = count($nilai_siswa2);
	$jumlahn = '10';
	$n = ceil($jumlahData / $jumlahn);
	
	// $lebarusername = '10%';
	// $lebarnopes = '17%';
?>
<style type="text/css">
	@media print{@page {size: landscape}}
	.landscape{
		margin-top: 20px;
		margin-left: 10px;
		margin-right: 10px;
		margin-bottom: 20px;
	}
	.title2{
		font-size: 30px;
	}
	.border-image {
  border: 1px solid black;
  border-radius: 10px;
}
</style>

<div class="landscape">
	<!--/cover header-->
	<table width='100%' border="0">
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
	<table class='detail' border="0">
		<tr>
			<td>TAHUN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tahun ?></span></td>
			<td rowspan="3" width="400"></td>
			<td rowspan="3"><img class="border-image" width="100" src="<?= $homeurl?>/guru/fotoguru/<?= $guru['id_pengawas']?>/<?= $guru['foto_pengawas']?>"></td>
		</tr>
		<tr>
			<td>BULAN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= strtoupper(bulanIndo($bulan)) ?></span></td>
			
		</tr>
		<tr>
			<td width="170">MATA PELAJARAN</td><td>:</td><td ><span style='width:450px;'>&nbsp;<?= $mapel1['amNamaMapel'];?></span></td>
			
		</tr>
		<tr>
			<td >KELAS</td><td>:</td><td ><span style='width:450px;'>&nbsp;<?= $kelas1['id_kelas'];?></span></td>
			
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' border="1">
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
		<tr height=40px>
			<th width='2%' align=center>No</th>
			<th  width='20%'>NAMA</th>
			<?php for ($i=1; $i <=31 ; $i++) { 
				echo"<th width='2%'>".$i."</th>";
			} ?>
			<th width='1%'>H</th>
			<th width='1%'>A</th>
			<!-- <th width='1%'>B</th> -->
			<th width='1%'>I</th>
			<th width='1%'>T</th>
			<th width='1%'>S</th>
			<!-- <th width='4%'>%</th> -->
			</tr>
		</thead>
		<tbody>
			<?php $no=1; foreach ($nilai_siswa2 as $value) { 
				$total_hari= $value['hadir']+$value['alpha']+$value['bolos']+$value['izin']+$value['telat']+$value['sakit'];
				$total = (($value['hadir']+$value['telat'])*100 )/$total_hari;
			?>
			<tr>
				<td><?= $no++;?></td>
				<td><?= $value['nama']?></td>
				<?php 
				for ($i=1; $i <=31 ; $i++) { 
					echo '<td align="center">'.$value['tgl'.$i].'</td>';
				} ?>
				<td align="center"><?= $value['hadir']?></td>
				<td align="center"><?= $value['alpha']?></td>
				<!-- <td align="center"><?= $value['bolos']?></td> -->
				<td align="center"><?= $value['izin']?></td>
				<td align="center"><?= $value['telat']?></td>
				<td align="center"><?= $value['sakit']?></td>
				<!-- <td align="center"><?= $persen = round($total,0);?> %</td> -->
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<!-- BAGIAN TANDA TANGGAN -->
	<div style='padding-left: 50px;'>
		<style type="text/css">
			.panjang{
				width: 180px;
			}
			
		</style>
		<br><br>
		<table border='0' width='100%'>
			<tr>
				<td ></td>
				<td ><?= $setting['kecamatan'] ?>, <?= $db->tgl_indo(date('Y-m-d')); ?></td>
			</tr>
			
			<tr>
				<td></td>
				<td>Guru Mapel,</td><!-- proktor -->
			</tr>
			<tr>
				<td class="panjang"><br><br><br><strong></strong></td>
				<td class="panjang"><br><br><br><strong><?= $guru['nama'] ?></strong></td>
			</tr>
			<tr>
				<td></td>
				<td >NIP.<?= $guru['nip'] ?> </td>
			</tr>
		</table>
	</div>
	<!-- /BAGIAN TANDA TANGGAN -->
	
</div>
			
</div>
<script>
		//window.print();
</script>
<?php 
}
else{
	jump("$homeurl");
	//exit;
}
?>