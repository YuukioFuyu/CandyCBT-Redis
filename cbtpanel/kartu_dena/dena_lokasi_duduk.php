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
  border: red 3px solid;
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



function kartu ($am,$sesibudut,$rngbudut) {
	require("../config/config.database2.php");
	$homeurl = "http://" . $_SERVER['HTTP_HOST'];

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
	        	<?php echo "<img src='../foto/fotosiswa/$a[foto]' class='img'  height='130' width='100' >" ?>
	        </td> <!-- height="120" width="100" -->
	    </tr>
	    <tr>
	        <td><center><?php echo $a['nis']; ?></td>
	          <!-- <td><center><?php //echo $a['id_siswa']; ?></td>  -->
	    </tr>
	    </tbody>
	</table>
<?php } //end fungsi kartu


$jumlahData = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM siswa where sesi = '$sesi' and ruang='$ruang' "));
$jumlahn = 30;
$n = ceil($jumlahData/$jumlahn);

for($i=1;$i<=$n;$i++){ ?>
<table style="border: black 3px solid;">
	<tr>
		<td>
<!-- untuk backgrounya -->
<!-- <div style="background:#999; height:1450px;" > 
	<div style="background:#fff; width:95%; margin:0 auto; padding:20px; height:1440px;"> -->
<?php
$mulai = $i-1;
$batas = ($mulai*$jumlahn);
$startawal = $batas;
$batasakhir = $batas+$jumlahn;

$sesibudut = $sesi;
$rngbudut = $ruang;
//tahun TP
$tgl=getdate();
$thn=$tgl['year'];
$thnlama= $thn-1;

?>
<table class="tb">
	<tr >
		<td><img style="padding-left: 5px;" src='<?php echo '../dist/img/logo2.png'.'?date='.time(); ?> ?>' height="120" width="123"></td>
		<td colspan="5"> <P style="font-size: 25px;" align="center">DENA LOKASI TEMPAT DUDUK <BR><?php echo $set1['header_kartu']; ?><br> <?php echo $set1['sekolah']; ?> <br> Tahun Pelajaran <?= $ajaran ?></P></td>
		<td><img src="../<?= $setting['logo'] ?>" height="120" width="123"/></td>
	</tr>
	<tr><td colspan="7" height=10px;><hr style="margin-top: 0px; margin-bottom: 0px; border-bottom: 4px solid black;"></td></tr>

	<tr height="40px">
		<td width="15%" ></td>
		<td width="10%"></td>
		<td width="15%" colspan="3" class="meja"><center style=" border:1px solid red; color: red; font-size: 20px">MEJA PENGAWAS</td>
			<td width="50"></td>
			<td width="15%"></td>
		</tr>
		<tr><td height=10px;></td></tr>
		<tr>
			<td><center style="font-size: 30px;">Ruang : <br><b style="font-size: 50px;"><?php echo $rngbudut; ?></td><td></td>
				<!-- -------------- -->
				<td align="left" width="15%"><?php if($startawal+1<=$jumlahData){kartu($startawal+1,$sesibudut,$rngbudut);} ?></td>
				<td align="center" width="15%"><?php if($startawal+2<=$jumlahData){kartu($startawal+2,$sesibudut,$rngbudut);} ?></td>
				<td align="right" width="15%"><?php if($startawal+3<=$jumlahData){kartu($startawal+3,$sesibudut,$rngbudut);} ?></td>
				<!-- -------------- -->
				<td></td><td><center style="font-size: 25px;">Sesei Ke: <br><b style="font-size: 50px;"><?php echo $sesibudut; ?></td>
		</tr>
				<tr class="bs"><td></td></tr>
				<tr>
					<td></td><td></td>
					<td align="left" width="15%" ><?php if($startawal+4<=$jumlahData){kartu($startawal+4,$sesibudut,$rngbudut);} ?></td>
					<td align="center" width="15%"><?php if($startawal+5<=$jumlahData){kartu($startawal+5,$sesibudut,$rngbudut);} ?></td>
					<td align="right" width="15%"><?php if($startawal+6<=$jumlahData){kartu($startawal+6,$sesibudut,$rngbudut);} ?></td>
					<td></td><td></td>
				</tr>
				

				</tr>
</table>

	</td>	
	</tr>
	</table>
<!-- 	</div>
  </div> -->
<?php } //looping for ?> 


<!-- <tr class="bs"><td></td></tr>
				<tr>
					<td></td><td></td>
					<td align="left" width="15%" ><?php if($startawal+7<=$jumlahData){kartu($startawal+7,$sesibudut,$rngbudut);} ?></td>
					<td width="15%" align="center"><?php if($startawal+8<=$jumlahData){kartu($startawal+8,$sesibudut,$rngbudut);} ?></td>
					<td width="15%" align="right"><?php if($startawal+9<=$jumlahData){kartu($startawal+9,$sesibudut,$rngbudut);} ?></td>
					<td></td><td></td>
				</tr>
				<tr class="bs"><td></td></tr>
				<tr>
					<td></td><td></td>
					<td align="left" width="15%" ><?php if($startawal+10<=$jumlahData){kartu($startawal+10,$sesibudut,$rngbudut);} ?></td>
					<td align="center" width="15%"><?php if($startawal+11<=$jumlahData){kartu($startawal+11,$sesibudut,$rngbudut);} ?></td>
					<td align="right" width="15%"><?php if($startawal+12<=$jumlahData){kartu($startawal+12,$sesibudut,$rngbudut);} ?></td>
					<td></td><td></td>
				</tr>
				<tr class="bs"><td></td></tr>
				<tr>
					<td></td><td></td>
					<td align="left" width="15%" ><?php if($startawal+13<=$jumlahData){kartu($startawal+13,$sesibudut,$rngbudut);} ?></td>
					<td align="center" width="15%"><?php if($startawal+14<=$jumlahData){kartu($startawal+14,$sesibudut,$rngbudut);} ?></td>
					<td align="right" width="15%"><?php if($startawal+15<=$jumlahData){kartu($startawal+15,$sesibudut,$rngbudut);} ?></td>
					<td></td><td></td>
				</tr>
				<tr class="bs"><td></td></tr>
				<tr>
					<td></td><td></td>
					<td align="left" width="15%" ><?php if($startawal+16<=$jumlahData){kartu($startawal+16,$sesibudut,$rngbudut);} ?></td>
					<td align="center" width="15%"><?php if($startawal+17<=$jumlahData){kartu($startawal+17,$sesibudut,$rngbudut);} ?></td>
					<td align="right" width="15%"><?php if($startawal+18<=$jumlahData){kartu($startawal+18,$sesibudut,$rngbudut);} ?></td>
					<td colspan="2"><center style="font-size: 30px;">Jumlah Siswa <br><b style="font-size: 45px;"><?php echo $jumlahData; ?></td>
					</tr>
					<tr>
						<td></td><td></td>
						<td align="left" width="15%" ><?php if($startawal+19<=$jumlahData){kartu($startawal+19,$sesibudut,$rngbudut);} ?></td>
						<td align="center" width="15%"><?php if($startawal+20<=$jumlahData){kartu($startawal+20,$sesibudut,$rngbudut);} ?></td>
						<td align="right" width="15%"><?php if($startawal+21<=$jumlahData){kartu($startawal+21,$sesibudut,$rngbudut);} ?></td>
						<td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td>
						<td align="left" width="15%" ><?php if($startawal+22<=$jumlahData){kartu($startawal+19,$sesibudut,$rngbudut);} ?></td>
						<td align="center" width="15%"><?php if($startawal+23<=$jumlahData){kartu($startawal+20,$sesibudut,$rngbudut);} ?></td>
						<td align="right" width="15%"><?php if($startawal+24<=$jumlahData){kartu($startawal+21,$sesibudut,$rngbudut);} ?></td>
						<td></td><td></td>
					</tr> -->
					<!-- <tr>
						<td></td><td></td>
						<td align="left" width="15%" ><?php //if($startawal+25<=$jumlahData){kartu($startawal+19,$sesibudut,$rngbudut);} ?></td>
						<td align="center" width="15%"><?php //if($startawal+26<=$jumlahData){kartu($startawal+20,$sesibudut,$rngbudut);} ?></td>
						<td align="right" width="15%"><?php //if($startawal+27<=$jumlahData){kartu($startawal+21,$sesibudut,$rngbudut);} ?></td>
						<td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td>
						<td align="left" width="15%" ><?php //if($startawal+28<=$jumlahData){kartu($startawal+19,$sesibudut,$rngbudut);} ?></td>
						<td align="center" width="15%"><?php //if($startawal+29<=$jumlahData){kartu($startawal+20,$sesibudut,$rngbudut);} ?></td>
						<td align="right" width="15%"><?php //if($startawal+30<=$jumlahData){kartu($startawal+21,$sesibudut,$rngbudut);} ?></td>
						<td></td><td></td>
					</tr> -->