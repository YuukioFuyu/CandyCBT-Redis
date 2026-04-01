<?php

require("../config/config.default.php");
require("../config/config.function.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	$kode=$_POST['kode'];
	//$query = mysqli_query($koneksi, 'delete from login where id_log in ('.$kode.')');
	
	$query = mysqli_query($koneksi, "UPDATE nilai set online=0,selesai=0 where id_siswa in (".$kode.")");
	if($query){
		
		$query1= mysqli_query($koneksi, "DELETE FROM login where id_siswa in (".$kode.")");
		if($query1){
			echo 1;
		}
	}
	else{
		echo 0;
	}


	?>
	