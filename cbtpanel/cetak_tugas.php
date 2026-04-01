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
	
	$idtugas=$_GET['id'];
	$id_guru = $_GET['idguru'];

	// tahun pelajaran
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}


	// tampil tabel setting
	$setting = $db->v_setting();
	//tugas -------------------------
	$tugass= $db->getTugas($idtugas);
	foreach ($tugass as $value) {
		$tugas= $value; 	
	} 
	//Pengawas -----------------
	$guru = $db->v_pengawas($id_guru);

	//untuk hitung jumlah siswa beserta nila di filter------------------------
	$nilai_siswa2= $db->getHasilTugas($idtugas);
	
	//pembagian jumlah perhalaman --------------
	$jumlahData = count($nilai_siswa2); //$db->row($nilai_siswa2);
	echo $jumlahData;
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
					<strong class='f12' style="font-size: 20px;">
						DAFTAR NILAI TUGAS SISWA <br />
						<?= $setting['namapjj']?><br />TAHUN PELAJARAN <?= $ajaran ?>
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
			<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $setting['sekolah'] ?></span></td>
		</tr>
		<tr>
			<td>MAPEL</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tugas['mapel'] ?></span></td>
		</tr>
		<tr>
			<td>TUGAS</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tugas['judul'] ?></span></td>
		</tr>
		<tr>
			<td>GURU</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $guru['nama'];?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' >
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
			<tr height=40px>
				<th>NO</th>
				<th>NAMA SISWA</th>
				<th>KELAS</th>
				<th>NILAI</th>
				<th>KET</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=1;
			$siswa = $db->getHasilTugas2($idtugas,$batas,$jumlahn);
			foreach ($siswa as $vl) { ?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<td><?= $vl['namasiswa']?></td>
					<td>
						<?php $dataArray = unserialize($vl['kelas']); foreach ($dataArray as $key => $value){ ?>
							<?= $value ?>
						<?php }?>
					</td>
					<td align='center'><?= $vl['nilai']?></td>
					<td align='center'>Hadir</td>
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
				<td >Mengetahui,</td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td width='0.1%'><?= $setting['kecamatan'] ?>, <?= $db->tgl_indo(date('Y-m-d')); ?></td>
			</tr>
			<tr>
				<td >Kepala Sekolah</td>
				<td></td>
				<td ></td>
				<td ></td>
				<td width='0.1%'>Guru Mapel</td>
			</tr>
			<tr>
				<td></td>
				<td width='0%'></td>
				<td></td>
				<td width='0%'></td>
				<td></td><!-- proktor -->
				
			</tr>
			<tr>
				<td class="panjang"><br><br><br><br><br><strong><?= $setting['kepsek'] ?></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_mapel"><br><br><br><br><br><strong></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_protek"><br><br><br><br><br><strong><?= $guru['nama'];?></strong></td>
				
			</tr>
			<tr>
				<td>NIP.<?= $setting['nip'] ?> </td>
				<td width='0%'></td>
				<td></td>
				<td width='0%'></td>
				<td>NIP.<?= $guru['nip'] ?> </td>
				
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
					<strong class='f12' style="font-size: 20px;">
						DAFTAR NILAI TUGAS SISWA <br />
						<?= $setting['namapjj']?><br />TAHUN PELAJARAN <?= $ajaran ?>
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
			<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $setting['sekolah'] ?></span></td>
		</tr>
		<tr>
			<td>MAPEL</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tugas['mapel'] ?></span></td>
		</tr>
		<tr>
			<td>TUGAS</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tugas['judul'] ?></span></td>
		</tr>
		<tr>
			<td>GURU</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $guru['nama'];?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' >
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
			<tr height=40px>
				<th>NO</th>
				<th>NAMA SISWA</th>
				<th>KELAS</th>
				<th>NILAI</th>
				<th>KET</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=1;
			$siswa = $db->getHasilTugas2($idtugas,$batas,$jumlahn);
			foreach ($siswa as $vl) { ?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<td><?= $vl['namasiswa']?></td>
					<td>
						<?php $dataArray = unserialize($vl['kelas']); foreach ($dataArray as $key => $value){ ?>
							<?= $value ?>
						<?php }?>
					</td>
					<td align='center'><?= $vl['nilai']?></td>
					<td align='center'>Hadir</td>
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