<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/config.redis.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;

$id_siswa = $_POST['id'];
$id_nilai = $_POST['nilai'];
$aksi = $_POST['aksi'];

$table='nilai';
$where = array(
	'id_nilai' => $id_nilai
);

if($aksi==1){
	$data = array(
	'blok' =>1
	);
}

else{
	$data = array(
		'blokBukaAdmin' =>1
	);
}


update($koneksi, $table,$data,$where);
