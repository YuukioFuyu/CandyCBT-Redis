<?php

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;

$id = $_POST['id'];

if($id=='acak'){
		//hapus tabel pengacak
	$tabel = 'pengacak';
	$cek = truncate($koneksi, $tabel);
	if($cek==true){
		echo 1;
	}
	else{
		echo 0;
	}
}
else if($id=='login'){ //hapus tabel login
	$tabel ='login';
	$cek = truncate($koneksi, $tabel);
	if($cek==true){
		echo 1;
	}
	else{
		echo 0;
	}

}
else if($id=='login_id'){ //hapus tabel login by id
		$kode=$_POST['data'];
		$query1= mysqli_query($koneksi, "DELETE FROM login where id_siswa in (".$kode.")") or die(mysqli_error($koneksi));
		if($query1){
			echo 1;
		}
		else{
			echo 0 ;
		}
	
}
else if($id=='guru_id'){ //hapus guru by id
		$kode=$_POST['kode'];
		$query1= mysqli_query($koneksi, "DELETE FROM pengawas where id_pengawas in (".$kode.")") or die(mysqli_error($koneksi));
		if($query1){
			echo 1;
		}
		else{
			echo 0 ;
		}
	
}
else{
	echo 3;
}
	

?>
	