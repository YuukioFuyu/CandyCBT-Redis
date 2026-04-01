<?php

require("../config/config.default.php");
require("../config/config.function.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	
$kode = $_POST['id'];
$nilai = mysqli_fetch_array(mysqli_query($koneksi, "select * from nilai where id_nilai='$kode'"));
$skoresai = number_format($_POST['skoresai'], 2, '.', '');
//$total = $nilai['total'] + $skoresai; ,total='$total' 
$query = mysqli_query($koneksi, "UPDATE nilai set nilai_esai='$skoresai'where id_nilai = '$kode'");
if ($query) {
	echo 1;
} else {
	echo 0;
}
