<?php

require("../config/config.default.php");
require("../config/config.function.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;

$kode = $_POST['kode'];

$exec = mysqli_query($koneksi, "DELETE FROM ujian WHERE id_ujian in (" . $kode . ")");

if ($exec) {
	echo 1;
} else {
	echo 0;
}
