<?php

require("../config/config.default.php");
require("../config/config.function.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;

	$id=$_POST['id'];

	// $tabel_login='login';
	// $tabel_pengacak='pengacak';
	// $tabel_nilai='nilai';

		$query = mysqli_query($koneksi, "DELETE FROM login where id_siswa in (".$id.")");
		$query = mysqli_query($koneksi, "DELETE FROM nilai where id_siswa in (".$id.")");
		$query = mysqli_query($koneksi, "DELETE FROM pengacak where id_siswa in (".$id.")");
		if($query){
			echo 1;
		}
		else{
			echo 0;
		}	


	?>
	