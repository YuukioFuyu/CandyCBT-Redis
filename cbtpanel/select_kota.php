<?php
	require("../config/config.default.php");
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	require("../config/dis.php");
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:login.php'):null;
	error_reporting(0);
	
if (!empty($_GET['q'])){
	if (ctype_digit($_GET['q'])) {
		$query = mysqli_query($koneksi,"SELECT * FROM inf_lokasi where lokasi_propinsi=$_GET[q] and lokasi_kecamatan=0 and lokasi_kelurahan=0 and lokasi_kabupatenkota!=0 order by lokasi_nama");
		echo"<option selected value=''>Pilih Kota/Kab</option>";
		while($d = mysqli_fetch_array($query)){
			echo "<option value='$d[lokasi_kabupatenkota]&prop=$_GET[q]'>$d[lokasi_nama]</option>";
		}


	}
}

if (empty($_GET['kel'])){

	if (!empty($_GET['kec']) and !empty($_GET['prop'])){
		if (ctype_digit($_GET['kec']) and ctype_digit($_GET['prop'])) {
			$query = mysqli_query($koneksi,"SELECT * FROM inf_lokasi where lokasi_propinsi=$_GET[prop] and lokasi_kecamatan!=0 and lokasi_kelurahan=0 and lokasi_kabupatenkota=$_GET[kec] order by lokasi_nama");
			echo"<option selected value=''>Pilih Kecamatan</option>";
			while($d = mysqli_fetch_array($query)){
				echo "<option value='$d[lokasi_kecamatan]&kec=$d[lokasi_kabupatenkota]&prop=$d[lokasi_propinsi]''>$d[lokasi_nama]</option>";
			}
		}
	}
} else {
	if (!empty($_GET['kec']) and !empty($_GET['prop'])){
		if (ctype_digit($_GET['kec']) and ctype_digit($_GET['prop'])) {
			$query = mysqli_query($koneksi,"SELECT * FROM inf_lokasi where lokasi_propinsi=$_GET[prop] and lokasi_kecamatan=$_GET[kel] and lokasi_kelurahan!=0 and lokasi_kabupatenkota=$_GET[kec] order by lokasi_nama");
			echo"<option selected value=''>Pilih Kelurahan/Desa</option>";
			while($d = mysqli_fetch_array($query)){
				echo "<option value='$d[lokasi_kode]'>$d[lokasi_nama]</option>";
			}
		}
	}
}
?>
