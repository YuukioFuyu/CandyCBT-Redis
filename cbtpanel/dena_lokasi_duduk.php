<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/dis.php");
include "phpqrcode/qrlib.php";
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:index.php') : null;
$sesi = @$_GET['sesi'];
$ruang = @$_GET['ruang'];


?>

<style type="text/css" media="screen">

.meja{
    border: 2px red solid;
}
	.tb {
  /* border: red 3px solid; */
}
.bt-header{
	width: 100%;
}

</style>

<?php
$set = mysqli_query($koneksi, "SELECT * from setting");
$set1 = mysqli_fetch_array($set);

if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}





$jumlahData = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM siswa where sesi = '$sesi' and ruang='$ruang' "));
$jumlahn = 30;
$n = ceil($jumlahData/$jumlahn);

for($i=1;$i<=$n;$i++){ ?>
<table style="border: black 5px solid;">
	<tr>
		<td>
<?php
$jumlahData = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM siswa where sesi = '$sesi' and ruang='$ruang' "));
$sesibudut = $sesi;
$rngbudut = $ruang;
//tahun TP
$tgl=getdate();
$thn=$tgl['year'];
$thnlama= $thn-1;

function kartu ($am,$sesibudut,$rngbudut) {
	require("../config/config.database2.php");

	$sqlam = mysqli_query($koneksi, "SELECT * from 
	(SELECT * from siswa where sesi ='$sesibudut' and ruang='$rngbudut' order by id_siswa  limit $am) as ambil 
	order by id_siswa Desc limit 1");
	$a = mysqli_fetch_array($sqlam);

	?>
	<table style="border:1px solid red; font-family:Arial, Helvetica, sans-serif; font-size:10px"  border="0" >
	    <tbody>
	    <tr>
	        <td><!-- style="filter: grayscale(100%); width: " -->
	        	<!-- <img height="120" width="100"  src="../<?= $setting['logo'] ?>" > -->
	        	<?php echo "<img src='../foto/fotosiswa/$a[foto]' class='img'  height='130' width='80' >" ?>
	        </td> <!-- height="120" width="100" -->
	    </tr>
	    <tr>
	        <td><center><?php echo $a['username']; ?></td>
	          <!-- <td><center><?php //echo $a['id_siswa']; ?></td>  -->
	    </tr>
	    </tbody>
	</table>
<?php } //end fungsi kartu ?>
<table border="0">
<tr >
		<td><img style="padding-left: 5px;" src='<?php echo '../dist/img/logo2.png'.'?date='.time(); ?> ?>' height="120" width="123"></td>
		<td colspan="12" width="100%"> 
			<P style="font-size: 25px;" align="center">DENA LOKASI TEMPAT DUDUK 
			<br><?php echo $set1['header_kartu']; ?>
			<br> <?php echo $set1['sekolah']; ?> 
			<br> Tahun Pelajaran <?= $ajaran ?></P>
		</td>
		<td><img src="../<?= $setting['logo'] ?>" height="120" width="123"/></td>
	</tr>
	
</table>
<hr style="margin-top: 0px; margin-bottom: 0px; border-bottom: 4px solid black; padding-top: 1%;">

<?php 
$nama = "User";
$jumlah_kursi = $jumlahData;
$jumlah_kolom_kursi = 3;
$jumlah_baris_kursi = $jumlah_kursi/$jumlah_kolom_kursi;
$banding = $jumlah_kursi;
?>
<table style="padding-top: 1%;">
		<tr height="40px">
			<td><center style="font-size: 20px;">Ruang<br><b style="font-size: 30px;"><?php echo $rngbudut; ?></td>
				<td width="100%" colspan="<?= $jumlah_kursi ?>" class="meja"><center style=" color: red; font-size: 20px">MEJA PENGAWAS</td>
			<td><center style="font-size: 25px;">Sesi<br><b style="font-size: 30px;"><?php echo $sesibudut; ?></td>
			<td><center style="font-size: 25px;"><?= $nama?><br><b style="font-size: 30px;"><?php echo $jumlahData; ?></td>
		</tr>
</table>

<table class="tb" border="1" style="padding-top: 1%;" width="100%">
	<!-- buat baris  -->
	<?php $limtiId=0; for ($i=1; $i <= $jumlah_baris_kursi; $i++) { 
	?>	
		<tr>
				<!-- -------------- -->
				<td></td>
				<!-- buat kolom -->
				<?php  for ($i2=1; $i2 <= $jumlah_kolom_kursi; $i2++) { 
					$limtiId++;
					if($limtiId == $jumlah_kolom_kursi){ $limtiIdd+1; }
				?>
					<td width="15%"><?php kartu($limtiId,$sesibudut,$rngbudut); ?> <?= $limtiId; ?></td>
				<?php } ?>
				<td></td>
				<!-- -------------- -->
		</tr>
	<?php } ?>
</table>

	</td>	
	</tr>
	</table>
<!-- 	</div>
  </div> -->
<?php } //looping for ?> 


