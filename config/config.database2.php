<?php

include 'setting_database.php';
$host = $hostdb;
$user = $userdb;
$pass = $passdb;
$debe = $namadb;



$koneksi = mysqli_connect($host, $user, $pass, "");
if ($koneksi) {
	$pilihdb = mysqli_select_db($koneksi, $debe);
	
}
